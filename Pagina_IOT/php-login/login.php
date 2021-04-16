<?php
  session_start(); //Se inicia una sesion

  if (isset($_SESSION['user_id'])) { //En caso de que un usuario se hubiera registrado se le redirige al archivo de resultado
    header('Location: result.php');
  }

  require 'Database.php';// Se importa el archivo Database

  if (!empty($_POST['email']) && !empty($_POST['password'])) { // Si los campos de email y contraseña no estan vacios
    $records = $conn->prepare('SELECT Id, Email, Password FROM Users WHERE Email = :email');  // Se define el tipo de peticion y se prepara la base de datos
    $records->bindParam(':email', $_POST['email']); //Se conecta las variables de email
    $records->execute(); // Se ejecuta la peticion
    $results = $records->fetch(PDO::FETCH_ASSOC); // Se toma el resultado de la peticion

    $message = '';// Se define un mensaje

    if (count($results) > 0 && password_verify($_POST['password'], $results['Password'])) { // Si hay algun resultado se almacena el ID y se redirecciona a la pagina de resultado en caso contrario se muestra un mensaje de error
      $_SESSION['user_id'] = $results['Id'];
      header("Location: /php-login/result.php");
    } else {
      $message = 'Las credenciales no coinciden';
    }
  }

?>


<!DOCTYPE html>
<html>
  <head><!-- Se hace el encabezado con el estilo de texto, se integra bootstrap y los estilos -->
    <meta charset="utf-8">
    <title>Ingreso de usuario</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Karla&family=Spectral&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>

    <header> <!--Se integra una barra de navegacion-->
      <nav class="navbar navbar-dark bg-dark navbar-expand-lg fixed-top">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="/index.html">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/caract.html">Caracteristicas</a>
          </li>
        </ul>
        <a class="navbar-brand" href="#">Cofree</a>
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="/php-login/login.php">Inicio de sesión</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/php-login/signup.php">Registro</a>
          </li>
        </ul>
      </nav>
    </header>

    <p></br>
    <p></br>
    <p></br>
    <h1>Inicio de sesión</h1> <!--Texto de inicio de secion y un mensaje de error que aparecera en caso de que suceda un error-->
    <?php if(!empty($message)): ?>
      <p> <?= $message ?></p>
    <?php endif; ?>
    <form action="login.php" method="POST"> <!--Se define un formulario-->
      <input name="email" type="text" placeholder="Ingrese su email">
      <input name="password" type="password" placeholder="Ingrese su Password">
      <input type="submit" value="Enviar">
    </form>

  </body>
</html>
