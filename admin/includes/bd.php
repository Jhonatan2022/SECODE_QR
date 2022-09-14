<?php

$host = "localhost";
$user = "root";
$password = "";
$database ="id16455213_secode_qr";

$conexion = mysqli_connect($host,$user,$password,$database);
if (!$conexion){
echo "No se realizó la conexión a la base de datos el error fue:".
mysqli_connect_error() ;
}
?>