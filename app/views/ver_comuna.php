<?php
function formatearCodigo($codigo) {
    return substr($codigo, 0, 3) . '-' . substr($codigo, 3, 4) . '-' . substr($codigo, 7);
}

require_once '../controllers/ProyectoController.php';

$comuna = isset($_GET['comuna']) ? $_GET['comuna'] : null;

if (!$comuna) {
    die('Comuna no especificada.');
}

$controlador = new ProyectoController();
$beneficiarios = $controlador->obtenerBeneficiariosPorComuna($comuna);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beneficiarios - <?= htmlspecialchars($comuna) ?></title>
    <link rel="stylesheet" href="../../styles/ver_comuna.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <?php include '../../header.php'; ?>
                <div class="user-info">
                    <span class="user-name"><?= htmlspecialchars($nombreUsuario ?? 'Usuario') ?></span>
                    <!-- Add any other user info here -->
                </div>
            </div>
        </div>
    </header>

    <main class="container">
        <h1 class="page-title">Beneficiarios en <?= htmlspecialchars($comuna) ?></h1>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>CÓDIGO</th>
                        <th>NOMBRE</th>
                        <th>LOCALIDAD</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($beneficiarios as $beneficiario): ?>
                    <tr>
                        <td><?= htmlspecialchars(formatearCodigo($beneficiario['codigo'])) ?></td>
                        <td><?= htmlspecialchars($beneficiario['nombre']) ?></td>
                        <td><?= htmlspecialchars($beneficiario['localidad']) ?></td>
                        <td class="actions">
                            <a href="ver_mas.php?id=<?= htmlspecialchars($beneficiario['proyecto_codigo']) ?>" class="action-icon">
                                <img src="/images/ver-mas-icon.svg" alt="Ver más" class="action-icon">
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>