<?php
session_start();
require_once('../models/database/database.php');
if(isset($_POST['Eps'])) {
    $eps=intval($_POST['Eps']);
    $id=$_SESSION['user_id'];
    $query="UPDATE usuario SET id = :eps WHERE Ndocumento = :idUser";
    $query=$connection->prepare($query);
    $query->bindParam(':eps',$eps);
    $query->bindParam(':idUser', $id);
    if($query->execute()) {
        header('Location: '. $_SERVER['HTTP_REFERER']); // Redirect to the previous page
    } else {
        echo 'error';
    }
}
?>