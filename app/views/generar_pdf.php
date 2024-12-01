<?php
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../../fpdf/fpdf.php';
require_once '../controllers/ProyectoController.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['rut']) || !isset($_SESSION['dv'])) {
    die("Acceso no autorizado.");
}

$rut = $_SESSION['rut'];
$dv = $_SESSION['dv'];
$query = $_POST['query'] ?? null;

// Obtener los proyectos activos filtrados por el término de búsqueda
$controller = new ProyectoController();
$proyectos = $query ? $controller->buscarProyectos($query) : $controller->obtenerProyectosActivos($rut, $dv);

// Crear una nueva instancia de FPDF
$pdf = new FPDF('L', 'mm', 'A4'); // Orientación horizontal
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);

// Título del informe
$pdf->Cell(0, 10, 'Informe de Proyectos Activos', 0, 1, 'C');
$pdf->Ln(5);

// Información del usuario
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Usuario: ' . ($_SESSION['nombres'] ?? '') . ' ' . ($_SESSION['apellidos'] ?? ''), 0, 1, 'L');
$pdf->Ln(5);

// Encabezados de la tabla
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(200, 220, 255); // Color de fondo
$pdf->Cell(40, 10, 'Nombre', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Comuna', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Localidad', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Ejecutor', 1, 0, 'C', true);
$pdf->Cell(70, 10, 'Nombre postulante', 1, 1, 'C', true); // Cambiado a "Nombres y Apellidos"

// Establecer fuente para los datos
$pdf->SetFont('Arial', '', 10);

// Agregar proyectos al PDF
foreach ($proyectos as $proyecto) {
    // Concatenar nombre y apellido del beneficiario
    $nombresApellidos = utf8_decode(trim(($proyecto['nombres_beneficiario'] ?? '') . ' ' . ($proyecto['apellidos_beneficiario'] ?? '')));

    $pdf->Cell(40, 10, utf8_decode($proyecto['nombre_proyecto']), 1);
    $pdf->Cell(30, 10, utf8_decode($proyecto['comuna']), 1);
    $pdf->Cell(30, 10, utf8_decode($proyecto['localidad']), 1);
    $pdf->Cell(40, 10, utf8_decode($proyecto['ejecutor']), 1);
    $pdf->Cell(70, 10, $nombresApellidos, 1); // Mostrar nombres y apellidos concatenados
    $pdf->Ln();
}

// Pie de página
$pdf->Ln(10);
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(0, 10, 'Informe generado el ' . date('d/m/Y H:i'), 0, 0, 'R');

// Salida del PDF
ob_end_clean(); // Limpia el buffer de salida antes de generar el PDF
$pdf->Output('I', 'Informe_Proyectos_Activos.pdf');


