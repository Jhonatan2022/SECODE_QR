<?php
session_start();

if (isset($_SESSION['Ndocumento'])) {
    
  }else{
    header('Location: ../views/iniciar.php');
  }

require_once '../models/database/database.php';

$consult = " SELECT * FROM usuario WHERE Correo= :correo";
    $parametros = $connection->prepare($consult);
    $parametros->bindParam(':correo', $email_user);
    $parametros->execute();
    $results_user = $parametros->fetch(PDO::FETCH_ASSOC);


?>