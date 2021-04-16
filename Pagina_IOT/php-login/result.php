<?php
  session_start();//Se inicia una sesion

  require 'Database.php';// Se importa el archivo Database

  if (isset($_SESSION['user_id'])) { // Si hay una sesion de usuario activa entra al if
    $records = $conn->prepare('SELECT Id, Email, Password FROM Users WHERE Id = :id');// Se define el tipo de peticion y se prepara la base de datos
    $records->bindParam(':id', $_SESSION['user_id']); //Se conecta las variables de ID
    $records->execute(); // Se ejecuta la peticion
    $results = $records->fetch(PDO::FETCH_ASSOC); // Se toma el resultado de la peticion

    $user = null; // Se crea una variable

    if (count($results) > 0) { // Si existe resultados se define un usuario
      $user = $results;
    }
  }
?>

<!DOCTYPE html>
<html>
  <head><!-- Se hace el encabezado con el estilo de texto, se integra bootstrap y los estilos -->
    <meta charset="utf-8">
    <title>Cofree</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Karla&family=Spectral&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>

    <?php if(!empty($user)): ?> // Si existe un usuario muestra la informacion
      <nav class="navbar navbar-dark bg-dark navbar-expand-lg fixed-top"> <!--Se integra una barra de navegacion-->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="/index.html">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/caract.html">Caracteristicas</a>
          </li>
        </ul>
        <a class="navbar-brand" href="#" style="width:70%;">Cofree</a>
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href=""><?= $user['Email']; ?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Salir</a>
          </li>
        </ul>
      </nav>


      <p></br>
      <p></br>
      <p></br>


        <section> <!--Se muestran los graficos integrados de thingspeak-->
          <div class="container mt-5">
            <div class="Responsive-frame">
              <div class="row">
                <div class="col-1" style="margin-right:22rem">
                  <iframe width="450" height="260" style="border: 1px solid #cccccc;" src="https://thingspeak.com/channels/1326958/charts/1?bgcolor=%23ffffff&color=%23d62020&dynamic=true&title=Temperatura&type=line&xaxis=fecha+y+hora&yaxismax=40&yaxismin=10"></iframe>
                </div>
                <div class="col-1" style="margin-right:22rem">
                  <iframe width="450" height="260" style="border: 1px solid #cccccc;" src="https://thingspeak.com/channels/1326958/charts/2?bgcolor=%23ffffff&color=%23d62020&dynamic=true&results=60&title=humedad&type=line&xaxis=fecha+y+hora&yaxismax=80&yaxismin=10"></iframe>
                </div>
                <div class="col-1">
                  <iframe width="450" height="260" style="border: 1px solid #cccccc;" src="https://thingspeak.com/channels/1326958/charts/3?bgcolor=%23ffffff&color=%23d62020&dynamic=true&results=60&title=CO2&type=line&xaxis=fecha+y+hora&yaxis=concentraci%C3%B3n+ppm&yaxismax=300&yaxismin=10"></iframe>
                </div>
              </div>
            </div>
          </div>
        </section>


    <?php else: ?> <!--Si no existe un usuario de niega el acceso a la informacion-->
      <h1>Acceso denegado</h1>
    <?php endif; ?>
  </body>
</html>
