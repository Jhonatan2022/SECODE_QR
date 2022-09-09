<?php

if (isset($_POST['user_id'])) {
    header('Location: ../');
}

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
                echo "<a href='http://".$_SERVER['HTTP_HOST']."/SECODE_QR/secode/views/recovery/recupera.php?tokenUserMail=$tokenReset' target='BLANK'> RECUPERAR CONTRASEÑA</a>";

                //Datos de envio smtp despliegue app.
                $host=$_SERVER['HTTP_HOST'];
                
                $template =  `
                
                <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div>
    <p>lol</p>
<a href='http://'.$host.'/SECODE_QR/secode/views/recovery/recupera.php?tokenUserMail=$tokenReset'  >Recuperar contraseña</a>
    </div>
</body>
</html>
                
                `;


                /*
                $to = $results['Token_reset'];
                $from = '';
                $title = 'Recuperacion de contraseña';
                $message = $template;
                $headers = `From: $from`;
                $envio = mail($to, $title, $message, $headers);
                if ($envio) {
                    $message = array(' Correo enviado Exitosamente', 'Por favor revise su correo y siga las instrucciones ,si no ve el mensaje revise en spam', 'success');
                } else {
                    $message = array('Error de envio', 'Ocurrio un error al enviar el mensaje, intente de nuevo, por favor', 'error');
                }*/



                
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
                        <th colspan="2" class="h2" style="padding: 15px">Recuperar contraseña<hr></th>
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
</body>
</center>

</html>