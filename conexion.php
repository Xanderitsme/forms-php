<?php
// Incluir la configuración de la base de datos
include_once('dbconfig.php');

function getConnection()
{
  try {
    // Ahora se pueden usar las variables directamente porque ya están definidas
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;
  } catch (PDOException $e) {
    // Si hay un error, se redirige a configurar.php
    header("Location: configurar.php");
  }
}
?>
