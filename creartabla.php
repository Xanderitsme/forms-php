<?php
// Incluir el archivo de conexión a la base de datos
include_once('conexion.php');

try {
    // Obtener la conexión a la base de datos
    $conn = getConnection();

    // SQL para crear la tabla 'personas' si no existe
    $sql = "CREATE TABLE IF NOT EXISTS personas (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(100) NOT NULL,
        edad INT(3) NOT NULL,
        correo VARCHAR(100) NOT NULL
    )";

    // Ejecutar la consulta
    $conn->exec($sql);

    // Redirigir al usuario a la página principal
    header("Location: /index.php");
    exit; // Es importante detener la ejecución después de redirigir
} catch (PDOException $e) {
    // Manejar excepciones y mostrar un mensaje de error
    echo "Error al crear la tabla: " . $e->getMessage();
}
