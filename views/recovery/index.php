<?php

if (isset($_SESSION['user_id'])) {
    header('Location: ../');
};

require_once('../../main.php');
require_once(BaseDir . '/vendor/autoload.php');
require_once('./config.php');

require_once('../../models/database/database.php');

if (isset($_POST['CorreoUser'])) {
    if (
        !empty($_POST['CorreoUser']) &&
        filter_var($_POST['CorreoUser'], FILTER_VALIDATE_EMAIL)
    ) {
        $CorreoUser = $_POST['CorreoUser'];

        $query = 'SELECT Token_reset 
                FROM usuario WHERE Correo = :CorreoUser';
        $param = $connection->prepare($query);
        $param->bindParam(':CorreoUser', $CorreoUser);
        if ($param->execute()) {
            $results = $param->fetch(PDO::FETCH_ASSOC);
            if (
                !empty($results) &&
                count($results) == 1
            ) {
                $tokenReset = $results['Token_reset'];
                //Datos de envio smtp despliegue app.
                $host = $_SERVER['HTTP_HOST'];
                $var_correo = $_POST['CorreoUser'];


                // Everything seems OK, time to send the email.

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
                    $mail->addAddress($var_correo);
                    $mail->addReplyTo(cont_dir, cont_name);

                    // Content
                    $mail->Subject = "[Pasword Recovery] " . ' Secode QR ' . $_POST['CorreoUser'];
                    $mail->isHTML(true);

                    $shtml = file_get_contents('template.html');
                    //reemplazar sección de plantilla html con el css cargado y mensaje creado
                    $cuerpo = str_replace("href='link'", "href='http://$host/SECODE_QR/views/recovery/recupera.php?tokenUserMail=$tokenReset' ", $shtml);
                    $mail->Body = $cuerpo; //cuerpo del mensaje
                    $mail->AltBody = '---'; //Mensaje de sólo texto si el receptor no acepta HTML

                    $mail->send();
                    $message = array(' Enviado ', 'Revise su correo, si no aparacere revise en spam.', 'success');
                } catch (Exception $e) {
                    $message = array(' Error', 'El correo no fue enviado, intente despues: ' . $mail->ErrorInfo, 'error');
                }
            } else {
                $message = array(' Error', 'El correo NO exixte, primero registrese e inicie sesion', 'error');
            }
        } else {
            $message = array(' Error', 'El correo no es valido, intente de nuevo.', 'warning');
        }
    }
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- favicon -->
    <link rel="shortcut icon" type="image/png" href="../assets/img/logo.png">
    <!-- google font -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <!-- fontawesome -->
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <!-- bootstrap -->
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">


    <?php include('../templates/sweetalerts2.php'); ?>
</head>

