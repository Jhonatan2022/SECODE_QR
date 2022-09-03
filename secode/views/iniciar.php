<?php
session_start();

/*
clase
*/

if (isset($_SESSION['user_id'])) {
  header('Location: ./index.php');
}

//importamos conexion base de datos
require '../models/database/database.php';

//si el usuario va a iniciar sesion
if (!empty($_POST['email']) && !empty($_POST['password'])) {

  $email_user1 = $_POST['email'];
  $password_user1 = $_POST['password'];

  if (filter_var($email_user1, FILTER_VALIDATE_EMAIL)) {

    $consult = " SELECT Correo,Contrasena,Ndocumento,Direccion, Genero, FechaNacimiento,Telefono, Img_perfil, TipoImg
    FROM usuario WHERE Correo= :correo";
    $parametros = $connection->prepare($consult);
    $parametros->bindParam(':correo', $email_user1);
    $parametros->execute();
    $results = $parametros->fetch(PDO::FETCH_ASSOC);

    if (!empty($results)) {
      try {
        if (count($results) > 0 && password_verify($password_user1, $results['Contrasena'])) {

          //varaibles user definition from session
          $_SESSION['user_id'] = $results['Ndocumento'];
          $_SESSION['Direccion'] = $results['Direccion'];
          $_SESSION['Genero'] = $results['Genero'];
          $_SESSION['FechaNacimiento'] = $results['FechaNacimiento'];
          $_SESSION['Telefono'] = $results['Telefono'];
          $_SESSION['Img_perfil'] = $results['Img_perfil'];
          $_SESSION['TipoImg'] = $results['TipoImg'];
          header("Location: ./dashboard.php");
        } else {

          $message = array(' Error', 'Datos ingresados erroneos', 'warning');
        }
      } catch (Exception $e) {

        $message = array(' Error', `Ocurrio un error $e`, 'error');
      }
    } else {
      $message = array(' Error', 'Correo no Registrado, primero registrese e intente de nuevo.', 'warning');
    }
  } else {

    $message = array(' Error', 'Correo no valido. intente de nuevo.', 'warning');
  }
} //si el usuario va a registrarse
elseif (!empty($_POST['num-doc']) && !empty($_POST['user-email']) && !empty($_POST['user-password']) && !empty($_POST['user-name'])) {

  //variables de datos ingresados
  $email_user = $_POST['user-email'];
  $numdoc = intval($_POST['num-doc']);
  $password_user = $_POST['user-password'];
  $name_user = $_POST['user-name'];
  $token=rand(124324, 876431167878435);

  if (filter_var($email_user, FILTER_VALIDATE_EMAIL)) {

    //consulta que verifica la existencia de el correo ingresado
    $consult = "SELECT Correo,Ndocumento FROM usuario WHERE Correo= :useremail OR Ndocumento= :Ndocument";
    $params = $connection->prepare($consult);
    $params->bindParam(':Ndocument', $numdoc);
    $params->bindParam(':useremail', $email_user);

    if ($params->execute()) { //ejecucion consulta

      $results1 = $params->fetch(PDO::FETCH_ASSOC);

      //si el resultado de la consulta es igual al del ingresado
      if (!empty($results1)) {
        if (strtolower($results1["Correo"]) == strtolower($email_user)) {
          $message = array(' Error', 'Correo registrado, revise e intente de nuevo', 'warning');
        } elseif ($results1["Ndocumento"] == $numdoc) {

          $message = array(' Error', 'Numero de documento registrado, revise e intente de nuevo', 'warning');
        }
      } else {
        $consult = "INSERT INTO usuario 
        (Ndocumento, Nombre,direccion,Genero,Correo,Contrasena,FechaNacimiento,id,Img_perfil,token_reset,TipoImg) 
        VALUES 
        (:ndoc, :username, null, null, :useremail, :userpassword, null, :ideps, null, :token, null)";
        $params = $connection->prepare($consult);
        $params->bindParam(':useremail', $email_user);
        $password = password_hash($password_user, PASSWORD_BCRYPT);
        $params->bindParam(':userpassword', $password);
        $params->bindParam(':username', $name_user);
        $id_eps = 10;
        $params->bindParam(':ideps', $id_eps);
        $params->bindParam(':ndoc', $numdoc);
        $params->bindParam(':token', $token);
        //estabklecemos los parametros de la consulta

        if ($params->execute()) {
          $message = array(' Ok Registrado ', ' Realizado correctamente, usuario registrado, inicie sesión, para continuar...', 'success');

        } else {
          $message = array(' Error', 'Perdon hubo un error al crear el usuario', 'error');
        }
      }
    } else {

      $message = array(' Error', 'Perdon hubo un error al crear el usuario', 'error');
    }
  } else {

    $message = array(' Error', 'Correo no valido. intente de nuevo.', 'warning');
  }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Iniciar y registrar</title>
  <!-- fontawesome -->
  <link rel="stylesheet" href="assets/css/all.min.css">
  <!-- estilos -->
  <link rel="stylesheet" href="assets/css/styles.css" />
  <!-- favicon -->
  <link rel="shortcut icon" type="image/png" href="./assets/img/logo.png">
  <link rel="stylesheet" href="npm i bootstrap-icons">
  <!-- google font -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
  <!-- fontawesome -->

  <?php
  include('./templates/sweetalerts2.php');
  ?>

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
  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">

        <form action="./iniciar.php" method="POST" class="sign-in-form">
          <!-- logo -->
          <a href="./index.php">
            <img src="assets/img/logo.png" alt=""> </a>
          <!-- logo -->
          <h2 class="title">Iniciar sesión</h2>
          <div class="input-field">
            <i class="fa fa-at"></i>
            <input type="email" name="email" placeholder="Correo" required />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" placeholder="Contraseña" required />
          </div>
          <input type="submit" value="Ingresar" class="btn solid" />
          <a class="social-text" href="recupera.php"  style="cursor:pointer; padding:5px; outline:1px solid #a5f; ">Recuperar Contraseña.</a>
          <p class="social-text">Puedes iniciar con estas plataformas.</p>
          <div class="social-media">
            <a href="#" class="social-icon">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-google"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-linkedin-in"></i>
            </a>
          </div>
        </form>
        <form action="./iniciar.php" class="sign-up-form" method="POST">
          <!-- logo -->
          <a href="index.html">
            <img src="assets/img/logo.png" alt=""> </a>
          <!-- logo -->
          <h2 class="title">Registrarse</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Nombre completo" maxlength="200" name="user-name" required />
          </div>
          <div class="input-field">
            <i class="fas fa-id-card"></i>
            <input type="number" placeholder="Numero Documento" name="num-doc" maxlength="10" required />
          </div>
          <div class="input-field">
            <i class="fas fa-at"></i>
            <input type="email" placeholder="Email" maxlength="150" name="user-email" required />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Password" name="user-password" required />
          </div>
          <input type="submit" class="btn" value="Registrar" />

          <p class="social-text">Puedes iniciar con estas plataformas.</p>
          <div class="social-media">
            <a href="#" class="social-icon">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-google"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-linkedin-in"></i>
            </a>
          </div>
        </form>
      </div>
    </div>

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h3>Eres nuevo ?</h3>
          <p>
            Oprime el botón para registrarte.
          </p>
          <button class="btn transparent" id="sign-up-btn">
            Registrarse
          </button>
        </div>
        <img src="./assets/img/log.svg" class="image" alt="" />
      </div>
      <div class="panel right-panel">
        <div class="content">
          <h3>Ya tienes cuenta ? </h3>
          <p>
            Oprime el botón para iniciar sesión.
          </p>
          <button class="btn transparent" id="sign-in-btn">
            Iniciar sesión
          </button>
        </div>
        <img src="./assets/img/register.svg" class="image" alt="" />
      </div>
    </div>
  </div>

  <script src="assets/js/app.js"></script>
  <!-- jquery -->
  <script src="assets/js/jquery-1.11.3.min.js"></script>
  <!-- main js -->
  <script src="assets/js/main.js"></script>

</body>

</html>