<?php
require_once __DIR__ . '/../models/Proyecto.php';
require_once __DIR__ . '/../core/Database.php';

class ProyectoController {
    private $model;
    private $db;

    public function __construct() {
        $this->model = new Proyecto();
        $this->db = (new Database())->connect();
    }

    /**
     * Obtener todos los proyectos
     * @return array Lista de proyectos
     */
    public function mostrarProyectos() {
        return $this->model->obtenerProyectos();
    }

    /**
     * Buscar proyectos con un término
     * @param string $query Término de búsqueda
     * @return array Proyectos encontrados
     */
    public function buscarProyectos($query) {
        return $this->model->buscarProyectos($query);
    }

    /**
     * Eliminar un proyecto por su código
     * @param string $codigo_proyecto Código único del proyecto
     * @return bool True si se eliminó correctamente
     */
    public function eliminarProyecto($codigo_proyecto) {
        return $this->model->eliminarProyecto($codigo_proyecto);
    }

    public function obtenerProyectoPorCodigo($codigo_proyecto) {
        // Aseguramos que el código sea alfanumérico (se puede alinear con la naturaleza del código)
        if (empty($codigo_proyecto)) {
            return null; // Retorna null si el código está vacío
        }
    
        // Preparar la consulta SQL
        $query = "SELECT * FROM Proyecto WHERE codigo_proyecto = :codigo_proyecto";
        $stmt = $this->db->prepare($query);
    
        // Asegurarnos de que la consulta se prepara correctamente
        if (!$stmt) {
            die("Error en la preparación de la consulta: " . implode(", ", $this->db->errorInfo()));
        }
    
        // Vincular el parámetro
        $stmt->bindParam(':codigo_proyecto', $codigo_proyecto, PDO::PARAM_STR); // Usar PDO::PARAM_STR para códigos alfanuméricos
    
        // Ejecutar la consulta
        $exec_result = $stmt->execute();
    
        // Verificar si la consulta fue exitosa
        if (!$exec_result) {
            die("Error en la ejecución de la consulta: " . implode(", ", $stmt->errorInfo()));
        }
    
        // Obtener el resultado
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    
    
    public function obtenerProyectosActivos($rut, $dv) {
        $sql = "SELECT 
                    p.nombre_proyecto, 
                    p.comuna, 
                    p.localidad, 
                    p.ejecutor, 
                    b.nombres_beneficiario AS nombres_beneficiario, 
                    b.apellidos_beneficiario AS apellidos_beneficiario
                FROM proyecto p
                JOIN beneficiario b 
                    ON p.beneficiario_rut_beneficiario = b.rut_beneficiario
                    AND p.beneficiario_dv = b.dv
                WHERE EXISTS (
                    SELECT 1
                    FROM persona_proyecto pp
                    WHERE pp.proyecto_codigo_proyecto = p.codigo_proyecto
                    AND pp.persona_rut = :rut
                    AND pp.persona_dv = :dv
                )";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':rut', $rut);
        $stmt->bindParam(':dv', $dv);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    

    public function obtenerProyectosActivosPorPersona($rut, $dv) {
        $sql = "SELECT p.* 
                FROM Proyecto p
                INNER JOIN Persona_Proyecto pp ON p.codigo_proyecto = pp.Proyecto_codigo_proyecto
                WHERE pp.Persona_RUT = :rut AND pp.Persona_DV = :dv AND p.estado = 'Activo'";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':rut', $rut, PDO::PARAM_INT);
        $stmt->bindParam(':dv', $dv, PDO::PARAM_STR);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerProyectosAgrupadosPorComuna() {
        return $this->model->obtenerProyectosPorComuna();
    }

    public function obtenerBeneficiariosPorComuna($comuna) {
        $query = "
            SELECT 
                p.codigo_proyecto AS codigo, -- Usar el código del proyecto
                CONCAT(b.nombres_beneficiario, ' ', b.apellidos_beneficiario) AS nombre,
                p.localidad AS localidad,
                p.codigo_proyecto AS proyecto_codigo
            FROM 
                Beneficiario b
            JOIN 
                Proyecto p 
            ON 
                b.RUT_beneficiario = p.Beneficiario_RUT_beneficiario
            AND 
                b.DV = p.Beneficiario_DV
            WHERE 
                p.comuna = :comuna;
        ";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':comuna', $comuna, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function obtenerVisitasPorProyecto($codigo_proyecto) {
        $query = "
            SELECT v.fecha_visita, v.estado_visita, v.id_visita
            FROM Visita v
            WHERE v.id_visita = :codigo_proyecto
        ";
    
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':codigo_proyecto', $codigo_proyecto, PDO::PARAM_STR);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    
    
    /**
     * Crear un proyecto
     * @param array $datos Array asociativo con los datos del proyecto
     * @return bool True si se creó correctamente
     */
    public function crearProyecto($datos) {
        // Verificar si hay datos del beneficiario en la sesión
        if (!isset($_SESSION['beneficiario'])) {
            header("Location: ../../app/views/crear_proyecto.php"); // Redirige al paso 1 si no hay beneficiario
            exit;
        }
    
        // Verificar si hay usuario en la sesión
        if (!isset($_SESSION['rut']) || !isset($_SESSION['dv'])) {
            header("Location: ../../login.php"); // Redirige al login si no hay usuario en sesión
            exit;
        }
    
        try {
            $this->db->beginTransaction();
    
            // Obtener datos del beneficiario desde la sesión
            $beneficiario = $_SESSION['beneficiario'];
            $datos['rut_beneficiario'] = $beneficiario['rut'];
            $datos['dv_beneficiario'] = $beneficiario['dv'];
    
            // Obtener datos de la persona (usuario en sesión)
            $personaRut = $_SESSION['rut'];
            $personaDv = $_SESSION['dv'];
    
            // Crear el proyecto en la base de datos
            $sqlProyecto = "INSERT INTO Proyecto (nombre_proyecto, materialidad, ejecutor, codigo_proyecto, tipo_proyecto, comuna, localidad, estado, Beneficiario_RUT_beneficiario, Beneficiario_DV)
                            VALUES (:nombre_proyecto, :materialidad, :ejecutor, :codigo_proyecto, :tipo_proyecto, :comuna, :localidad, 'Activo', :rut_beneficiario, :dv_beneficiario)";
            $stmtProyecto = $this->db->prepare($sqlProyecto);
            $stmtProyecto->execute($datos);
    
            // Relacionar el proyecto con la persona
            $sqlPersonaProyecto = "INSERT INTO Persona_Proyecto (Persona_RUT, Persona_DV, Proyecto_codigo_proyecto)
                                   VALUES (:personaRut, :personaDv, :codigoProyecto)";
            $stmtPersonaProyecto = $this->db->prepare($sqlPersonaProyecto);
            $stmtPersonaProyecto->execute([
                'personaRut' => $personaRut,
                'personaDv' => $personaDv,
                'codigoProyecto' => $datos['codigo_proyecto']
            ]);
    
            // Confirmar la transacción
            $this->db->commit();
    
            // Limpiar los datos del beneficiario en la sesión
            unset($_SESSION['beneficiario']);
    
            // Redirigir a Proyectos Activos
            header("Location: ../../app/views/proyectos_activos.php");
            exit;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e; // Lanza el error para depuración
        }
    }
    
}

// Manejo del formulario POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        session_start();
        $controller = new ProyectoController();

        if (isset($_POST['accion'])) {
            switch ($_POST['accion']) {
                case 'crear_proyecto':
                    $datos = [
                        'nombre_proyecto' => $_POST['nombre_proyecto'],
                        'materialidad' => $_POST['materialidad'],
                        'ejecutor' => $_POST['ejecutor'],
                        'codigo_proyecto' => $_POST['codigo_proyecto'],
                        'tipo_proyecto' => $_POST['tipo_proyecto'],
                        'comuna' => $_POST['comuna'],
                        'localidad' => $_POST['localidad']
                    ];

                    $controller->crearProyecto($datos);
                    break;

                case 'eliminar':
                    $codigo_proyecto = $_POST['codigo_proyecto'];
                    $controller->eliminarProyecto($codigo_proyecto);
                    header("Location: /SistemaPlanificadorAgronomo/index.php?mensaje=proyecto_eliminado");
                    exit;
            }
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    
    
}





