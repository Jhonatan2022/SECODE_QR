<?php

session_start();
require_once '../models/database/database.php';
require_once '../models/user.php';
$user= getUser($_SESSION['user_id']);
$sus=getSuscription($user['Ndocumento']);
if(isset($_POST['id']) && $_POST['id']== $user['Ndocumento'] && $sus['TipoSuscripcion']!= 1){
    $query = "UPDATE Suscripcion SET FechaExpiracion = null ,TipoSuscripcion= 1 , fecha_inicio= null ,	numero_recibo= null , token= null  WHERE Ndocumento = :id";
    $params = $connection->prepare($query);
    $params->execute([':id' => $_POST['id']]);
    if($params){
        echo 1;
    }else{
        echo "Error al eliminar la suscripcion";
    }
}
?>