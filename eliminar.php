<?php
// Incluir el archivo de conexión a la base de datos
include('conexion.php');

// Obtener la conexión a la base de datos
$conn = getConnection();

// Verificar si se ha recibido un id válido por el método GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id']; // Asegurarse de que el id sea un entero

    try {
        // Preparar la consulta para eliminar el registro con el id recibido
        $sql = "DELETE FROM personas WHERE id = :id";
        $stmt = $conn->prepare($sql);

        // Asociar el parámetro
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Redirigir al usuario a la página principal (index.php) después de eliminar
            header("Location: /index.php");
            exit;
        } else {
            // Mostrar un mensaje de error si no se pudo eliminar el registro
            echo "Error al eliminar el registro.";
        }
    } catch (PDOException $e) {
        // Manejar excepciones y mostrar el mensaje de error
        echo "Error al eliminar el registro: " . $e->getMessage();
    }
} else {
    // Si no se recibe un id válido, redirigir al usuario a la página principal
    header("Location: /index.php");
    exit;
}
