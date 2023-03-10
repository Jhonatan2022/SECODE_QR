<?php
session_start();
require_once '../models/database/database.php';
require_once '../models/user.php';
$user = getUser($_SESSION['user_id']);
$param = $connection->prepare("SELECT * FROM Suscripcion WHERE Ndocumento = :id");
$param->bindParam(':id', $_SESSION['user_id']);
$param->execute();
$datos = $param->fetch(PDO::FETCH_ASSOC);



if (isset($_SESSION['user_id']) && isset($_POST['plan']) && isset($_POST['token']) && $datos['TipoSuscripcion'] == 1) {


    $plan = $_POST['plan'];
    if ($plan == 22) {
        $plan = 2;
    } elseif ($plan == 56) {
        $plan = 3;
    } elseif ($plan == 99) {
        $plan = 4;
    } else {
        header('Location: ../index.php');
    }

    $query1 = 'SELECT us.Ndocumento FROM usuario as us WHERE us.token_reset = :token';
    $query = $connection->prepare($query1);
    $query->bindParam(':token', $_POST['token']);
    $query->execute();
    $usercompare = $query->fetch(PDO::FETCH_ASSOC);

    if ($usercompare['Ndocumento'] != $_SESSION['user_id']) {
        header('Location: ./iniciar.php');
    }

    $query1 = 'SELECT tps.precio, tps.TipoSuscripcion FROM TipoSuscripcion AS tps WHERE tps.IDTipoSuscripcion = :plan';
    $query = $connection->prepare($query1);
    $query->bindParam(':plan', $plan);
    $query->execute();
    $precio = $query->fetch(PDO::FETCH_ASSOC);

    //datos recibo
    $idfactura = random_int(2142314324, 8957349578);
    //date now 
    $date = date('Y-m-d');
    $token = bin2hex(random_bytes(16));
    $query1 = 'UPDATE Suscripcion SET  Ndocumento = :ndoc, TipoSuscripcion = :tipsus, fecha_inicio = :fecha, numero_recibo = :numr, token = :token WHERE Ndocumento = :ndoc';
    $query = $connection->prepare($query1);
    $query->bindParam(':ndoc', $_SESSION['user_id']);
    $query->bindParam(':tipsus', $plan);
    $query->bindParam(':fecha', $date);
    $query->bindParam(':numr', $idfactura);
    $query->bindParam(':token', $token);
    if ($query->execute()) {
        echo 1;
    }
} else {
    header('Location: ../index.php');
    echo 0;
}
?>