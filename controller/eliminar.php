<?php
session_start();
require_once '../models/database/database.php';
require_once '../models/user.php';
$user= getUser($_SESSION['user_id']);
if(isset($_GET['Ndocumento'], $_GET['token']) && $_GET['token'] == $user['token_reset'] && $_GET['Ndocumento'] == $user['Ndocumento'] ){
    $ndoc=$user['Ndocumento'];
    for($i = 1; $i < 3; $i++){
        if(getFormula($ndoc) != 0){
            $del = 'FormularioMedicamentos';
        }    elseif(getQR($ndoc) != 0){
/*             $qr= getQR($ndoc);
            foreach($qr as $q ){
                unlink('../views/pdf/'.$q['nombre']);
            } */
            $del = 'codigo_qr';
        }
        $query=$connection->prepare('DELETE FROM '.$del.' WHERE Ndocumento = '.$ndoc);

        $query->execute();
    }
    $query=$connection->prepare('DELETE FROM Suscripcion WHERE Ndocumento = :id');
    $query->bindParam(':id', $ndoc);
    $query->execute();

    $query=$connection->prepare('DELETE FROM datos_clinicos WHERE Ndocumento = :id');
    $query->bindParam(':id', $ndoc);
    $query->execute();

    $query=$connection->prepare('DELETE FROM usuario WHERE Ndocumento = :id');
    $query->bindParam(':id', $ndoc);
    $query->execute();

    header('Location: exit/index.php');
}else{
    header('Location: ../index.php');
}



