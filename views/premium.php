<?php

session_start();
require_once '../models/database/database.php';
require_once '../models/user.php';
if(isset($_SESSION['user_id'])){
	$user = getUser($_SESSION['user_id'] );
}
$planinfo=getTipoSuscripcion();
?>


<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Servicio Premium</title>
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
	 <!--Portada de usuario-->
	 <?php include('./templates/navBar.php'); ?>
	<!-- end header -->

	<!-- breadcrumb-section -->
	<div class="breadcrumb-section breadcrumb-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="breadcrumb-text">
						<p>SECØDE_QR</p>
						<h1>Servicio Premium</h1>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end breadcrumb section -->

    <div class="package-container">
      <div class="packages">
        <ul class="list">
          <hr>
          <li class="included"><i class="fas fa-check"></i>5 QR en la nube</li>
          <li class="included"><i class="fas fa-check"></i>Opción actualizar código</li>
          <li class="included"><i class="fas fa-check"></i></li>
          <li class="included"><i class="fas fa-check"></i></li>
        </ul>
      </div>
	  <div class="packages">
        <h4 class="h">Premium</h4>
        <hr class="hhh">
        <h4 class="text2">$ <?=$planinfo[3]['precio'];?> COP</h4>
		<form action="pagos.php" method="post">
		<input type="hidden" name="plan" value="premium">
		<button type="submit" class="button button12" style="border:none;">
		Comprar Ahora
		</button>
		</form>
		<a href="servicios.php" class="button button13">Cancelar</a>
      </div>
    </div>

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
