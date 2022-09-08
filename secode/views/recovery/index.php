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
                echo "<a href='http://localhost/SECODE_QR/secode/views/recovery/recupera.php?tokenUserMail=$tokenReset' target='BLANK'> RECUPERAR CONTRASEÑA</a>";

                //Datos de envio smtp despliegue app.

                /*
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
<a href="http://localhost:8080/SECODE_QR/secode/views/recovery/recupera.php?tokenUserMail=$tokenReset">Recuperar contraseña</a>
    </div>
</body>
</html>
                
                `;
                $to = $results['Token_reset'];
                $from = '';
                $title = 'Recuperacion de contraseña';
                $message = $template;
                $headers = `From: $from;
                $envio = mail($to, $title, $message, $headers);
                if ($envio) {
                    $message = array(' Correo enviado Exitosamente', 'Por favor revise su correo y siga las instrucciones ,si no ve el mensaje revise en spam', 'success');
                } else {
                    $message = array('Error de envio', 'Ocurrio un error al enviar el mensaje, intente de nuevo, por favor', 'error');
                }



                */
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
</head>

<body>
    <center>

        <script>
            function cancelarform() {
                document.getElementById("formrecupera").style.display = "none";
            }
        </script>
        <div class="caja_popup" id="formrecupera">
            <form action="" class="contenedor_popup" method="POST">
                <table>
                    <tr>
                        <th colspan="2">Recuperar contraseña</th>
                    </tr>
                    <tr>
                        <td><b>&#128231; Correo</b></td>
                        <td><input type="email" name="CorreoUser" required class="cajaentradatexto"></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button type="button" onclick="cancelarform()" class="txtrecupera">Cancelar</button>
                            <input class="txtrecupera" type="submit" name="btnrecupera" value="Enviar" onClick="javascript: return confirm('¿Deseas enviar tu contraseña a tu correo?');">
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