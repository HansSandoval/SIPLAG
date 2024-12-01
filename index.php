<?php
session_start(); // Activa la sesión para manejar los datos del usuario

require_once './app/controllers/PersonaController.php';
require_once './app/controllers/ProyectoController.php';

// Controladores
$personaController = new PersonaController();
$proyectoController = new ProyectoController();

// Obtener el usuario en sesión
$rut = $_SESSION['rut'] ?? null; // RUT almacenado en la sesión
$dv = $_SESSION['dv'] ?? null;   // DV almacenado en la sesión
$usuario = null;

if ($rut && $dv) {
    $usuario = $personaController->obtenerUsuarioActual($rut, $dv); // Obtiene los datos del usuario
}

// Recuperar término de búsqueda desde la URL
$query = $_GET['query'] ?? null;

// Obtener los proyectos según la búsqueda o mostrar todos si no hay búsqueda
$proyectos = $query ? $proyectoController->buscarProyectos($query) : $proyectoController->mostrarProyectos();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Inicio</title>
    <link rel="stylesheet" href="styles/main.css">
</head>
<body>
    <?php include 'header.php'; ?>

<!-- Barra de búsqueda -->
<div class="search-container">
    <form method="GET" action="index.php" class="search-form">
        <input 
            type="text" 
            name="query" 
            class="search-bar" 
            placeholder="Buscar por nombre, comuna o localidad..." 
            value="<?= htmlspecialchars($query ?? '') ?>"
        >
        <button type="submit" class="btn-search">
            <img src="images/search-icon.png" alt=""> 
            Buscar
        </button>
    </form>
</div>


    <!-- Contenedor de tabla -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Comuna</th>
                    <th>Localidad</th>
                    <th>Postulante</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($proyectos)): ?>
                <?php foreach ($proyectos as $proyecto): ?>
                    <tr>
                        <td><?= htmlspecialchars($proyecto['nombre']) ?></td>
                        <td><?= htmlspecialchars($proyecto['comuna']) ?></td>
                        <td><?= htmlspecialchars($proyecto['localidad']) ?></td>
                        <td><?= htmlspecialchars($proyecto['postulante']) ?></td>
                        <td class="actions">
    <form action="./app/controllers/eliminar_proyecto.php" method="POST" style="display:inline;">
        <input type="hidden" name="codigo_proyecto" value="<?= htmlspecialchars($proyecto['codigo_proyecto']) ?>">
        <button type="submit" class="btn-delete">
            <svg xmlns="http://www.w3.org/2000/svg" class="action-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="3 6 5 6 21 6"></polyline>
                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                <line x1="10" y1="11" x2="10" y2="17"></line>
                <line x1="14" y1="11" x2="14" y2="17"></line>
            </svg>
        </button>
    </form>
    <svg xmlns="http://www.w3.org/2000/svg" class="action-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" onclick="location.href='./app/views/editar_proyecto.php?codigo_proyecto=<?= htmlspecialchars($proyecto['codigo_proyecto']); ?>';">
        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
    </svg>
    <svg xmlns="http://www.w3.org/2000/svg" class="action-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" onclick="location.href='./app/views/ver_proyecto.php?codigo_proyecto=<?= htmlspecialchars($proyecto['codigo_proyecto']); ?>';">
        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
        <circle cx="12" cy="12" r="3"></circle>
    </svg>
</td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align: center;">No se encontraron resultados para la búsqueda.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>






