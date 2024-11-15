<?php
// Incluir la configuración de la base de datos
include_once('conexion.php');

try {
	// Conectar a la base de datos con PDO
	$conn = getConnection();

	// Verificar si la tabla personas existe
	$stmt = $conn->query("SHOW TABLES LIKE 'personas'");
	if ($stmt->rowCount() === 0) {
		header("Location: creartabla.php");
		exit();
	}

	// Variables para mostrar mensajes de error o éxito
	$mensaje = '';

	// Comprobar si se ha enviado el formulario
	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
		// Obtener los datos del formulario
		$nombre = $_POST['nombre'];
		$edad = $_POST['edad'];
		$correo = $_POST['correo'];

		// Insertar datos en la base de datos
		$sql = "INSERT INTO personas (nombre, edad, correo) VALUES (:nombre, :edad, :correo)";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':nombre', $nombre);
		$stmt->bindParam(':edad', $edad);
		$stmt->bindParam(':correo', $correo);

		if ($stmt->execute()) {
			$mensaje = "Nuevo registro creado exitosamente.";
		} else {
			$mensaje = "Error al insertar datos.";
		}
	}

	// Consultar todos los registros de la tabla
	$sql = "SELECT id, nombre, edad, correo FROM personas";
	$stmt = $conn->query($sql);
	$registros = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
	die("Error en la conexión o consulta: " . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Registro de Personas</title>
	<link rel="stylesheet" href="styles.css">
</head>

<body>
	<header>
		<a href="creartabla.php">Crear tabla de personas</a>
		<a href="configurar.php">Configurar base de datos</a>
	</header>

	<h1>Formulario de Registro</h1>

	<!-- Mostrar mensaje de éxito o error -->
	<?php if (!empty($mensaje)): ?>
		<div class="mensaje"><?php echo $mensaje; ?></div>
	<?php endif; ?>

	<!-- Formulario para registrar datos -->
	<form method="POST" action="registrar.php">
		<label for="nombre">Nombre:</label><br>
		<input type="text" id="nombre" name="nombre" required><br><br>

		<label for="edad">Edad:</label><br>
		<input type="number" id="edad" name="edad" required><br><br>

		<label for="correo">Correo electrónico:</label><br>
		<input type="email" id="correo" name="correo" required><br><br>

		<button type="submit">Registrar</button>
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

		<?php if (count($registros) > 0): ?>
			<?php foreach ($registros as $row): ?>
				<tr>
					<td><?php echo $row['id']; ?></td>
					<td><?php echo $row['nombre']; ?></td>
					<td><?php echo $row['edad']; ?></td>
					<td><?php echo $row['correo']; ?></td>
					<td>
						<!-- Formulario para eliminar usuario -->
						<form action='eliminar.php' method='GET' style='display:inline;'>
							<input type='hidden' name='id' value='<?php echo $row["id"]; ?>'>
							<button type='submit' onclick='return confirm("¿Estás seguro de que deseas eliminar este usuario?");'>Eliminar</button>
						</form>
					</td>
				</tr>
			<?php endforeach; ?>
		<?php else: ?>
			<tr>
				<td colspan="5">No se han encontrado registros.</td>
			</tr>
		<?php endif; ?>
	</table>

</body>

</html>