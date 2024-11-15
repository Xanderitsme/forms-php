<?php
// Incluir la configuración de la base de datos
include_once('conexion.php');

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Recibir los datos del formulario
  $servername = isset($_POST['servername']) ? trim($_POST['servername']) : '';
  $username = isset($_POST['username']) ? trim($_POST['username']) : '';
  $password = isset($_POST['password']) ? trim($_POST['password']) : '';
  $dbname = isset($_POST['dbname']) ? trim($_POST['dbname']) : '';

  // Validar que los campos no estén vacíos
  if (empty($servername) || empty($username) || empty($password) || empty($dbname)) {
    $error_message = "Todos los campos son obligatorios.";
  } else {
    // Crear el contenido del archivo dbconfig.php
    $dbconfig_content = "<?php\n";
    $dbconfig_content .= "// Configuración de la base de datos\n";
    $dbconfig_content .= "\$servername = '$servername';\n";
    $dbconfig_content .= "\$username = '$username';\n";
    $dbconfig_content .= "\$password = '$password';\n";
    $dbconfig_content .= "\$dbname = '$dbname';\n";

    // Intentar escribir el archivo dbconfig.php
    $file = 'dbconfig.php';
    if (file_put_contents($file, $dbconfig_content)) {
      $conn = getConnection();
      if ($conn) {
        $success_message = "La configuración se ha guardado correctamente en '$file'.";
      } else {
        $error_message = "Error al conectar a la base de datos.";
      }
    } else {
      $error_message = "Hubo un error al intentar guardar el archivo de configuración.";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Configurar Base de Datos</title>
  <link rel="stylesheet" href="styles.css">
</head>

<body>
  <a href="index.php">Inicio</a>
  <h1>Configuración de la Base de Datos</h1>

  <!-- Mostrar mensaje de éxito o error -->
  <?php if (isset($success_message)) {
    echo "<p style='color: green;'>$success_message</p>";
  } ?>
  <?php if (isset($error_message)) {
    echo "<p style='color: red;'>$error_message</p>";
  } ?>

  <!-- Formulario para ingresar los datos de conexión -->
  <form action="configurar.php" method="POST">
    <label for="servername">Servername:</label><br>
    <input type="text" id="servername" name="servername" required><br><br>

    <label for="username">Username:</label><br>
    <input type="text" id="username" name="username" required><br><br>

    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password" required><br><br>

    <label for="dbname">Database Name:</label><br>
    <input type="text" id="dbname" name="dbname" required><br><br>

    <button type="submit">Guardar Configuración</button>
  </form>

</body>

</html>
