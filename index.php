<?php
include('conexion.php');

// Variables para mostrar mensajes de error o éxito
$mensaje = '';

// Comprobar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $edad = $_POST['edad'];
    $correo = $_POST['correo'];

    // Insertar datos en la base de datos
    $sql = "INSERT INTO personas (nombre, edad, correo) VALUES ('$nombre', $edad, '$correo')";

    if ($conn->query($sql) === TRUE) {
        $mensaje = "Nuevo registro creado exitosamente.";
    } else {
        $mensaje = "Error al insertar datos: " . $conn->error;
    }
}

// Consultar todos los registros de la tabla
$sql = "SELECT id, nombre, edad, correo FROM personas";
$result = $conn->query($sql);

// Cerrar la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Personas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        form {
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="number"],
        input[type="email"] {
            padding: 8px;
            margin: 5px 0;
            width: 200px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .mensaje {
            margin-bottom: 20px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <a href="creartabla.php">Crear tabla Personas</a>
    <a href="configurar.php">Configurar conexión a base de datos</a>

    <h1>Formulario de Registro</h1>

    <!-- Mostrar mensaje de éxito o error -->
    <?php if (!empty($mensaje)): ?>
        <div class="mensaje"><?php echo $mensaje; ?></div>
    <?php endif; ?>


    <!-- Formulario para registrar datos -->
    <form method="POST" action="index.php">
        <label for="nombre">Nombre:</label><br>
        <input type="text" id="nombre" name="nombre" required><br><br>

        <label for="edad">Edad:</label><br>
        <input type="number" id="edad" name="edad" required><br><br>

        <label for="correo">Correo electrónico:</label><br>
        <input type="email" id="correo" name="correo" required><br><br>

        <input type="submit" name="submit" value="Registrar">
    </form>

    <!-- Tabla para mostrar los registros -->
    <h2>Registros de Personas</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Edad</th>
            <th>Correo</th>
            <th>Acciones</th>
        </tr>

        <?php
        // Mostrar los registros en la tabla
        if ($result->num_rows > 0) {
            // Salida de cada fila
            while ($row = $result->fetch_assoc()) {
                echo "
		<tr>
		    <td>" . $row["id"] . "</td>
		    <td>" . $row["nombre"] . "</td>
		    <td>" . $row["edad"] . "</td>
		    <td>" . $row["correo"] . "</td>
		    <td>
		    <!-- Formulario para eliminar usuario -->
			<form action='eliminar.php' method='GET' style='display:inline;'>
			    <input type='hidden' name='id' value='" . $row["id"] . "'>
			    <button type='submit' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este usuario?\");'>Eliminar</button>
			</form>
		    </td>
		</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No se han encontrado registros.</td></tr>";
        }
        ?>
    </table>

</body>

</html>