<?php
session_start();

//importamos DB
require_once('../models/database/database.php');
require_once '../models/user.php';

if(! isset($_SESSION['user_id'])){
  $message = array(' Advertencia', 'Antes de ingresar datos debe iniciar sesión', 'warning');
 
}else{
  $user = getUser($_SESSION['user_id'] );
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
<html>
  <head>
    <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Datos Clinicos</title>
    <!-- favicon -->
	<link rel="shortcut icon" type="image/png" href="./assets/img/logo.png">
	<!-- google font -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" href="assets/css/style.css">
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
  <link rel="stylesheet" href="./assets/css/responsiveAll.css">


  <?php
  include('./templates/sweetalerts2.php');
  ?>

  </head>
  <body>

  <?php if (!empty($message)) :
  ?>

<script>
    Swal.fire(
      '<?php  echo $message[0];?>',
      '<?php  echo $message[1];?>',
      '<?php  echo $message[2];?>')
    </script> 
  <?php endif; 
  ?>


<?php if (isset($id_code) && $statusForm == 22) : ?>
  

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

  <!-- header-section -->
<?php
include('./templates/navBar.php');
  ?>

  <!-- end header section -->

<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 offset-lg-2 text-center">
        <div class="breadcrumb-text">
          <p>SECØDE_QR</p>
          <h1>Datos Clinicos</h1>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end breadcrumb section -->
<br><br><br>
    <!-- Formulario -->
    <div class="testbox">
    <form action="../controller/pdf/PdfGeneratorForm.php" method="POST" novalidate>
    <div class="item">
        <p>Titulo del formulario</p>
        <input type="text" name="TituloForm"/>
      </div>
      <div class="item">
        <p>Nombre completo</p>
        <input type="text" name="UserName"/>
      </div>
      <div class="item">
        <p>Fecha de nacimiento</p>
        <input type="date" name="UserDateBorn"  required/>
      </div>
      <h5>1. Datos generales</h5>
      <div class="item">
        <p>Dirección<span class="required">*</span></p>
        <input type="text" name="UserLocationDir" required/>
      </div>
      <div class="item">
        <p>EPS<span class="required">*</span></p>
        <input type="text" name="UserEps" required/>
        <p>Residencia<span class="required">*</span></p>
        <div class="city-item">
          <input type="text" name="UserCity" placeholder="Ciudad" required/>
          <select required>
            <option value="None">Departamento</option>
            <option value="Amazonas">Amazonas</option>
            <option value="Arauca">Arauca</option>
            <option value="Antioquia">Antioquia</option>
            <option value="Atlántico">Atlántico</option>
            <option value="Bolívar">Bolívar</option>
            <option value="Boyacá">Boyacá</option>
            <option value="Caldas">Caldas</option>
            <option value="Caquetá">Caquetá</option>
            <option value="Casanare">Casanare</option>
            <option value="Cauca">Cauca</option>
            <option value="Cesar">Cesar</option>
            <option value="Chocó">Chocó</option>
            <option value="Córdoba">Córdoba</option>
            <option value="Cundinamarca">Cundinamarca</option>
            <option value="Guainía">Guainía</option>
            <option value="Guaviare">Guaviare</option>
            <option value="Huila">Huila</option>
            <option value="La guajira">La guajira</option>
            <option value="Magdalena">Magdalena</option>
            <option value="Meta">Meta</option>
            <option value="Nariño">Nariño</option>
            <option value="Norte de santander">Norte de santander</option>
            <option value="Putumayo">Putumayo</option>
            <option value="Quindío">Quindío</option>
            <option value="Risaralda">Risaralda</option>
            <option value="San Andrés y Providencia">San Andrés y Providencia</option>
            <option value="Santander">Santander</option>
            <option value="Sucre">Sucre</option>
            <option value="Tolima">Tolima</option>
            <option value="Valle del cauca">Valle del cauca</option>
            <option value="Vaupés">Vaupés</option>
            <option value="Vichada">Vichada</option>
          </select>
        </div>
      </div>
      <div class="item">
        <p>Phone<span class="required">*</span></p>
        <input type="text" name="UserPhone" required/>
      </div>
      <div class="item">
        <p>Email<span class="required">*</span></p>
        <input type="text" name="UserEmail" required/>
      </div>
      <div class="question">
        <p>Genero<span class="required">*</span></p>
        <div class="question-answer">
          <input type="radio" value="none" id="radio_9" name="UserMale" required/>
          <label for="radio_9" class="radio"><span>Masculino</span></label>
          <input type="radio" value="none" id="radio_10" name="UserFemale" required/>
          <label for="radio_10" class="radio"><span>Femenino</span></label>
          <input type="radio" value="none" id="radio_11" name="UserOther" required/>
          <label for="radio_11" class="radio"><span>Otro</span></label>
        </div>
      </div>
      <h5>2. Socio economico</h5>
      <div class="question">
        <p>Estrato<span class="required">*</span></p>
        <div class="question-answer">
          <input type="radio" value="none" id="radio_1" name="es" required/>
          <label for="radio_1" class="radio"><span>1</span></label>
          <input type="radio" value="none" id="radio_2" name="es" required/>
          <label for="radio_2" class="radio"><span>2</span></label>
          <input type="radio" value="none" id="radio_3" name="es" required/>
          <label for="radio_3" class="radio"><span>3</span></label>
          <input type="radio" value="none" id="radio_4" name="es" required/>
          <label for="radio_4" class="radio"><span>4</span></label>
          <input type="radio" value="none" id="radio_5" name="es" required/>
          <label for="radio_5" class="radio"><span>5</span></label>
          <input type="radio" value="none" id="radio_6" name="es" required/>
          <label for="radio_6" class="radio"><span>6</span></label>
        </div>
      </div>
      <br>
      <div class="question">
        <p>Tipo de afiliacion con la EPS <span class="required">*</span></p>
        <div class="question-answer">
          <input type="radio" value="none" id="radio_7" name="co-investigator" required/>
          <label for="radio_7" class="radio"><span>beneficiario</span></label>
          <input type="radio" value="none" id="radio_8" name="co-investigator" required/>
          <label for="radio_8" class="radio"><span>cotizante</span></label>
        </div>
      </div>
      <br>
      <div class="question">
        <p>¿Cuenta con algun subsido del gobierno?<span class="required"></span></p>
        <div class="question-answer">
          <input type="radio" value="none" id="radio_12" name="sub" required/>
          <label for="radio_12" class="radio"><span>Si</span></label>
          <input type="radio" value="none" id="radio_13" name="sub" required/>
          <label for="radio_13" class="radio"><span>No</span></label>
        </div>
      </div>
      <h5>1.Datos clinicos:</h5>
      <div class="question">
        <p>RH<span class="required"></span></p>
        <div class="question-answer">
          <input type="radio" value="none" id="radio_14" name="RH" required/>
          <label for="radio_14" class="radio"><span>+</span></label>
          <input type="radio" value="none" id="radio_15" name="RH" required/>
          <label for="radio_15" class="radio"><span>-</span></label>
        </div>
      </div>
      <br>
      <div class="question">
        <p>Tipo de sangre<span class="required"></span></p>
        <div class="question-answer">
          <input type="radio" value="none" id="radio_16" name="SANGRE" required/>
          <label for="radio_16" class="radio"><span>A</span></label>
          <input type="radio" value="none" id="radio_17" name="SANGRE" required/>
          <label for="radio_17" class="radio"><span>B</span></label>
          <input type="radio" value="none" id="radio_18" name="SANGRE" required/>
          <label for="radio_18" class="radio"><span>AB</span></label>
          <input type="radio" value="none" id="radio_19" name="SANGRE" required/>
          <label for="radio_19" class="radio"><span>0</span></label>
        </div>
      </div>
      <br>
      <div class="question">
        <p>¿Cuenta con alguna de las siguientes condiciones?:<span class="required">*</span></p>
        <div class="question-answer checkbox-item">
          <div>
            <input type="checkbox" value="none" id="check_1" name="checklist" required/>
            <label for="check_1" class="check"><span>Presion alta</span></label>
          </div>
          <div>
            <input type="checkbox" value="none" id="check_2" name="checklist" required/>
            <label for="check_2" class="check"><span>Diabetes</span></label>
          </div>
          <div>
            <input type="checkbox" value="none" id="check_3" name="checklist" required/>
            <label for="check_3" class="check"><span>afecciones cardiacas</span></label>
          </div>
          <div>
            <input type="checkbox" value="none" id="check_4" name="checklist" required/>
            <label for="check_4" class="check"><span>Covid-19</span></label>
          </div>
          <div>
            <input type="checkbox" value="none" id="check_5" name="checklist" required/>
            <label for="check_5" class="check"><span>Enfermedades respiratorias</span></label>
          </div>
          <div class="item">
            <p>Otro<span class="required"></span></p>
            <input type="text" name="name" required placeholder="Especificar condición"/>
          </div>
          <div class="question">
            <p>¿Es alergico algun medicamento?<span class="required"></span></p>
            <div class="question-answer">
              <input type="radio" value="none" id="radio_20" name="aler" required/>
              <label for="radio_20" class="radio"><span>Si</span></label>
              <input type="radio" value="none" id="radio_21" name="aler" required/>
              <label for="radio_21" class="radio"><span>No</span></label>
            </div>
          </div>
         </div>
        </div>
        <br />
        <div class="btn-block">

          <?php  if(!isset($_SESSION['user_id'])){ ?>
            <a href="./iniciar.php"><button type="button" >INICIA SESION </button></a>            
         <?php  }  else { ?>
          <button type="submit" id="BtnSendFormClinic">
         Generar codigo
          </button>
          
          <?php  }?>
        </div>
    </form>
    </div>
    <br><br><br>
    <!-- End formulario -->

  <!-- footer -->
	<?php
    include('./templates/footer.php');
  ?>
	<!-- end footer -->
	
	<!-- copyright -->
	<?php
    include('./templates/footer_copyrights.php');
  ?>
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
  <script src="./assets/js/dashboard.js"></script>
  </body>
</html>