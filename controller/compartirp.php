<?php
session_start();
require_once('../models/database/database.php');
require_once('../models/user.php');
$user = getUser($_SESSION['user_id']);
$suscripcion = getSuscription($_SESSION['user_id']);

if(! isset($_SESSION['user_id'])){
    header('Location: ../index.php');
    exit;
}



if(isset($_POST['id'], $_POST['compartir']) &&  $suscripcion['CompartirPerfil']=="SI"){
    if($_POST['compartir']==1){
        $cambio = 0;
        }else{
            $cambio = 1;
        }

if($user['CompartirUrl']==null){
    $compartir = random_int(1435435, 99999992222222999);
    $param=$connection->prepare("UPDATE usuario SET CompartirUrl = :urld, Compartido = 1 WHERE Ndocumento = :id");
    $param->bindParam(':id', $user['Ndocumento']);
    $param->bindParam(':urld', $compartir);
    if($param->execute()){
        echo 1;
    }
    
}else{
    $param=$connection->prepare("UPDATE usuario SET Compartido = :cambio WHERE Ndocumento = :id");
    $param->bindParam(':id', $user['Ndocumento']);
    $param->bindParam(':cambio', $cambio);
    if($param->execute()){
        echo 1;
    }
}

}else{
    echo 000;
}


if(isset($_POST['revisar'])){
    if($user['Compartido']==1){
        echo 1;
    }else{
        echo 0;
    }
}

?>