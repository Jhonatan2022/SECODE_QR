<?php
session_start();
if (isset($_SESSION['Ndocumento'])) {
    echo "<script> setTimeout(\"location.href='../iniciar.php'\",500);</script>";
  };
require_once 'database.php';
$consult = " SELECT * FROM usuario WHERE Correo= :correo";
    $parametros = $connection->prepare($consult);
    $parametros->bindParam(':correo', $email_user);
    $parametros->execute();
    $results_user = $parametros->fetch(PDO::FETCH_ASSOC);