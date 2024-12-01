<?php
require_once __DIR__ . '/../core/Database.php';

class Proyecto {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function obtenerProyectos() {
        $query = "
            SELECT 
                p.codigo_proyecto,
                p.nombre_proyecto,
                p.nombre_proyecto AS nombre,
                p.materialidad,
                p.ejecutor,
                p.comuna,
                p.localidad,
                CONCAT(b.nombres_beneficiario, ' ', b.apellidos_beneficiario) AS postulante
            FROM 
                Proyecto p
            INNER JOIN 
                Beneficiario b 
            ON 
                p.Beneficiario_RUT_beneficiario = b.RUT_beneficiario
        ";
    
        $stmt = $this->db->prepare($query);
        $stmt->execute(); // No se pasan parámetros aquí
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerProyectosActivosPorPersona($rut, $dv) {
        $query = "
            SELECT p.*
            FROM Proyecto p
            INNER JOIN Persona_Proyecto pp ON p.codigo_proyecto = pp.Proyecto_codigo_proyecto
            WHERE pp.Persona_rut = :rut AND pp.Persona_dv = :dv
        ";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':rut', $rut, PDO::PARAM_INT);
        $stmt->bindParam(':dv', $dv, PDO::PARAM_STR);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerProyectosPorComuna() {  // B
        $query = "
            SELECT 
                comuna, 
                COUNT(*) AS cantidad 
            FROM 
                Proyecto 
            GROUP BY 
                comuna
        ";
    
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }    
    

    public function eliminarProyecto($codigo_proyecto) {
        $query = "DELETE FROM Proyecto WHERE codigo_proyecto = :codigo_proyecto";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':codigo_proyecto', $codigo_proyecto, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function buscarProyectos($query) {
        try {
            if (empty($query)) {
                $sql = "
                    SELECT 
                        p.codigo_proyecto,
                        p.nombre_proyecto AS nombre,
                        p.comuna,
                        p.localidad,
                        CONCAT(b.nombres_beneficiario, ' ', b.apellidos_beneficiario) AS postulante
                    FROM 
                        Proyecto p
                    INNER JOIN 
                        Beneficiario b 
                    ON 
                        p.Beneficiario_RUT_beneficiario = b.RUT_beneficiario
                ";
                $stmt = $this->db->prepare($sql);
            } else {
                $sql = "
                    SELECT 
                        p.codigo_proyecto,
                        p.nombre_proyecto AS nombre,
                        p.comuna,
                        p.localidad,
                        CONCAT(b.nombres_beneficiario, ' ', b.apellidos_beneficiario) AS postulante
                    FROM 
                        Proyecto p
                    INNER JOIN 
                        Beneficiario b 
                    ON 
                        p.Beneficiario_RUT_beneficiario = b.RUT_beneficiario
                    WHERE 
                        TRANSLATE(LOWER(p.localidad), 'áéíóúÁÉÍÓÚ', 'aeiouaeiou') ILIKE TRANSLATE(LOWER(:query), 'áéíóúÁÉÍÓÚ', 'aeiouaeiou') OR
                        TRANSLATE(LOWER(p.comuna), 'áéíóúÁÉÍÓÚ', 'aeiouaeiou') ILIKE TRANSLATE(LOWER(:query), 'áéíóúÁÉÍÓÚ', 'aeiouaeiou') OR
                        TRANSLATE(LOWER(p.nombre_proyecto), 'áéíóúÁÉÍÓÚ', 'aeiouaeiou') ILIKE TRANSLATE(LOWER(:query), 'áéíóúÁÉÍÓÚ', 'aeiouaeiou') OR
                        TRANSLATE(LOWER(b.nombres_beneficiario), 'áéíóúÁÉÍÓÚ', 'aeiouaeiou') ILIKE TRANSLATE(LOWER(:query), 'áéíóúÁÉÍÓÚ', 'aeiouaeiou') OR
                        TRANSLATE(LOWER(b.apellidos_beneficiario), 'áéíóúÁÉÍÓÚ', 'aeiouaeiou') ILIKE TRANSLATE(LOWER(:query), 'áéíóúÁÉÍÓÚ', 'aeiouaeiou') OR
                        TRANSLATE(LOWER(CONCAT(b.nombres_beneficiario, ' ', b.apellidos_beneficiario)), 'áéíóúÁÉÍÓÚ', 'aeiouaeiou') ILIKE TRANSLATE(LOWER(:query), 'áéíóúÁÉÍÓÚ', 'aeiouaeiou')
                ";
                $stmt = $this->db->prepare($sql);
                $likeQuery = "%$query%";
                $stmt->bindParam(':query', $likeQuery, PDO::PARAM_STR);
            }
    
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al buscar proyectos: " . $e->getMessage();
            return [];
        }
    }

    /**
     * Crear un nuevo proyecto
     * @param array $datos Datos del proyecto
     * @return bool True si se insertó correctamente
     */
    public function crearProyecto($datos) {
        $query = "
            INSERT INTO Proyecto (
                nombre_proyecto, 
                comuna, 
                localidad, 
                materialidad, 
                ejecutor, 
                codigo_proyecto, 
                tipo_proyecto, 
                Beneficiario_RUT_beneficiario, 
                Beneficiario_DV
            ) VALUES (
                :nombre_proyecto, 
                :comuna, 
                :localidad, 
                :materialidad, 
                :ejecutor, 
                :codigo_proyecto, 
                :tipo_proyecto, 
                :rut_beneficiario, 
                :dv_beneficiario
            )
        ";
        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            ':nombre_proyecto' => $datos['nombre_proyecto'],
            ':comuna' => $datos['comuna'],
            ':localidad' => $datos['localidad'],
            ':materialidad' => $datos['materialidad'],
            ':ejecutor' => $datos['ejecutor'],
            ':codigo_proyecto' => $datos['codigo_proyecto'],
            ':tipo_proyecto' => $datos['tipo_proyecto'],
            ':rut_beneficiario' => $datos['rut_beneficiario'],
            ':dv_beneficiario' => $datos['dv_beneficiario']
        ]);
    }
}
