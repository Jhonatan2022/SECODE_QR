<<<<<<< HEAD
=======
<?php

require_once '../models/database/database.php';

session_start();

require_once '../models/user.php';
$user = getUser($_SESSION['user_id'] );
?>


>>>>>>> withpays
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Servicio Básico</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
	<link rel="stylesheet" href="assets/css/service.css" />

  <!-- favicon -->
	<link rel="shortcut icon" type="image/png" href="./assets/img/logo.png">
	<!-- google font -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
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
	
	<!-- header -->
<<<<<<< HEAD
	<div class="top-header-area" id="sticker">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-sm-12 text-center">
					<div class="main-menu-wrap">
						<!-- logo -->
						<div class="site-logo">
							<a href="index.php">
								<img src="assets/img/logo.png" alt="">	
							</a>
						</div>
						<!-- logo -->	

						<!-- menu start -->
						<nav class="main-menu">
							<ul>
								<li><a href="nosotros.html">Quienes Somos</a></li>	
								<li><a href="contact.html">Contáctanos</a></li>
								<li><a href="#">Solicitar Código</a>
								<ul class="sub-menu">
									<li><a href="clinico.html">Datos Clinicos</a>
									</li>
								</ul>
								<li class="login-box"><a href="#">
									<span></span>
									<span></span>
									<span></span>
									<span></span> SECODE_QR PLUS </a></li>
							</ul>
						</nav>	
						<div class="mobile-menu"></div>
						<!-- menu end -->
					</div>
				</div>
			</div>
		</div>
	</div>
=======
	 <!--Portada de usuario-->
	 <?php include('./templates/navBar.php'); ?>
>>>>>>> withpays
	<!-- end header -->

	<!-- breadcrumb-section -->
	<div class="breadcrumb-section breadcrumb-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="breadcrumb-text">
						<p>SECØDE_QR</p>
						<h1>Servicio Básico</h1>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end breadcrumb section -->

<<<<<<< HEAD
    <div class="package-container">
      <div class="packages">
        <hr>
        <h4 class="text2">$9.900</h4>
=======
	<div class="package-container">
      <div class="packages">
>>>>>>> withpays
        <ul class="list">
          <hr>
          <li class="included"><i class="fas fa-check"></i>5 QR en la nube</li>
          <li class="included"><i class="fas fa-check"></i>Opción actualizar código</li>
<<<<<<< HEAD
          <li class="excluded"><i class="fas fa-close"></i></li>
          <li class="excluded"><i class="fas fa-close"></i></li>
        </ul>
        <a href="pagos.php?plan=basico" class="button button12">Comprar Ahora</a>
		<a href="servicios.html" class="button button13">Cancelar</a>
=======
          <li class="included"><i class="fas fa-check"></i></li>
          <li class="included"><i class="fas fa-check"></i></li>
        </ul>
      </div>
	  <div class="packages">
        <h4 class="h">Básico</h4>
        <hr class="hhh">
        <h4 class="text2">9.900</h4>
        <a href="#" class="button button12">Comprar Ahora</a>
		<a href="pagos.php?plan=basico" class="button button13">Cancelar</a>
>>>>>>> withpays
      </div>
    </div>

  <!-- copyright -->
	<div class="copyright">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-12">
					<p>Copyrights &copy; 2022 - <a href="https://imransdesign.com/">SECØDE_QR</a>, Salud e información al instante.</p>
				</div>
				<div class="col-lg-6 text-right col-md-12">
					<div class="social-icons">
						<ul>
							<li><a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
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



</body>
</html>
