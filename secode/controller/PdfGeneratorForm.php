<?php

session_start();

if(! isset($_SESSION['user_id'])){
    http_response_code(404);
    header('Location: ../views/');
   
}else{
    echo 'hola';
    
}
    




?>