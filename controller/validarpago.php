<?php
/* Checking if the user is logged in and if the user has a subscription. */
// This code is used to check if the user is logged in.
// It gets the user_id from the session and uses it to get the user's data from the database.
// It also checks if the user's subscription is active.

session_start();
require_once '../models/database/database.php';
require_once '../models/user.php';
$user = getUser($_SESSION['user_id']);
/* Preparing a query to the database. */
$param = $connection->prepare("SELECT * FROM Suscripcion WHERE Ndocumento = :id");
$param->bindParam(':id', $_SESSION['user_id']);
$param->execute();
$datos = $param->fetch(PDO::FETCH_ASSOC);



if (isset($_SESSION['user_id']) && isset($_POST['plan']) && isset($_POST['token']) && $datos['TipoSuscripcion'] == 1) {
    // si el usuario esta logeado y el plan esta definido y el token esta definido y el usuario no tiene una suscripcion activa entonces se procede a realizar el pago 

    $plan = $_POST['plan'];  // $plan es el plan seleccionado por el usuario 
    if ($plan == 22) {
        $plan = 2;
    } elseif ($plan == 56) {
        $plan = 3;
    } elseif ($plan == 99) {
        $plan = 4;
    } else {
        header('Location: ../index.php');
    }

/* Checking if the token is valid. */
    $query1 = 'SELECT us.Ndocumento FROM usuario as us WHERE us.token_reset = :token';
    $query = $connection->prepare($query1);
    $query->bindParam(':token', $_POST['token']);
    $query->execute();
    $usercompare = $query->fetch(PDO::FETCH_ASSOC);

    //comparando que el usuario que esta haciendo el pago sea el mismo que inicio sesion
    if ($usercompare['Ndocumento'] != $_SESSION['user_id']) { 
        header('Location: ./iniciar.php');
    }
    //datos plan
    //consulta a la base de datos para obtener el precio del plan seleccionado por el usuario y el tiempo de duracion de la suscripcion 
    $query1 = 'SELECT tps.precio, tps.TipoSuscripcion,tiempo FROM TipoSuscripcion AS tps WHERE tps.IDTipoSuscripcion = :plan';
    $query = $connection->prepare($query1);
    $query->bindParam(':plan', $plan); // $plan es el plan seleccionado por el usuario
    $query->execute();
    $precio = $query->fetch(PDO::FETCH_ASSOC); // $precio es un array que contiene el precio del plan y el tiempo de duracion de la suscripcion

    //datos recibo
    $idfactura = random_int(2142314324, 8957349578);
    //date now 
    $date = date('Y-m-d');  // $date es la fecha actual
    $nuevafecha = strtotime ( '+'.$precio['tiempo'].' month' , strtotime ( $date ) ) ; // $nuevafecha es la fecha actual mas el tiempo de duracion de la suscripcion 
    $datexp=date ( 'Y-m-j' , $nuevafecha );
    $token = bin2hex(random_bytes(16)); // $token es un token aleatorio que se genera para validar el pago
    $query1 = 'UPDATE Suscripcion SET  Ndocumento = :ndoc, TipoSuscripcion = :tipsus, fecha_inicio = :fecha, FechaExpiracion = :fechaexp , numero_recibo = :numr, token = :token WHERE Ndocumento = :ndoc';
    $query = $connection->prepare($query1);
    $query->bindParam(':ndoc', $_SESSION['user_id']);
    $query->bindParam(':tipsus', $plan);
    $query->bindParam(':fechaexp', $datexp);
    $query->bindParam(':fecha', $date);
    $query->bindParam(':numr', $idfactura);
    $query->bindParam(':token', $token);
    if ($query->execute()) {
        echo 1; // 1 es un codigo que indica que el pago se realizo correctamente
    }
} else {
    header('Location: ../index.php');
    echo 0; // 0 es un codigo que indica que el pago no se realizo correctamente
}
?>