<?php
session_start();

//importamos DB
require_once('../models/database/database.php');

if(! isset($_SESSION['user_id'])){
  $message = array(' Advertencia', 'Antes de ingresar datos debe iniciar sesión', 'warning');
 
}else{

  if(isset($_GET['idFormEdit']) /*&& $infoPlan == 'PRO'*/){
    $id_code=$_GET['idFormEdit'];
    $isAnewForm=false;
  }else{
    $isAnewForm=true;
  }


//funtionalities advanced pro
if(! $isAnewForm){
  $param=$connection->prepare('SELECT us.Nombre, us.Direccion, us.FechaNacimiento, us.Genero, dta.RH,dta.TipoAfiliacion, dta.Subsidio, dta.Departamento, dta.Tipo_de_sangre, dta.Estrato, dta.EsAlergico 
  FROM usuario AS us 
  INNER JOIN datos_clinicos AS dta 
  ON dta.Id_codigo = :id_code and us.Ndocumento = :id_user ');
  $param->bindParam(':id_code',$id_code);
  $param->bindParam(':id_user',$_SESSION['user_id']);
  
  if($param->execute()){
    $results=$param->fetch(PDO::FETCH_ASSOC);
    echo 'ok'.$results['Nombre'];

  }else{
    $message= array(' Advertencia', 'Antes de ingresar datos debe iniciar sesión', 'warning');
  }

//Seting data strings

$nombreUser=$results['Nombre'];

}

  if (
    isset($_GET['GenerateError']) &&
    !empty($_GET['GenerateError'])
  ) {
    $statusForm = $_GET['GenerateError'];
    if ($statusForm == 1) {
      $message = array('Error', 'Hubo un error en el preoceso, intente nuevamente', 'error');
    } elseif ($statusForm == 22) {
      $message = array('Realizado correctamente', 'Ingrese a su dashboard y verifique sus codigos. En un momento sera redirigido.', 'success');
      $id_code=$_GET['Data'];
    }
  } 


}
require_once '../models/user.php';
$user = getUser($_SESSION['user_id'] );



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

</head>

<body>
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
        <form action="/">
          <div class="item">
            <p>Nombres</p>
            <input type="text" name="name" />
          </div>
          <div class="item">
            <p>Apellidos</p>
            <input type="text" name="name" />
          </div>
          <div class="item">
            <p>Fecha de nacimiento</p>
            <input type="date" name="bdate" required />
          </div>
          <h5>1. Datos generales</h5>
          <div class="item">
            <p>EPS<span class="required">*</span></p>
            <input type="text" name="name" required />
          </div>
          <div class="item">
            <p>Telefono de contacto<span class="required">*</span></p>
            <input type="text" name="name" required />
          </div>
          <div class="item">
            <p>Correo electronico<span></span></p>
            <input type="text" name="name" required />
          </div>
          <div class="question">
            <p>Genero<span></span></p>
            <div class="question-answer">
              <input type="radio" value="none" id="radio_9" name="G" required />
              <label for="radio_9" class="radio"><span>Masculino</span></label>
              <input type="radio" value="none" id="radio_10" name="G" required />
              <label for="radio_10" class="radio"><span>Femenino</span></label>
              <input type="radio" value="none" id="radio_11" name="G" required />
              <label for="radio_11" class="radio"><span>Otro</span></label>
            </div>
          </div>
          <h5>2. Socio economico</h5>
          <br>
          <div class="question">
            <p>Tipo de afiliacion con la EPS <span class="required">*</span></p>
            <div class="question-answer">
              <input type="radio" value="none" id="radio_7" name="co-investigator" required />
              <label for="radio_7" class="radio"><span>beneficiario</span></label>
              <input type="radio" value="none" id="radio_8" name="co-investigator" required />
              <label for="radio_8" class="radio"><span>cotizante</span></label>
            </div>
          </div>
          <br>
          <h5>1.Datos clinicos:</h5>
          <div class="question">
            <p>RH<span class="required"></span></p>
            <div class="question-answer">
              <input type="radio" value="none" id="radio_14" name="RH" required />
              <label for="radio_14" class="radio"><span>+</span></label>
              <input type="radio" value="none" id="radio_15" name="RH" required />
              <label for="radio_15" class="radio"><span>-</span></label>
            </div>
          </div>
          <br>
          <div class="question">
            <p>Tipo de sangre<span class="required"></span></p>
            <div class="question-answer">
              <input type="radio" value="none" id="radio_16" name="SANGRE" required />
              <label for="radio_16" class="radio"><span>A</span></label>
              <input type="radio" value="none" id="radio_17" name="SANGRE" required />
              <label for="radio_17" class="radio"><span>B</span></label>
              <input type="radio" value="none" id="radio_18" name="SANGRE" required />
              <label for="radio_18" class="radio"><span>AB</span></label>
              <input type="radio" value="none" id="radio_19" name="SANGRE" required />
              <label for="radio_19" class="radio"><span>O</span></label>
            </div>
          </div>
          <br>
          <div class="question">
            <p>¿Cuenta con alguna de las siguientes condiciones?:<span class="required">*</span></p>
            <div class="question-answer checkbox-item">
              <div>
                <input type="checkbox" value="none" id="check_1" name="checklist" required />
                <label for="check_1" class="check"><span>Presion alta</span></label>
              </div>
              <div>
                <input type="checkbox" value="none" id="check_2" name="checklist" required />
                <label for="check_2" class="check"><span>Diabetes</span></label>
              </div>
              <div>
                <input type="checkbox" value="none" id="check_3" name="checklist" required />
                <label for="check_3" class="check"><span>afecciones cardiacas</span></label>
              </div>
              <div>
                <input type="checkbox" value="none" id="check_4" name="checklist" required />
                <label for="check_4" class="check"><span>Covid-19</span></label>
              </div>
              <div>
                <input type="checkbox" value="none" id="check_5" name="checklist" required />
                <label for="check_5" class="check"><span>Enfermedades respiratorias</span></label>
              </div>
              <div class="item">
                <p>Otro<span class="required"></span></p>
                <input type="text" name="name" required placeholder="Especificar condición" />
              </div>
              <div class="question">
                <p>¿Es alergico algun medicamento?<span class="required"></span></p>
                <div class="question-answer">
                  <input type="radio" value="none" id="radio_20" name="aler" required />
                  <label for="radio_20" class="radio"><span>Si</span></label>
                  <input type="radio" value="none" id="radio_21" name="aler" required />
                  <label for="radio_21" class="radio"><span>No</span></label>
                </div>
              </div>
            </div>
          </div>
          <br />
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