<?php
session_start();

/*
clase
*/

if (isset($_SESSION['Ndocumento'])) {
  header('Location: ./iniciar.php');
}

//importamos conexion base de datos
require '../models/database/database.php';

//si el usuario va a iniciar sesion
if (!empty($_POST['email']) && !empty($_POST['password'])) {

  $email_user = $_POST['email'];
  $password_user = $_POST['password'];

  if (filter_var($email_user, FILTER_VALIDATE_EMAIL)) {

    $consult = " SELECT Correo, Contrasena,Ndocumento FROM usuario WHERE Correo= :correo";
    $parametros = $connection->prepare($consult);
    $parametros->bindParam(':correo', $email_user);
    $parametros->execute();
    $results = $parametros->fetch(PDO::FETCH_ASSOC);

    try {
      if (count($results) > 0 && password_verify($password_user, $results['Contrasena'])) {
        $_SESSION['Ndocumento'] = $results['Ndocumento'];

        header("Location: ./dashboard.php");
      } else {
        //echo '<script>alert("Datos ingresados erroneos")</script>';
        $message = array(' Error', 'Datos ingresados erroneos', 'warning');
      }
    } catch (Exception $e) {
      //echo '<script>alert("Ocurrio un error.$e")</script>';
      $message = array(' Error', 'Ocurrio un error ' . $e, 'error');
    }
  } else {
    //echo "<script>alert('Correo no valido. intente de nuevo.')</script>";
    $message = array(' Error', 'Correo no valido. intente de nuevo.', 'warning');
  }
} //si el usuario va a registrarse
elseif (!empty($_POST['num-doc']) && !empty($_POST['user-email']) && !empty($_POST['user-password']) && !empty($_POST['user-name'])) {

  //variables de datos ingresados
  $email_user = $_POST['user-email'];
  $numdoc = intval($_POST['num-doc']);
  $password_user = $_POST['user-password'];
  $name_user = $_POST['user-name'];

  if (filter_var($email_user, FILTER_VALIDATE_EMAIL)) {

    //consulta que verifica la existencia de el correo ingresado
    $consult = "SELECT Correo FROM usuario WHERE Correo= :useremail ";
    $params = $connection->prepare($consult);
    $params->bindParam(':useremail', $email_user);

    //consulta que verifica la existencia de el documeto ongresado ingresado
    $consult1 = "SELECT Ndocumento FROM usuario WHERE Ndocumento = :numdoc ";
    $params1 = $connection->prepare($consult1);
    $params1->bindParam(':numdoc', $numdoc);

    $ok = ($params->execute()) &&  ($params1->execute());

    if ($ok) { //ejecucion consulta

      $results1 = $params->fetch(PDO::FETCH_ASSOC);
      $results2 = $params1->fetch(PDO::FETCH_ASSOC);

      //si el resultado de la consulta es igual al del ingresado
      if (strtolower($results1["Correo"]) == strtolower($email_user)) {
        $message = array(' Error', 'Correo registrado, revise e intente de nuevo', 'warning');
      } elseif ($results2["Ndocumento"] == $numdoc) {

        $message = array(' Error', 'Numero de documento registrado, revise e intente de nuevo', 'warning');
      } else //si no, entonces se puede registrar al usuario.
      {
        $consult = "INSERT INTO usuario (Ndocumento, Nombre,direccion,Genero,Correo,Contrasena,FechaNacimineto,id,Img_perfil) VALUES (:ndoc, :username, null, null, :useremail, :userpassword, null, :ideps, null)";
        $params = $connection->prepare($consult);
        $params->bindParam(':useremail', $email_user);
        $password = password_hash($password_user, PASSWORD_BCRYPT);
        $params->bindParam(':userpassword', $password);
        $params->bindParam(':username', $name_user);
        $id_eps = 10;
        $params->bindParam(':ideps', $id_eps);
        $params->bindParam(':ndoc', $numdoc);
        //estabklecemos los parametros de la consulta

        if ($params->execute()) {
          $message = array(' Ok Registrado ', ' Realizado correctamente, usuario registrado, inicie sesión, para continuar...', 'success');

          //echo "<script> setTimeout(\"location.href='inicio-secion.php'\",10000);</script>";
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

  <?php //if (!empty($message)) : 
  ?>

  <!-- <script>
    Swal.fire(
      '<?php // echo $message[1];
        ?>',
      '<?php // echo $message[0];
        ?>',
      '<?php // echo $message[2]; 
        ?>')
    </script> -->
  <?php //endif; 
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
  <span class="fa fa-cloud-xmark"></span>
  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">

        <form action="./iniciar.php" method="POST" class="sign-in-form">
          <!-- logo -->
          <a href="index.html">
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
          <p class="social-text" onclick="resetPass();" style="cursor:pointer; padding:5px; outline:1px solid #a5f; ">Recuperar Contraseña.</p>
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
            <input type="text" placeholder="Nombre completo" name="user-name" required />
          </div>
          <div class="input-field">
            <i class="fas fa-id-card"></i>
            <input type="text" placeholder="Numero Documento" name="num-doc" required />
          </div>
          <div class="input-field">
            <i class="fas fa-at"></i>
            <input type="email" placeholder="Email" name="user-email" required />
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
  <script>
    function getRandomInt(min, max) {
      return Math.floor(Math.random() * (max - min)) + min;
    }

    function resetPass() {
      setTimeout(`location.href=\'recupera\'`, 10000);
      /*let correo1 = prompt("Ingrese su correo: \n");
      const token = getRandomInt(333333, 5555555555555); 
      if (correo1 !== null && correo1 !== "" ){
        setTimeout(`location.href=\'recupera.php?user_correo=${correo1}&token=${token};\'`,1500);
      }else{
        alert("Correo No valido, ingrese nuevamente.")
      }
       */
    }
  </script>
</body>

</html>