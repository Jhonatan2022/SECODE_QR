<?php
session_start()

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- title -->
	<title>SECØDE_QR</title>
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


	<link rel="stylesheet" href="oo.css">
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

	<?php include 'templates/navBar.php'; ?>

	<!-- hero area -->
	<div class="hero-area hero-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 offset-lg-2 text-center">
					<div class="hero-text">
						<div class="hero-text-tablecell">
							<p class="subtitle">SECØDE_QR</p>
							<h1>


						<?php if(isset($_SESSION['user_id'])): ?>
							Ingresa para ver los Codigos QR
							<?php else: ?>
								Registrarse o Iniciar Sesión
								<?php endif ?>
							</h1>
							<div class="hero-btns">

							<?php if(isset($_SESSION['user_id'])): ?>
								<a href="dashboard.php" class="boxed-btn">Ver mis codigos Qr</a>
							<?php else: ?>
								<a href="iniciar.php" class="boxed-btn">Registrarse o iniciar sesión</a>
								<?php endif ?>

								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end hero area -->

	<!-- features list section -->
	<div class="list-section pt-80 pb-80">
		<div class="container">

			<div class="row">
				<div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
					<div class="list-box d-flex align-items-center">
						<div class="list-icon">
							<i class="fas fa-key"></i>
						</div>
						<div class="content">
							<h3>Seguridad</h3>
							<p>Manteniendo tu seguridad</p>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
					<div class="list-box d-flex align-items-center">
						<div class="list-icon">
							<i class="fas fa-clock"></i>
						</div>
						<div class="content">
							<h3>Disponibilidad 24/7</h3>
							<p>Disponible todo el día</p>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6">
					<div class="list-box d-flex justify-content-start align-items-center">
						<div class="list-icon">
							<i class="fas fa-rocket"></i>
						</div>
						<div class="content">
							<h3>Eficacia</h3>
							<p>Eficaz para tu comodidad</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end features list section -->

	<!-- product section -->
	<div class="product-section mt-150 mb-150">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="section-title">	
						<h3><span class="orange-text">QR</span> Disponible</h3>
						<p>Aquí puedes solicitar el QR que requiera en su momento</p>
					</div>
				</div>
			</div>
		
			<div class="roww">
				<div class="col-lg-4 col-md-6 text-center">
					<div class="single-product-item">
						<div class="product-image">
							<a href="single-product.html"><img src="./assets/img/qrfor.png" alt=""></a>
						</div>
						<h3>Solicitud de medicamentos</h3>
						<p class="product-price"><span>QR Para generar formulario con <br> solicitud de medicamentos</span> </p>
						<a href="formulario_medicamentos.html" class="cart-btn"><i class="fas fa-qrcode"></i> Solicitar Código</a>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 text-center">
					<div class="single-product-item">
						<div class="product-image">
							<a href="single-product.html"><img src="./assets/img/qrfor.png" alt=""></a>
						</div>
						<h3>Datos Clínicos</h3>
						<p class="product-price"><span>QR Para solicitar datos básicos <br> de la persona</span> </p>
						<a href="formulario_datos_clinicos.html" class="cart-btn"><i class="fas fa-qrcode"></i> Solicitar Código</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end product section -->

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
</body>
</html>
