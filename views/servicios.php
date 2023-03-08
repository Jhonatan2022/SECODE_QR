<?php

session_start();
require_once '../models/database/database.php';
require_once '../models/user.php';
if(isset($_SESSION['user_id'])){
	$user = getUser($_SESSION['user_id'] );
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Servicios SECODE_QR</title>

	<!-- favicon -->
	<link rel="shortcut icon" type="image/png" href="./assets/img/logo.png">
<?php include('./templates/header.php');?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
	<link rel="stylesheet" href="assets/css/service.css" />
</head>

<body>
	<section class="seccion-perfil-usuario">
        <div class="perfil-usuario-header">
            <div class="perfil-usuario-portada">
            </div>
        </div>
    </section>
	
	<?php
		include('./templates/navBar.php');
	?>
	<!-- breadcrumb-section -->
	<div class="breadcrumb-section breadcrumb-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="breadcrumb-text">
						<p>SECØDE_QR</p>
						<h1>Servicios</h1>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end breadcrumb section -->
	<div class="package-container">
		<div class="packages">
			<h4 class="h">Básico</h4>
			<hr>
			<h4 class="text2">$9.900</h4>
			<ul class="list">
				<hr>
				<li class="included"><i class="fas fa-check"></i>5 QR en la nube</li>
				<li class="included"><i class="fas fa-check"></i>Opción actualizar código</li>
				<li class="excluded"><i class="fas fa-close"></i></li>
				<li class="excluded"><i class="fas fa-close"></i></li>
			</ul>
			<a href="basico.php" class="button button1">Obtener</a>
		</div>
		<div class="packages">
			<h4 class="hh">Estandar</h4>
			<hr>
			<h4 class="text2">$26.700</h4>
			<ul class="list">
				<hr>
				<li class="included"><i class="fas fa-check"></i>8 QR en la nube</li>
				<li class="included"><i class="fas fa-check"></i>Opción actualizar código</li>
				<li class="included"><i class="fas fa-check"></i></li>
				<li class="excluded"><i class="fas fa-close"></i></li>
			</ul>
			<a href="estandar.php" class="button button2">Obtener</a>
		</div>
		<div class="packages">
			<h4 class="hhh">Premium</h4>
			<hr class="hhh">
			<h4 class="text2">$51.000</h4>
			<ul class="list">
				<hr>
				<li class="included"><i class="fas fa-check"></i>10 QR en la nube</li>
				<li class="included"><i class="fas fa-check"></i>Opción actualizar código</li>
				<li class="included"><i class="fas fa-check"></i></li>
				<li class="included"><i class="fas fa-check"></i></li>
			</ul>
			<a href="premium.php" class="button button3">Obtener </a>
		</div>
	</div>
	</div>
	<br>
	<br>
	<br>
	<br>

<?php include('./templates/footer_copyrights.php');?>

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



</body>

</html>