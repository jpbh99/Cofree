<?php
  $server = 'fdb27.125mb.com';
  $username = '3775609_cofree';
  $password = 'Ju@npa99';
  $database = '3775609_cofree';

  try {
    $conn = new PDO("mysql:host=$server;dbname=$database;",$username,$password);
  } catch (PDOException $e) {
    die('Conexion fallida: '.$e->getMessage());
  }
 ?>
