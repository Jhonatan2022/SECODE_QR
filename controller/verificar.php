<?php
session_start() ;
require_once('../vendor/autoload.php') ;
require_once('../models/database/database.php') ;
require_once('../models/user.php') ;
require_once('../models/config.php') ;
if(isset($_POST['verificar'])){
    $user=getUser($_SESSION['user_id']) ;
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = CONTACTFORM_PHPMAILER_DEBUG_LEVEL;
        $mail->isSMTP();
        $mail->CharSet = 'UTF-8';
        $mail->Host = CONTACTFORM_SMTP_HOSTNAME;
        $mail->SMTPAuth = true;
        $mail->Username = CONTACTFORM_SMTP_USERNAME;
        $mail->Password = CONTACTFORM_SMTP_PASSWORD;
        $mail->SMTPSecure = CONTACTFORM_SMTP_ENCRYPTION;
        $mail->Port = CONTACTFORM_SMTP_PORT;
        // Recipients
        $mail->setFrom(cont_dir, cont_name);
        $mail->addAddress($user['Correo']);
        $mail->addReplyTo(cont_dir, cont_name);
        $mail->Subject = "[Secode QR] " . 'Verifica tu cuenta '.  $user['Correo'];
        $mail->isHTML(true);
        //reemplazar sección de plantilla html con el css cargado y mensaje creado
        $cuerpo = '<strong>Para verificar su cuenta de click en el siguiente enlace</strong><br><br><a href="http://'.$_SERVER['HTTP_HOST'].'/secodeqr/controller/verificar.php?verificarUser='.$user['token_reset'].'&tipo=user'.'">Verificar</a><br><br><strong>Este mensaje fue enviado desde Secode QR</strong>';
        $mail->Body = $cuerpo; //cuerpo del mensaje
        $mail->AltBody = '---'; //Mensaje de sólo texto si el receptor no acepta HTML
        if($mail->send()){
            echo 1;
        }
    } catch (Exception $e) {
        echo 'error: '.$e ;
    }
}elseif(isset($_GET['verificarUser'])){
    $userToken=$_GET['verificarUser'];
    $newtoken = bin2hex(random_bytes(16));
    $query='UPDATE usuario SET Verificado=1, token_reset = :newtoken WHERE token_reset=:token_reset';
    $stmt=$connection->prepare($query);
    $stmt->bindParam(':token_reset', $userToken, PDO::PARAM_STR);
    $stmt->bindParam(':newtoken', $newtoken, PDO::PARAM_STR);
    if($stmt->execute()){
        header('Location: ../views/index.php?verificado=1');
    }else{
        header('Location: ../views/index.php?verificado=0');
    }
}else{
    header('Location: ../index.php');
}