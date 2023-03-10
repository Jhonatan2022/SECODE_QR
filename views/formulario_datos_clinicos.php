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
    'TipoAfiliacion' => '',
    'RH' => '',
    'Tipo_de_sangre' => '',
    'IDcondicionesClinicas' => '',
    'AlergiaMedicamento' => '',
  ];
} else {



  //funtionalities advanced pro
  /*
  if (!$newForm) {
    $param = $connection->prepare('SELECT us.Nombre, us.Direccion, us.FechaNacimiento, us.Genero, dta.RH,dta.TipoAfiliacion, dta.TipoSubsidio, dta.Tipo_de_sangre, dta.AlergiaMedicamento 
    FROM usuario AS us 
    LEFT OUTER JOIN datos_clinicos AS dta 
    ON dta.NDocumento = :id_user
    LEFT OUTER JOIN codigo_qr as qr
    ON qr.DatosClinicos = dta.IDDatosClinicos; ');
    //$param->bindParam(':id_code', $id_code1);
    $param->bindParam(':id_user', $_SESSION['user_id']);

    if ($param->execute()) {
      $results = $param->fetch(PDO::FETCH_ASSOC);

      //echo 'ok' . $results['Nombre'];
    } else {
      $message = array(' Advertencia', 'Antes de ingresar datos debe iniciar sesión', 'warning');
    }

    //Seting data strings

    $nombreUser = $results['Nombre'];
  }
  */
  $countQR=getQRCount($_SESSION['user_id']);
  $suscripcion = getSuscription($_SESSION['user_id']);
  if(intval($suscripcion['cantidad_qr']) <= $countQR ){
    header('Location: dashboard.php?GenerateError=1');
  }
  if(isset($_GET['idFormEdit']) && $suscripcion['Editar'] == 'NO'){
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
      $message = array('Error', 'Hubo un error en el preoceso, intente nuevamente', 'error');
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

  $ClinicData = getClinicData($_SESSION['user_id'], $newForm, $id_code);
  $suscripcion = getSuscription($user['Ndocumento']);
}
$afiliacion = afiliacion();
$rh = rh();
$tipoSangre = tipoSangre();
$condicion = condicionClinica();
$alergia = alergia();


?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Datos basicos</title>
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
            <h1>Datos Clínicos</h1>
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
        <form action="../controller/pdf/PdfGeneratorForm.php?formulario=clinico<?php if (isset($_GET['idFormEdit']) && $suscripcion['Editar'] == 'SI') {echo '&idclinico=' . $_GET['idFormEdit'];} ?>" method="POST" novalidate>
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
                    <input type="text" name="<?= $key ?>" value="<?php $value ?>" />
                  </div>
                  <?php break; ?>

                <?php
                case 'Nombre': ?>
                  <div class="item">
                    <p>Nombres</p>
                    <input type="text" name="<?= $key ?>" required value="<?= $value ?>" />
                  </div>
                  <?php break; ?>

                <?php
                case 'FechaNacimiento':
                  $val = date('Y-m-d', strtotime($value)); ?>
                  <div class="item">
                    <p>Fecha de nacimiento</p>
                    <input type="date" name="<?= $key ?>" value="<?= $val ?>" required style="color: black;" />
                  </div>
                  <?php break; ?>

                <?php
                case 'NombreEps': ?>
                  <h5>1. Datos generales</h5>
                  <div class="item">
                    <p>EPS<span class="required">*</span></p>

                    <select class="form-control" name='<?= $key ?>'>
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
                    <input type="tel" name="<?= $key ?>" value="<?= $value ?>" required />
                  </div>
                  <?php break; ?>

                <?php
                case 'Correo': ?>
                  <div class="item">
                    <p>Correo electronico<span></span></p>
                    <input type="email" name="<?= $key ?>" value="<?= $value ?>" required />
                  </div>
                  <?php break; ?>

                <?php
                case 'Genero': ?>
                  <div class="question">
                    <p>Genero<span></span></p>

                    <select class="form-control" id="<?= $key ?>" name="<?= $key ?>">
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
                case 'TipoAfiliacion': ?>
                  <br>
                  <h5>2. Socio economico</h5>
                  <br>
                  <div class="question">
                    <p>Tipo de afiliacion con la EPS <span class="required">*</span></p>
                    <div class="question-answer">

                      <?php foreach ($afiliacion as $keyAf => $valueAf) { ?>
                        <?php if ($valueAf['IDAfiliacion'] == $value) { ?>
                          <input type="radio" value="<?= $valueAf['IDAfiliacion'] ?>" id="<?= $valueAf['IDAfiliacion'] ?>" name="<?= $key ?>" required checked />
                          <label for="<?= $valueAf['IDAfiliacion'] ?>" class="radio"><span><?= $valueAf['Afiliacion'] ?></span></label>
                        <?php } else { ?>
                          <input type="radio" value="<?= $valueAf['IDAfiliacion'] ?>" id="<?= $valueAf['IDAfiliacion'] ?>" name="<?= $key ?>" required />
                          <label for="<?= $valueAf['IDAfiliacion'] ?>" class="radio"><span><?= $valueAf['Afiliacion'] ?></span></label>
                        <?php } ?>

                      <?php } ?>
                    </div>
                  </div>
                  <?php break; ?>

                <?php
                case 'RH': ?>
                  <br>
                  <h5>1.Datos clinicos:</h5>
                  <div class="question">
                    <p>RH<span class="required"></span></p>
                    <div class="question-answer">


                      <?php foreach ($rh as $keyrh => $valuerh) { ?>
                        <?php if ($valuerh['IDRH'] == $value) { ?>
                          <input type="radio" value="<?= $valuerh['IDRH'] ?>" id="<?= $valuerh['IDRH'] . $keyrh ?>" name="<?= $key ?>" required checked />
                          <label for="<?= $valuerh['IDRH'] . $keyrh ?>" class="radio"><span><?= $valuerh['RH'] ?></span></label>
                        <?php } else { ?>
                          <input type="radio" value="<?= $valuerh['IDRH'] ?>" id="<?= $valuerh['IDRH'] . $keyrh ?>" name="<?= $key ?>" required />
                          <label for="<?= $valuerh['IDRH'] . $keyrh ?>" class="radio"><span><?= $valuerh['RH'] ?></span></label>
                        <?php } ?>

                      <?php } ?>
                    </div>
                  </div>
                  <?php break; ?>

                <?php
                case 'Tipo_de_sangre': ?>
                  <br>
                  <div class="question">
                    <p>Tipo de sangre<span class="required"></span></p>
                    <div class="question-answer">



                      <?php foreach ($tipoSangre as $keytps => $valuetps) { ?>
                        <?php if ($valuetps['IDTipoSangre'] == $value) { ?>
                          <input type="radio" value="<?= $valuetps['IDTipoSangre'] ?>" id="<?= $valuetps['TipoSangre'] . $keytps ?>" name="<?= $key ?>" required checked />
                          <label for="<?= $valuetps['TipoSangre'] . $keytps ?>" class="radio"><span><?= $valuetps['TipoSangre'] ?></span></label>
                        <?php } else { ?>
                          <input type="radio" value="<?= $valuetps['IDTipoSangre'] ?>" id="<?= $valuetps['TipoSangre'] . $keytps ?>" name="<?= $key ?>" required />
                          <label for="<?= $valuetps['TipoSangre'] . $keytps ?>" class="radio"><span><?= $valuetps['TipoSangre'] ?></span></label>
                        <?php } ?>

                      <?php } ?>
                    </div>
                  </div>
                  <br>
                  <?php break; ?>

                <?php
                case 'arraycond': ?>
                  <br>
                  <div class="question">
                    <p>¿Cuenta con alguna de las siguientes condiciones?:<span class="required">*</span></p>
                    <div class="question-answer checkbox-item">


                      <?php foreach ($condicion as $keycond => $valuecond) { ?>

                        <?php if ($value == null || $value == '' ) { ?>

                          <div>
                            <input type="checkbox" value="<?= $valuecond['IDCondicionClinica'] ?>" id="<?= $valuecond['CondicionClinica'] . $keycond ?>" name="<?= $key ?>" required />
                            <label for="<?= $valuecond['CondicionClinica'] . $keycond ?>" class="check"><span><?= $valuecond['CondicionClinica'] ?></span></label>
                          </div>
                          
                          <?php } //falta guardar datso en array y luego pasarlos a la base de datos
                          
                          else {
                            $datarray = json_decode($value, true);
                            $arrayName = array();
                            foreach ($datarray as $keydat => $valuedat) {
                              $arrayName += array($keydat => $valuedat);
                            }
                            //var_dump($arrayName);
                            if (in_array($valuecond['CondicionClinica'], $arrayName)) {
                              $checked = 'checked';
                            } else {
                              $checked = '';
                            }
                           

                          //print_r($arrayName);

                          //$value2 = json_decode($value, true);

                          //foreach ($datarray as $keydat => $valuedat) {
                          /* for ($position = 1; $position < count($value2)+1; $position++) {
                            $valor = $value2[$position];

            
                          } */
                          ?>
                            <div>
                              <input type="checkbox" value="<?= $valuecond['IDCondicionClinica'] ?>" id="<?= $valuecond['CondicionClinica'] . $keycond ?>" name="<?= $key ?>" <?= $checked ?> required />
                              <label for="<?= $valuecond['CondicionClinica'] . $keycond ?>" class="check"><span><?= $valuecond['CondicionClinica'] ?></span></label>
                            </div>


                          <?php }  } ?>



                        
                      
                      <div class="item">
                        <p>Otro<span class="required"></span></p>
                        <input type="text" name="<?php $key ?>" required placeholder="Especificar condición" />
                      </div>
                    </div>
                  </div>
                  <br>
                  <?php break; ?>

                <?php
                case 'AlergiaMedicamento': ?>
                  <br>
                  <div class="question">
                    <p>¿Es alergico algun medicamento?<span class="required"></span></p>
                    <div class="question-answer">

                      <?php foreach ($alergia as $keyal => $valueal) { ?>
                        <?php if ($valueal['IDAlergiaMedicamento'] == $value) { ?>
                          <input type="radio" value="<?= $valueal['IDAlergiaMedicamento'] ?>" id="<?= $valueal['AlergiaMedicamento'] . $keyal ?>" name="<?= $key ?>" required checked />
                          <label for="<?= $valueal['AlergiaMedicamento'] . $keyal ?>" class="radio"><span><?= $valueal['AlergiaMedicamento'] ?></span></label>
                        <?php } else { ?>
                          <input type="radio" value="<?= $valueal['IDAlergiaMedicamento'] ?>" id="<?= $valueal['AlergiaMedicamento'] . $keyal ?>" name="<?= $key ?>" required />
                          <label for="<?= $valueal['AlergiaMedicamento'] . $keyal ?>" class="radio"><span><?= $valueal['AlergiaMedicamento'] ?></span></label>
                        <?php } ?>
                      <?php } ?>
                    </div>
                  </div>
                  <br>
                  <?php break; ?>

                <?php
                default: ?>
                  # code...
              <?php break;
              } ?>

            <?php  } ?>
            <button>
              GENERAR

              <i class="fas fa-qrcode"></i>
            </button>
        </form>
      </div>
      <div class="screen__background">
        <span class="screen__background__shape screen__background__shapec"></span>
        <span class="screen__background__shape screen__background__shapeb"></span>
        <span class="screen__background__shape screen__background__shapea"></span>
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

<!-- copyright -->
<div class="copyright">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-12">
        <p>Copyrights &copy; 2019 - <a href="https://imransdesign.com/">SECØDE_QR</a>, Salud e información al instante.</p>
      </div>
      <div class="col-lg-6 text-right col-md-12">
        <div class="social-icons">
          <ul>
            <li><a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
            <li><a href="#" target="_blank"><i class="fab fa-twitter"></i></a></li>
            <li><a href="#" target="_blank"><i class="fab fa-instagram"></i></a></li>
            <li><a href="#" target="_blank"><i class="fab fa-whatsapp"></i></a></li>
            <li><a href="#" target="_blank"><i class="fab fa-github"></i></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end copyright -->
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

</body>

</html>