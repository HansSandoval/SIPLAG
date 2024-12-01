<?php
// Asume que este código se incluye después de tu header existente
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignar imagen a proyecto</title>
    <link rel="stylesheet" href="/SistemaPlanificadorAgronomo/styles/asignar_imagen.css">

</head>
<body>
    <?php include '../../header.php'; ?>


    <div class="assignment-container">
        <div class="form-container">
            <h1 class="form-title">Asignar imagen a proyecto</h1>
            
            <form action="procesar-asignacion.php" method="POST">
                <div class="form-group">
                    <label for="proyecto" class="form-label">Tipo de proyecto</label>
                    <select id="proyecto" name="proyecto" class="form-select" required>
                        <option value="" disabled selected>Riego californiano para</option>
                        <option value="proyecto1">Proyecto 1</option>
                        <option value="proyecto2">Proyecto 2</option>
                        <!-- Agregar más opciones según necesites -->
                    </select>
                </div>

                <div class="form-group">
                    <label for="visita" class="form-label">Visita</label>
                    <input 
                        type="date" 
                        id="visita" 
                        name="visita" 
                        class="form-select"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="comentarios" class="form-label">Comentarios</label>
                    <textarea 
                        id="comentarios" 
                        name="comentarios" 
                        class="form-textarea"
                        placeholder="Ejemplo"
                    ></textarea>
                </div>

                <button type="submit" class="assign-button">Asignar</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('visita').addEventListener('change', function(e) {
            const date = new Date(this.value);
            const formattedDate = date.toLocaleDateString('es-ES', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });
            // Puedes usar formattedDate si necesitas mostrar la fecha en otro formato
        });
    </script>
</body>
</html>