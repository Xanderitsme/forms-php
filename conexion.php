<?php
include('dbconfig.php');

function getConnection()
{
  try {
    $conn = new PDO("mysql:host=$GLOBALS[servername];dbname=$GLOBALS[dbname]", $GLOBALS['username'], $GLOBALS['password']);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;
  } catch (PDOException $e) {
    header("Location: configurar.php");
    // die("Error al conectar a la base de datos: " . $e->getMessage());
  }
}
