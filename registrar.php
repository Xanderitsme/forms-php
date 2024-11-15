<?php
include('conexion.php');

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
        // Preparar la consulta para evitar inyección de SQL
        $stmt = $conn->prepare("INSERT INTO personas (nombre, edad, correo) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $nombre, $edad, $correo); // "s" para string, "i" para integer

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Redirigir al usuario a la página principal (index.php)
            header("Location: /index.php");
            exit; // Detener la ejecución para que no se ejecute más código
        } else {
            // En caso de error al insertar los datos
            echo "Error al registrar los datos: " . $stmt->error;
        }

        // Cerrar la declaración preparada
        $stmt->close();
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
