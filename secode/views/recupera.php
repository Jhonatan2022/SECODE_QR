<?php


session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: ./iniciar.php');
}

//importamos conexion base de datos
require '../models/database/database.php';


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
        filter_var($userDoc, FILTER_VALIDATE_INT) &&
        filter_var($tokenEmail, FILTER_VALIDATE_INT)/* &&
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

            if(!empty($_POST['NewPasswordUser']) &&
            !empty($_POST['verifyPasswordUser']) &&
            isset($_GET['tokenUserMail'])&&
            $_GET['tokenUserMail'] == $results1['token_reset']
            ){
                if($_POST['NewPasswordUser'] ==
                $_POST['verifyPasswordUser']){

                    $NewPassword = password_hash($_POST['NewPasswordUser'], PASSWORD_BCRYPT);
                    $param = $connection->prepare('UPDATE ');
                    $param->bindParam(':Newpass',$NewPassword);


                }else{
                    $message = array(' Error', 'Las contraseñas no coinciden, intente de nuevo.', 'warning');
                }
                
            }else{
                $message = array(' Error', 'Token de seguridad diferente, por seguridad Intente Nuevamente con un token valido', 'error');
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

    <?php include('./templates/header.php'); ?>


    <?php include('./templates/sweetalerts2.php'); ?>
    <title>Recupera Passwod</title>
</head>

<body>

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

<div class="row justify-content-md-center" >

<form action="" method="POST" class="form col-4">

    <label for="pass" class="form-label">Nueva contraseña</label>
    <input type="password" name="NewPasswordUser" id="pass" class="form-control" required>
    <label for="passv" class="form-label">Repita la contraseña</label>
    <input type="password" name="verifyPasswordUser" id="passv" class="form-control" required>


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



</body>

</html>