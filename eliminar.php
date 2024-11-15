<?php
include('conexion.php');

// Verificar si se ha recibido un id por el método GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id']; // Obtener el id del usuario

    // Preparar la consulta para eliminar el usuario con ese id
    $stmt = $conn->prepare("DELETE FROM personas WHERE id = ?");
    $stmt->bind_param("i", $id); // El "i" indica que el parámetro es un entero

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Redirigir al usuario a la página principal (index.php) después de eliminar
        header("Location: /index.php");
        exit;
    } else {
        // Mostrar error si no se pudo eliminar el usuario
        echo "Error al eliminar el usuario: " . $stmt->error;
    }

    // Cerrar la declaración preparada
    $stmt->close();
} else {
    // Si no se recibe un id válido, redirigir al usuario a la página principal
    header("Location: /index.php");
    exit;
}

// Cerrar la conexión a la base de datos
$conn->close();
