<?php
// Incluir el archivo de conexión a la base de datos
include_once('conexion.php');

// Obtener la conexión a la base de datos
$conn = getConnection();

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Capturar y sanitizar los datos recibidos
	$nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
	$edad = isset($_POST['edad']) ? (int)$_POST['edad'] : 0;
	$correo = isset($_POST['correo']) ? trim($_POST['correo']) : '';

	// Validar los datos
	if (empty($nombre) || empty($edad) || empty($correo)) {
		echo "Por favor complete todos los campos.";
	} else {
		try {
			// Preparar la consulta para evitar inyección de SQL
			$sql = "INSERT INTO personas (nombre, edad, correo) VALUES (:nombre, :edad, :correo)";
			$stmt = $conn->prepare($sql);

			// Asociar parámetros
			$stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
			$stmt->bindParam(':edad', $edad, PDO::PARAM_INT);
			$stmt->bindParam(':correo', $correo, PDO::PARAM_STR);

			// Ejecutar la consulta
			if ($stmt->execute()) {
				// Redirigir al usuario a la página principal (index.php)
				header("Location: /index.php");
				exit;
			} else {
				// En caso de error al insertar los datos
				echo "Error al registrar los datos.";
			}
		} catch (PDOException $e) {
			// Mostrar mensaje de error en caso de excepción
			echo "Error al registrar los datos: " . $e->getMessage();
		}
	}
}
