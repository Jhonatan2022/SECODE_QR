<?php
session_start() ;
require_once('../vendor/autoload.php') ;
require_once('../models/database/database.php') ;
require_once('../models/user.php') ;
require_once('../models/config.php') ;

if (isset($_POST['subject']) && isset($_POST['message']) && isset($_SESSION['user_id'])) {
    $user=getUser($_SESSION['user_id']) ;
    $sus=getSuscription($user['Ndocumento']) ;
    if($sus['EnviarMensaje'] == "SI"){

        $subject = $_POST['subject'] ;
        $message = $_POST['message'] ;
        $user_id = $_SESSION['user_id'] ;
        
        $date = date('Y-m-d') ;
        $time = date('H:i:s') ;
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
                    $mail->addReplyTo($user['Correo'], $user['Nombre']);

                    // Content
                    $mail->Subject = "[Secode QR] " . ' Alguien vio tu perfil y te envio un mensaje 📧' . '  >>De: '.  $user['Correo'];
                    $mail->isHTML(true);
                    //reemplazar sección de plantilla html con el css cargado y mensaje creado
                    $cuerpo = '<strong>Nombre: </strong>' . $user['Nombre'] . '<br><strong>Correo: </strong>' . $user['Correo'] . '<br><strong>Asunto: </strong>' . $subject . '<br><strong>Mensaje: </strong>' . $message . '<br><br><strong>Fecha: </strong>' . $date . '<br><strong>Hora: </strong>' . $time . '<br><br><strong>Este mensaje fue enviado desde Secode QR</strong>';
                    $mail->Body = $cuerpo; //cuerpo del mensaje
                    $mail->AltBody = '---'; //Mensaje de sólo texto si el receptor no acepta HTML

                    if($mail->send()){
                        echo 'success';
                    }
                } catch (Exception $e) {
                    echo 'error: '.$e ;
                }
    }else{
        header('Location: ../index.php');
    }
}else{
    header('Location: ../index.php');
}




?>