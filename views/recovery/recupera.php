<?php


session_start();

if (isset($_SESSION['user_id']) || !isset($_GET['tokenUserMail'])) {
    header('Location: ../iniciar.php');
}

//importamos conexion base de datos
require '../../models/database/database.php';


if (
    !empty($_POST['email-user']) &&
    !empty($_POST['UserDoc']) &&
    isset($_GET['tokenUserMail'])
) {
    $email_rec = $_POST['email-user'];
    $userDoc = $_POST['UserDoc'];
    $tokenEmail = $_GET['tokenUserMail'];
    if (
        filter_var($email_rec, FILTER_VALIDATE_EMAIL) &&
        filter_var($userDoc, FILTER_VALIDATE_INT) /* &&
        filter_var($tokenEmail, FILTER_VALIDATe) *//* &&
        count($userDoc) > 8 &&
        count($userDoc) < 11 */
    ) {
        $consult = "SELECT Correo,Ndocumento,token_reset  
        FROM usuario 
        WHERE Correo = :email and Ndocumento = :userDoc and token_reset = :tokenEmail ";
        $params = $connection->prepare($consult);
        $params->bindParam(":email", $email_rec);
        $params->bindParam(":userDoc", $userDoc);
        $params->bindParam(":tokenEmail", $tokenEmail);
        $params->execute();
        $results1 = $params->fetch(PDO::FETCH_ASSOC);

        if (!empty($results1) && count($results1) == 3) {

            $resetPass = true;



            if (
                !empty($_POST['NewPasswordUser']) &&
                !empty($_POST['verifyPasswordUser']) &&
                isset($_GET['tokenUserMail'])
            ) {

                if ($_GET['tokenUserMail'] == $results1['token_reset']) {
                    if (
                        $_POST['NewPasswordUser'] ==
                        $_POST['verifyPasswordUser']
                    ) {

                        $NewPassword = password_hash($_POST['NewPasswordUser'], PASSWORD_BCRYPT);
                        $NewToken = rand(124324, 876431167878435);
                        $param = $connection->prepare('UPDATE usuario 
                        SET contrasena = :Newpass, Token_reset = :NewToken
                        WHERE Ndocumento = :Documento');
                        $param->bindParam(':Newpass', $NewPassword);
                        $param->bindParam(':NewToken', $NewToken);
                        $param->bindParam(':Documento', $results1['Ndocumento']);

                        if ($param->execute()) {
                            $message = array('Realizado Correctamente', 'Inicie sesion, con sus nueva contraseña y guardela en un lugar seguro', 'success');
                        } else {
                            $message = array('Ocurrio un error', 'Por favor intentente el proceso desde el principio e intente nuevamente', 'error');
                        }
                    } else {
                        $message = array(' Error', 'Las contraseñas no coinciden, intente de nuevo.', 'warning');
                    }
                } else {
                    $message = array(' Error', 'Token de seguridad diferente, por seguridad Intente Nuevamente con un token valido', 'error');
                }
            }
        } else {
            $message = array(' Error', 'Datos Invalidos', 'error');
            $resetPass = false;
        }
    } else {
        $message = array(' Error', 'Correo no valido. intente de nuevo.', 'warning');
        $resetPass = false;
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <!-- favicon -->
    <link rel="shortcut icon" type="image/png" href="../assets/img/logo.png">
    <!-- google font -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <!-- fontawesome -->
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <!-- bootstrap -->
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <!-- animate css -->
    <link rel="stylesheet" href="../assets/css/animate.css">
    <!-- mean menu css -->
    <link rel="stylesheet" href="../assets/css/meanmenu.min.css">
    <!-- main style -->
    <link rel="stylesheet" href="../assets/css/main.css">
    <!-- responsive -->
    <link rel="stylesheet" href="../assets/css/responsive.css">
    <link rel="stylesheet" href="../assets/css/dashborad.css">


    <?php include('../templates/sweetalerts2.php'); ?>
    <title>Recupera Passwod</title>
</head>

<body>
 <style>
    body form{
        width: 50vw;
        border-radius: 16px;
        border: 2px solid; 
        background:#fff;
        border-color:#6610f2; 
        padding:2rem; 
        text-align: center;
        margin-top:5rem;
    }
    body{
        background-color: #DFADFF;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='322' height='322' viewBox='0 0 200 200'%3E%3Cpolygon fill='%23DCEFFA' fill-opacity='0.49' points='100 0 0 100 100 100 100 200 200 100 200 0'/%3E%3C/svg%3E");
    }
    .container div form label{
        font-size: 20px;
    }
 </style>
    <main class="container">
        <div class="row justify-content-md-center" id='containerMainForm'>

            <form action="" method="POST" class="form col-4">

                <label for="email" class="form-label">Email</label>
                <input type="email" name="email-user" id="email" class="form-control" required>

                <label for="email" class="form-label">Ndocumento</label>
                <input type="number" name="UserDoc" id="email" class="form-control" required>

                <br>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

        </div>


        <?php if (isset($resetPass) && $resetPass) :
        ?>

            <script>
                let containerMainForm = document.querySelector('#containerMainForm');
                containerMainForm.style.display = 'none';
            </script>

            <div class="row justify-content-md-center">

                <form action="" method="POST" class="form col-4">

                    <label for="pass" class="form-label">Nueva contraseña</label>
                    <input type="password" name="NewPasswordUser" id="pass" class="form-control" required>
                    <label for="passv" class="form-label">Repita la contraseña</label>
                    <input type="password" name="verifyPasswordUser" id="passv" class="form-control" required>
                    <input type="hidden" value="<?php echo $results1['Correo'] ?>" name="email-user">
                    <input type="hidden" value="<?php echo $results1['Ndocumento'] ?>" name="UserDoc">

                    <br>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

            </div>

        <?php endif;
        ?>

    </main>



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

<!-- <script>
    Swal.fire(
        'Atencion',
        'Necesitamos verificar su identidad, por favor ingrese su correo y numero de documento, de ser correctos, podra cambiar su contraseña.',
        'warning'
    )
</script> -->

</body>

</html>