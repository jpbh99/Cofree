<?php
  require 'Database.php'; // Se importa el archivo Database

  $message = ""; // Se define un mensaje

  if (!empty($_POST['email']) && !empty($_POST['password']) && (($_POST['password']) == ($_POST['confirm_password']))) { // if que permite entrara si se escribio algo en el formulario y que las contraseñas coincidan
    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      $sql = 'SELECT * FROM Users WHERE Email = ?';
      $Sentencia = $conn->prepare($sql);//Se prepara la base de datos
      $Sentencia->execute(array($_POST['email']));
      $resultado = $Sentencia->fetch();
      if ($resultado) {
        $message = "Este usuario ya existe";
      }else{
      $sql = "INSERT INTO Users (Email, Password) VALUES (:email, :password)"; // Se define el tipo de peticion
      $stmt = $conn->prepare($sql); //Se prepara la base de datos
      $stmt->bindParam(':email', $_POST['email']); //Se conecta las variables de email
      $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Se encripta la contraseña
      $stmt->bindParam(':password', $password); // Se conectan las variables

      if ($stmt->execute()) { // Si se ejecuta la peticion se muestra un mensaje positivo de otra forma se muestra un mensaje que indica que ocurrio un error
        $message = 'Se ha creado el usuario de manera satisfactoria';
      }
      else {
        $message = 'Hubo un problema con la creación del usuario, revise su usuario o contraseña';
      }
    }
  }else{
    $message = "Esta direccion de correo no es valida";
  }

  }

 ?>


<!DOCTYPE html>
<html>
  <head><!-- Se hace el encabezado con el estilo de texto, se integra bootstrap y los estilos -->
    <meta charset="utf-8">
    <title>Registro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Karla&family=Spectral&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>

    <header><!-- Se integra una barra de navegacion-->
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

    <h1>Registro de usuario</h1>

    <?php if(!empty($message)): ?><!--Texto de inicio de sesion y un mensaje de error que aparecera en caso de que suceda un error-->
      <p> <?= $message ?></p>
    <?php endif; ?>
  <form action="signup.php" method="POST"> <!--Se define un formulario-->
    <input name="email" type="text" placeholder="Ingrese su correo">
    <input name="password" type="password" placeholder="Ingrese su contraseña">
    <input name="confirm_password" type="password" placeholder="Confirme su contraseña">
    <input type="submit" value="Enviar">
  </form>
  </body>
</html>
