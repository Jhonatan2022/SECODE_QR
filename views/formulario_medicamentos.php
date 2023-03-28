<?php
session_start();

//importamos DB
require_once('../models/database/database.php');
require_once '../models/user.php';

// si el usuario no ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
  $message = array(' Advertencia', 'Antes de ingresar datos debe iniciar sesión', 'warning');
  $ClinicData = [ //datos de registro de ejmplo
    'Titulo' => '',
    'Nombre' => '',
    'FechaNacimiento' => '',
    'NombreEps' => '',
    'Telefono' => '',
    'Correo' => '',
    'Genero' => '',
    'Estrato' => '',
    'Localidad' => '',
    'TipoAfiliacion' => '',
    'RH' => '',
    'Tipo_de_sangre' => '',
    'IDcondicionesClinicas' => '',
    'AlergiaMedicamento' => '',
  ];
} else {


  $countQR = getQRCount($_SESSION['user_id']);
  $suscripcion = getSuscription($_SESSION['user_id']);
  if (intval($suscripcion['cantidad_qr']) <= $countQR) {
    header('Location: dashboard.php?GenerateError=1');
  }
  if (isset($_GET['idFormEdit']) && $suscripcion['Editar'] == 'NO') {
    header('Location: dashboard.php?GenerateError=2');
  }

  if (isset($_GET['idFormEdit']) && $suscripcion['Editar'] == 'SI') {
    $id_code = $_GET['idFormEdit'];
    $newForm = false;
  } else {
    $newForm = true;
    $id_code = '';
  }
  if (
    isset($_GET['GenerateError']) &&
    !empty($_GET['GenerateError'])
  ) {
    $statusForm = $_GET['GenerateError'];
    if ($statusForm == 1) {
      $message = array('Error', 'El formato del archivo ingresado no es correcto o excede el limite de 3Mb', 'error');
    } elseif ($statusForm == 22) {
      $statusForm = $_GET['GenerateError'];
      $message = array('Realizado correctamente', 'Ingrese a su dashboard y verifique sus codigos. En un momento sera redirigido.', 'success');
      $id_code = $_GET['Data'];
      $id_codealert = $_GET['Data'];
    }
  }


  $user = getUser($_SESSION['user_id']);

  if ($user['id'] == 10 && $newForm) {
    global $newEps;
    $newEps = true;
    $eps = eps();
  }
  $suscripcion = getSuscription($user['Ndocumento']);
  if($suscripcion['RellenarFormulario'] == 'SI'){
  $ClinicData = getClinicData($_SESSION['user_id'], $newForm, $id_code);
  }else{
    $ClinicData = [ //datos de registro de ejemplo
      'Titulo' => '',
      'Nombre' => '',
      'FechaNacimiento' => '',
      'NombreEps' => '',
      'Telefono' => '',
      'Correo' => '',
      'Genero' => '',
      'Estrato' => '',
      'Localidad' => '',
      'TipoAfiliacion' => '',
      'RH' => '',
      'Tipo_de_sangre' => '',
      'IDcondicionesClinicas' => '',
      'AlergiaMedicamento' => '',
    ];
  }

}
$afiliacion = afiliacion();
$rh = rh();
$tipoSangre = tipoSangre();
$condicion = condicionClinica();
$alergia = alergia();
$estrato = estrato();
$localidad = localidad();
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulario solicitud medicamentos</title>
  <link rel="shortcut icon" type="image/png" href="./assets/img/logo.png">
  <!-- google font -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="assets/css/formstyle.css">
  <!-- fontawesome -->
  <link rel="stylesheet" href="assets/css/all.min.css">
  <!-- bootstrap -->
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <!-- animate css -->
  <link rel="stylesheet" href="assets/css/animate.css">
  <!-- mean menu css -->
  <link rel="stylesheet" href="assets/css/meanmenu.min.css">
  <!-- main style -->
  <link rel="stylesheet" href="assets/css/main.css">
  <!-- responsive -->
  <link rel="stylesheet" href="assets/css/responsive.css">

  <?php include('./templates/sweetalerts2.php') ?>
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
  <?php if (isset($id_code) && isset($statusForm) && $statusForm == 22) : ?>
    <script>
      setTimeout(() => {
        location.href = 'dashboard.php?DataCode=<?php echo $id_code; ?>';
      }, 5000);
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

  <?php include('./templates/navBar.php') ?>


    <!-- breadcrumb-section -->
    <div class="breadcrumb-section breadcrumb-bg">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 offset-lg-2 text-center">
            <div class="breadcrumb-text">
              <p>SECØDE_QR</p>
              <h1>Solicitud de medicamentos</h1>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- end breadcrumb section -->
  <!-- Formulario -->
  <div class="container_form">
    <div class="screen">
      <div class="screen__content">
        <form action="../controller/pdf/PdfGeneratorForm.php?formulario=medico" method="POST" enctype="multipart/form-data">
          <?php if (empty($ClinicData)) {
            $message = array('Advertencia', 'solo Puede llenar el formulario una vez, o no tiene permisos de edicion', 'warning');
            echo '</form>';
          } else { ?>
            <?php foreach ($ClinicData as $key => $value) { ?>
              <?php
              switch ($key) {
                case 'Titulo': ?>
                  <div class="item">
                    <p>Titulo del formulario</p>
                    <input type="text"  name="<?= $key ?>" value="<?php $value ?>" maxlength="30" />
                  </div>
                  <?php break; ?>

                <?php
                case 'Nombre': ?>
                  <div class="item">
                    <p>Nombres</p>
                    <input type="text" disabled name="<?= $key ?>" required value="<?= $value ?>" />
                  </div>
                  <?php break; ?>

                <?php
                case 'FechaNacimiento':
                  $val = date('Y-m-d', strtotime($value)); ?>
                  <div class="item">
                    <p>Fecha de nacimiento</p>
                    <input type="date" disabled name="<?= $key ?>" value="<?= $val ?>" required style="color: black;" />
                  </div>
                  <?php break; ?>

                <?php
                case 'NombreEps': ?>
                  <h5>1. Datos generales</h5>
                  <div class="item">
                    <p>EPS<span class="required">*</span></p>

                    <select class="form-control" name='<?= $key ?>' disabled>
                      <?php if (isset($newEps) && $newEps) { ?>
                        <?php foreach ($eps as $keyEps => $valueEPS) {  ?>

                          <?php if ($valueEPS['id'] == $user['id']) { ?>
                            <option value="<?php echo $valueEPS['id'] ?>" selected><?php echo $valueEPS['NombreEps'] ?></option>
                          <?php } else {
                          ?>
                            <option value="<?php echo $valueEPS['id'] ?>"><?php echo $valueEPS['NombreEps'] ?></option>
                          <?php } ?>

                        <?php } ?>
                      <?php } else {  ?>
                        <option value="<?php echo $value ?>"><?php echo $value ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <?php break; ?>

                <?php
                case 'Telefono': ?>
                  <div class="item">
                    <p>Telefono de contacto<span class="required">*</span></p>
                    <input type="tel" disabled name="<?= $key ?>" value="<?= $value ?>" required />
                  </div>
                  <?php break; ?>

                <?php
                case 'Correo': ?>
                  <div class="item">
                    <p>Correo electronico<span></span></p>
                    <input type="email" disabled name="<?= $key ?>" value="<?= $value ?>" required />
                  </div>
                  <?php break; ?>

                <?php
                case 'Genero': ?>
                  <div class="question">
                    <p>Genero<span></span></p>

                    <select class="form-control" id="<?= $key ?>" disabled name="<?= $key ?>">
                      <option value="1" <?php if ($value === '1') {
                                          echo 'selected';
                                        } ?>>Masculino</option>
                      <option value="2" <?php if ($value === '2') {
                                          echo 'selected';
                                        } ?>>Femenino</option>
                    </select>

                  </div>
                  <?php break; ?>
                <?php
                case 'Estrato': ?>
                  <div class="item">
                    <p>Estrato<span></span></p>

                    <select class="form-control" id="<?= $key ?>" disabled name="<?= $key ?>">
                      <?php foreach ($estrato as $keylocalidad => $valuelocalidad) { ?>
                        <option value="<?= $valuelocalidad['IDEstrato'] ?>" <?php if ($value === $valuelocalidad['IDEstrato']) {echo 'selected';} ?>>
                          <?= $valuelocalidad['Estrato'] ?></option>
                      <?php } ?>
                    </select>

                  </div>
                <?php break; ?>
                <?php
                default: ?>
                
              <?php break;
              } ?>

            <?php  } ?>
            <br />
            <div class="question">
              <div class="question-answer checkbox-item">
                <div class="question">
                  <p>Adjuntar formula medica<span class="required"></span></p>
                  <input type="file" name="imagenFormula" required />
                </div>
              </div>
            </div>
            <br>
            <br>
            <?php if (!isset($_SESSION['user_id'])) { ?>
              <a href="./iniciar.php"><button type="button">INICIA SESION </button></a>
            <?php  } else { ?>
              <button type="submit" id="BtnSendFormClinic">
                Generar codigo
              </button>

            <?php  } ?>
        </form>
      </div>
      <div class="screen__background">
          <span
            class="screen__background__shape screen__background__shape5"
          ></span>
          <span
            class="screen__background__shape screen__background__shape4"
          ></span>
          <span
            class="screen__background__shape screen__background__shape3"
          ></span>
          <span
            class="screen__background__shape screen__background__shape2"
          ></span>
          <span
            class="screen__background__shape screen__background__shape1"
          ></span>
        </div>
    </div>
  </div>
<?php  } ?>



<!-- end formulario -->
<!-- footer -->
<div class="footer-area">
  <div class="container">
    <div class="row">
      <div class="col-lg-3 col-md-6">
        <div class="footer-box about-widget">
          <h2 class="widget-title">Misión</h2>
          <p>El proyecto surge debido a la problemática de la accesibilidad y coste de poseer su información médica, por lo tanto se plantea administrar o adjuntar a través de un código QR, el manejo de dicha información.</p>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="footer-box get-in-touch">
          <h2 class="widget-title">Visión</h2>
          <p>Impactar a la problematica social,mediante las Tecnologias de la informacion, durante 3 semestres.</p>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end footer -->

<? include_once './templates/footer_copyrights.php'; ?>
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

<!-- jquery -->
<script src="assets/js/jquery-1.11.3.min.js"></script>
<!-- bootstrap -->
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<!-- isotope -->
<script src="assets/js/jquery.isotope-3.0.6.min.js"></script>
<!-- magnific popup -->
<script src="assets/js/jquery.magnific-popup.min.js"></script>
<!-- mean menu -->
<script src="assets/js/jquery.meanmenu.min.js"></script>
<!-- sticker js -->
<script src="assets/js/sticker.js"></script>
<!-- main js -->
<script src="assets/js/main.js"></script>

<!-- <script src='https://unpkg.co/gsap@3/dist/gsap.min.js'></script>

  <script src='https://assets.codepen.io/16327/SplitText3.min.js'></script> -->
  <script src="assets/js/formscript.js"></script>

    </script>
</body>

</html>