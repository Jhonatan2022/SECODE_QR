<?php

session_start();

if (isset($_SESSION['user_id'])) {
  header('Location: ./iniciar.html');
}

//importamos conexion base de datos
require './assets/php/database.php';

$email_rec =$_GET['user_correo'];
$token = $_GET['token'];

if (!empty($email_rec)){
    if (filter_var($email_rec, FILTER_VALIDATE_EMAIL)) {
        echo $email_rec;
        echo $token;
    }else{
        echo "<script>
        alert('Correo No valido, ingrese nuevamente.');
        setTimeout(\" location.href=\'iniciar.php\' \",0);
        </script>;
        ";
    }
} 

?>