<body>
    <style>
        body {
            background-color: #E8F3FF;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100%25' height='100%25' %3E%3Cdefs%3E%3ClinearGradient id='a' x1='0' x2='0' y1='0' y2='1' gradientTransform='rotate(0,0.5,0.5)'%3E%3Cstop offset='0' stop-color='%23BC91FF'/%3E%3Cstop offset='1' stop-color='%23B1FFFE'/%3E%3C/linearGradient%3E%3C/defs%3E%3Cpattern id='b' width='54' height='54' patternUnits='userSpaceOnUse'%3E%3Ccircle fill='%23E8F3FF' cx='27' cy='27' r='27'/%3E%3C/pattern%3E%3Crect width='100%25' height='100%25' fill='url(%23a)'/%3E%3Crect width='100%25' height='100%25' fill='url(%23b)' fill-opacity='0.08'/%3E%3C/svg%3E");
            background-attachment: fixed;
        }
    </style>
    <center>

        <script>
            function cancelarform() {
                document.getElementById("formrecupera").style.display = "none";
            }
        </script>
        <div class="caja_popup" id="formrecupera">
            <form action="" class="contenedor_popup " method="POST" style="width: 50vw ;border-radius: 16px ;border: 4px solid; border-color:#6610f2; padding:2em; background:#fff; margin-top:8rem">
                <table>
                    <tr>
                        <th colspan="2" class="h2" style="padding: 15px">Recuperar contraseña
                            <hr>
                        </th>
                    </tr>
                    <tr>
                        <td style="padding: 30px"><b>&#128231; Correo</b></td>
                        <td><input type="email" name="CorreoUser" required class="cajaentradatexto form-control"></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button type="button" onclick="cancelarform()" class="txtrecupera  btn btn-danger" style="margin: 1em">Cancelar</button>
                            <input class="txtrecupera btn btn-primary" type="submit" name="btnrecupera" value="Enviar" onClick="javascript: return confirm('¿Deseas enviar tu contraseña a tu correo?');">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <?php if (!empty($message)) :
        ?>

            <script>
                Swal.fire(
                    '<?php echo $message[0]; ?>',
                    '<?php echo $message[1]; ?>',
                    '<?php echo $message[2]; ?>')
            </script>
        <?php endif;
        ?>
        <style>
            body {
                background-color: #ffffff;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100%25'%3E%3Cdefs%3E%3ClinearGradient id='a' gradientUnits='userSpaceOnUse' x1='0' x2='0' y1='0' y2='100%25' gradientTransform='rotate(324,683,328)'%3E%3Cstop offset='0' stop-color='%23ffffff'/%3E%3Cstop offset='1' stop-color='%234FE'/%3E%3C/linearGradient%3E%3Cpattern patternUnits='userSpaceOnUse' id='b' width='496' height='413.3' x='0' y='0' viewBox='0 0 1080 900'%3E%3Cg fill-opacity='0.08'%3E%3Cpolygon fill='%23444' points='90 150 0 300 180 300'/%3E%3Cpolygon points='90 150 180 0 0 0'/%3E%3Cpolygon fill='%23AAA' points='270 150 360 0 180 0'/%3E%3Cpolygon fill='%23DDD' points='450 150 360 300 540 300'/%3E%3Cpolygon fill='%23999' points='450 150 540 0 360 0'/%3E%3Cpolygon points='630 150 540 300 720 300'/%3E%3Cpolygon fill='%23DDD' points='630 150 720 0 540 0'/%3E%3Cpolygon fill='%23444' points='810 150 720 300 900 300'/%3E%3Cpolygon fill='%23FFF' points='810 150 900 0 720 0'/%3E%3Cpolygon fill='%23DDD' points='990 150 900 300 1080 300'/%3E%3Cpolygon fill='%23444' points='990 150 1080 0 900 0'/%3E%3Cpolygon fill='%23DDD' points='90 450 0 600 180 600'/%3E%3Cpolygon points='90 450 180 300 0 300'/%3E%3Cpolygon fill='%23666' points='270 450 180 600 360 600'/%3E%3Cpolygon fill='%23AAA' points='270 450 360 300 180 300'/%3E%3Cpolygon fill='%23DDD' points='450 450 360 600 540 600'/%3E%3Cpolygon fill='%23999' points='450 450 540 300 360 300'/%3E%3Cpolygon fill='%23999' points='630 450 540 600 720 600'/%3E%3Cpolygon fill='%23FFF' points='630 450 720 300 540 300'/%3E%3Cpolygon points='810 450 720 600 900 600'/%3E%3Cpolygon fill='%23DDD' points='810 450 900 300 720 300'/%3E%3Cpolygon fill='%23AAA' points='990 450 900 600 1080 600'/%3E%3Cpolygon fill='%23444' points='990 450 1080 300 900 300'/%3E%3Cpolygon fill='%23222' points='90 750 0 900 180 900'/%3E%3Cpolygon points='270 750 180 900 360 900'/%3E%3Cpolygon fill='%23DDD' points='270 750 360 600 180 600'/%3E%3Cpolygon points='450 750 540 600 360 600'/%3E%3Cpolygon points='630 750 540 900 720 900'/%3E%3Cpolygon fill='%23444' points='630 750 720 600 540 600'/%3E%3Cpolygon fill='%23AAA' points='810 750 720 900 900 900'/%3E%3Cpolygon fill='%23666' points='810 750 900 600 720 600'/%3E%3Cpolygon fill='%23999' points='990 750 900 900 1080 900'/%3E%3Cpolygon fill='%23999' points='180 0 90 150 270 150'/%3E%3Cpolygon fill='%23444' points='360 0 270 150 450 150'/%3E%3Cpolygon fill='%23FFF' points='540 0 450 150 630 150'/%3E%3Cpolygon points='900 0 810 150 990 150'/%3E%3Cpolygon fill='%23222' points='0 300 -90 450 90 450'/%3E%3Cpolygon fill='%23FFF' points='0 300 90 150 -90 150'/%3E%3Cpolygon fill='%23FFF' points='180 300 90 450 270 450'/%3E%3Cpolygon fill='%23666' points='180 300 270 150 90 150'/%3E%3Cpolygon fill='%23222' points='360 300 270 450 450 450'/%3E%3Cpolygon fill='%23FFF' points='360 300 450 150 270 150'/%3E%3Cpolygon fill='%23444' points='540 300 450 450 630 450'/%3E%3Cpolygon fill='%23222' points='540 300 630 150 450 150'/%3E%3Cpolygon fill='%23AAA' points='720 300 630 450 810 450'/%3E%3Cpolygon fill='%23666' points='720 300 810 150 630 150'/%3E%3Cpolygon fill='%23FFF' points='900 300 810 450 990 450'/%3E%3Cpolygon fill='%23999' points='900 300 990 150 810 150'/%3E%3Cpolygon points='0 600 -90 750 90 750'/%3E%3Cpolygon fill='%23666' points='0 600 90 450 -90 450'/%3E%3Cpolygon fill='%23AAA' points='180 600 90 750 270 750'/%3E%3Cpolygon fill='%23444' points='180 600 270 450 90 450'/%3E%3Cpolygon fill='%23444' points='360 600 270 750 450 750'/%3E%3Cpolygon fill='%23999' points='360 600 450 450 270 450'/%3E%3Cpolygon fill='%23666' points='540 600 630 450 450 450'/%3E%3Cpolygon fill='%23222' points='720 600 630 750 810 750'/%3E%3Cpolygon fill='%23FFF' points='900 600 810 750 990 750'/%3E%3Cpolygon fill='%23222' points='900 600 990 450 810 450'/%3E%3Cpolygon fill='%23DDD' points='0 900 90 750 -90 750'/%3E%3Cpolygon fill='%23444' points='180 900 270 750 90 750'/%3E%3Cpolygon fill='%23FFF' points='360 900 450 750 270 750'/%3E%3Cpolygon fill='%23AAA' points='540 900 630 750 450 750'/%3E%3Cpolygon fill='%23FFF' points='720 900 810 750 630 750'/%3E%3Cpolygon fill='%23222' points='900 900 990 750 810 750'/%3E%3Cpolygon fill='%23222' points='1080 300 990 450 1170 450'/%3E%3Cpolygon fill='%23FFF' points='1080 300 1170 150 990 150'/%3E%3Cpolygon points='1080 600 990 750 1170 750'/%3E%3Cpolygon fill='%23666' points='1080 600 1170 450 990 450'/%3E%3Cpolygon fill='%23DDD' points='1080 900 1170 750 990 750'/%3E%3C/g%3E%3C/pattern%3E%3C/defs%3E%3Crect x='0' y='0' fill='url(%23a)' width='100%25' height='100%25'/%3E%3Crect x='0' y='0' fill='url(%23b)' width='100%25' height='100%25'/%3E%3C/svg%3E");
                background-attachment: fixed;
                background-size: cover;
            }

            body #formrecupera {
                width: 50 vw;
                border: 3 px solid #007bff;
                border-radius: 20 px;
                padding: 2 rem;
            }

            body #formrecupera tr {
                padding-top: 1rem;
            }
        </style>


</body>
</center>

</html>