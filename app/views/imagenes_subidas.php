<?php
// Asume que este código se incluye después de tu header existente
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imágenes subidas</title>
    <link rel="stylesheet" href="/SistemaPlanificadorAgronomo/styles/imagenes_subidas.css">

</head>
<body>
    <?php include '../../header.php'; ?>


<div class="container">
    <h2>Imágenes subidas</h2>
    <div class="image-grid">
        <?php
        // Simulamos tener 5 imágenes
        for ($i = 1; $i <= 5; $i++) {
            ?>
            <div class="image-card">
                <div class="image-placeholder">
                    <svg width="50" height="50" viewBox="0 0 24 24" fill="white">
                        <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                    </svg>
                </div>
                <button class="assign-btn" data-image-id="<?php echo $i; ?>">Asignar</button>
            </div>
            <?php
        }
        ?>
    </div>
</div>

<style>
    .container {
        padding: 20px;
    }
    .image-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 20px;
    }
    .image-card {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .image-placeholder {
        width: 150px;
        height: 150px;
        background-color: #000;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 10px;
    }
    .assign-btn {
        background-color: #F0EBF8;
        color: #6B5B95;
        border: none;
        padding: 10px 20px;
        border-radius: 20px;
        cursor: pointer;
        font-weight: bold;
    }
    .assign-btn:hover {
        background-color: #6B5B95;
        color: white;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const assignButtons = document.querySelectorAll('.assign-btn');
    
    assignButtons.forEach(button => {
        button.addEventListener('click', function() {
            const imageId = this.getAttribute('data-image-id');
            // Aquí puedes agregar la lógica para redirigir a la página de asignación
            // Por ejemplo:
            window.location.href = 'asignar_imagen.php?id=' + imageId;
        });
    });
});
</script>