<?php
  session_start(); // Se inicia una sesion
  session_unset(); // Se cierra la sesion de usuario
  session_destroy(); // Se cierra la sesion de usuario
  header('Location: /index.html'); // Se redirige a la pagina principal
?>
