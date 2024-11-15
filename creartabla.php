<?php
include('conexion.php');

$sql = "CREATE TABLE IF NOT EXISTS personas (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    edad INT(3) NOT NULL,
    correo VARCHAR(100) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    header("Location: /index.php");
} else {
    echo "Error al crear la tabla: " . $conn->error;
}

$conn->close();
