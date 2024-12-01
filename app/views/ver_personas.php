<?php
require_once __DIR__ . '/../controllers/PersonaController.php';  // Si necesitas llamar al controlador de persona

// Instanciar el controlador de Persona
$personacontroller = new Personacontroller();
$personas = $personacontroller->obtenerPersonas();  // Obtener las personas
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Personas</title>
    <link rel="stylesheet" href="/SistemaPlanificadorAgronomo/styles/main.css">
</head>
<body>

<h1>Lista de Personas Registradas</h1>

<!-- Si no hay personas, mostrar mensaje -->
<?php if (empty($personas)): ?>
    <p>No se encontraron personas registradas.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Roles</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($personas as $persona): ?>
                <tr>
                    <td><?= htmlspecialchars($persona['nombres']) . " " . htmlspecialchars($persona['apellidos']) ?></td>
                    <td><?= htmlspecialchars($persona['correo']) ?></td>
                    <td><!-- Aquí puedes agregar el rol de la persona si es necesario --></td>
                    <td>
                        <!-- Formulario para asignar rol -->
                        <form action="asignar_rol.php" method="POST">
                            <input type="hidden" name="persona_rut" value="<?= $persona['rut'] ?>">
                            <input type="hidden" name="persona_dv" value="<?= $persona['dv'] ?>">

                            <label for="rol">Asignar Rol:</label>
                            <select name="rol_id" id="rol">
                                <!-- Aquí cargamos los roles de la base de datos -->
                                <?php
                                // Cargar roles desde la base de datos
                                require_once __DIR__ . '/../controllers/RolController.php';
                                $rolController = new RolController();
                                $roles = $rolController->obtenerRoles(); // Método que obtiene los roles

                                foreach ($roles as $rol):
                                ?>
                                    <option value="<?= $rol['id_rol'] ?>"><?= $rol['nombre_rol'] ?></option>
                                <?php endforeach; ?>
                            </select>

                            <button type="submit">Asignar Rol</button>
                        </form>

                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

</body>
</html>


