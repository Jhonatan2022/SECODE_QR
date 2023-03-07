<?php
require '../vendor/autoload.php';

$mail = new PHPMailer\PHPMailer\PHPMailer(true);

$mail->isSMTP();
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tls';
$mail->Host = 'smtp.gmail.com';
$mail->Port = '587';
$mail->Username = 'jdflorez038@misena.edu.co';
$mail->Password = 'Jhonatan2022@';


$mail->setFrom('jdflorez038@misena.edu.co','Factura');
$mail->addAddress('jssossa2@misena.edu.co','Sergio Sossa');

$mail->Subject = 'Hola esta es tu Factura';
$mail->Body = 'cómo esta mi pez ?';

if($mail->send()) {
    echo 'Mensaje enviado correctamente.';
} else {
    echo 'Error al enviar el mensaje.';
}
?>