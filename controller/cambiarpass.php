<?php
//inicar la secion del usuario y verificar que este logeado
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
}
//traer la base de datos o conexion
require_once '../models/database/database.php';
//traer el modelo de usuario para consultar la contraseña
require_once '../models/user.php';


//verificar que los campos no esten vacios
if (isset($_POST['pass']) && isset($_POST['nueva']) && isset($_POST['confirmar'])) {

    //recibir los datos del formulario y guardarlos en variables
    $pass = $_POST['pass'];
    $nueva = $_POST['nueva'];
    $confirmar = $_POST['confirmar'];
    /*
buscar contraseña actual del usuario
    $query1='SELECT Contrasena FROM usuario WHERE Ndocumento = :id';
    $query = $connection->prepare($query1);
    $query->bindParam(':id', $_SESSION['user_id']);
    $query->execute();
    $contraseñaactual = $query->fetch(PDO::FETCH_ASSOC);
    */
    $user = getUser($_SESSION['user_id']);
    //verificar que la contraseña actual sea igual a la que se ingreso en el formulario
    if (password_verify($pass, $user['Contrasena'])) {

        //verificar que la nueva contraseña sea igual a la confirmacion
        if ($nueva == $confirmar) {
            //encriptar la nueva contraseña
            $nueva = password_hash($nueva, PASSWORD_BCRYPT);
            //actualizar la contraseña en la base de datos
            $query1 = 'UPDATE usuario SET Contrasena = :nueva WHERE Ndocumento = :id';
            $query = $connection->prepare($query1);
            $query->bindParam(':id', $_SESSION['user_id']);
            $query->bindParam(':nueva', $nueva);
            //verificar que la contraseña se haya actualizado correctamente
            if ($query->execute()) {
                $message = array('Exito ', ' Realizado correctamente', 'success');
            } else {
                $message = array('Error', 'Ocurrio un error al actulizar contraseña.', 'error');
            }
        } else {
            $message = array('Error', 'Las nuevas contraseñas no coinciden, intente de nuevo', 'warning');
        }
    } else {
        $message = array('Error', 'Contraseña actual incorrecta, intente de nuevo', 'error');
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- favicon -->
    <link rel="shortcut icon" type="image/png" href="../views/assets/img/logo.png">
    <!-- google font -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <!-- fontawesome -->
    <link rel="stylesheet" href="../views/assets/css/all.min.css">
    <!-- bootstrap -->
    <link rel="stylesheet" href="../views/assets/bootstrap/css/bootstrap.min.css">
    <!-- animate css -->
    <link rel="stylesheet" href="../views/assets/css/animate.css">
    <!-- mean menu css -->
    <link rel="stylesheet" href="../views/assets/css/meanmenu.min.css">
    <!-- main style -->
    <link rel="stylesheet" href="../views/assets/css/main.css">
    <!-- responsive -->
    <link rel="stylesheet" href="../views/assets/css/responsive.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <!-- use Sweet Alerts2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <style>
        input {
            width: 99%;
            padding: 15px;
            border: 2px solid #4b0081;
            border-radius: 5px;
        }

        .feature-bg1:after {
            background-image: url(../views/assets/img/password.jpg);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            padding: 100px 0;
        }

        label {
            color: #4b0081;
            font-size: larger;
            font-weight: bolder;
        }



        .learn-more .circle {
            transition: all 0.45s cubic-bezier(0.65, 0, 0.076, 1);
            position: relative;
            display: block;
            margin: 0;
            width: 3rem;
            height: 3rem;
            background: #4ba7cf;
            border-radius: 1.625rem;
        }

        .learn-more .button-text {
            -webkit-transition: all 0.45s cubic-bezier(0.65, 0, 0.076, 1);
            transition: all 0.45s cubic-bezier(0.65, 0, 0.076, 1);
            position: absolute;
            top: 0;
            left: 1.9em;
            width: 13.4em;
            padding: 0.75rem 0;
            margin: 0 0 0 1rem;
            color: #004d6e;
            font-weight: 700;
            line-height: 1.6;
            text-align: center;
            text-transform: uppercase;
        }
    </style>
    <title>Cambiar contraseña</title>
</head>

<body>
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


    <!--PreLoader-->
    <div class="loader">
        <div class="inner"></div>
        <div class="inner"></div>
        <div class="inner"></div>
        <div class="inner"></div>
        <div class="inner"></div>
    </div>
    <!--PreLoader Ends-->
    <!-- contact form -->
    <div class="feature-bg1">
        <a href="../views/perfil.php" class="learn-more">
            <span class="circle" aria-hidden="true"></span>
            <span class="button-text">Regresar</span>
        </a>
        <div class="contact-from-section mt-150 mb-150">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mb-5 mb-lg-0">
                        <div class="form-title">
                            <h2>
                                Cambiar Contraseña
                            </h2>
                        </div>
                        <div id="form_status"></div>
                        <div class="contact-form">
                            <form method="post" action="">
                                <p>
                                    <label for="pass">Contraseña Actual</label>
                                    <input type="password" name="pass" id="pass" required>
                                </p>
                                <p>
                                    <label for="pass2">Contraseña Nueva</label>
                                    <input type="password" name="nueva" id="pass2" required>
                                </p>
                                <p>
                                    <label for="pass3">Confirmar Nueva contraseña</label>
                                    <input type="password" name="confirmar" id="pass3" required>
                                </p>

                                <input type="submit" value="Enviar">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <!--PreLoader Ends-->

    <footer>


        <!-- footer -->
        <div class="copyright">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <p>Copyrights &copy; <?= date('Y') ?> - <a href="https://imransdesign.com/">SECØDE_QR</a>, Salud e información al instante.</p>
                    </div>
                    <div class="col-lg-6 text-right col-md-12">
                        <div class="social-icons">
                            <ul>
                                <li><a href="https://www.facebook.com/profile.php?id=100083136654560" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="https://twitter.com/TeamSecode" target="_blank"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="https://www.instagram.com/teamsecode/" target="_blank"><i class="fab fa-instagram"></i></a></li>
                                <li><a href="https://github.com/Jhonatan2022/SECODE_QR" target="_blank"><i class="fab fa-github"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end footer -->

    </footer>


    <!-- jquery -->
    <script src="../views/assets/js/jquery-1.11.3.min.js"></script>
    <!-- bootstrap -->
    <script src="../views/assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- isotope -->
    <script src="../views/assets/js/jquery.isotope-3.0.6.min.js"></script>
    <!-- magnific popup -->
    <script src="../views/assets/js/jquery.magnific-popup.min.js"></script>
    <!-- mean menu -->
    <script src="../views/assets/js/jquery.meanmenu.min.js"></script>
    <!-- sticker js -->
    <script src="../views/assets/js/sticker.js"></script>
    <!-- main js -->
    <script src="../views/assets/js/main.js"></script>


</body>

</html>