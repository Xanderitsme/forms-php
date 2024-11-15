<?php
// Incluir la configuración de la base de datos
include_once('dbconfig.php');

function getConnection()
{
  global $host, $dbname, $username, $password;
  try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;
  } catch (PDOException $e) {
    header("Location: configurar.php");
    exit;
  }
}
?>
