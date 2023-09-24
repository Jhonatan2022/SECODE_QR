<?php
session_start();
require_once '../models/database/database.php';
require_once '../models/user.php';
if (isset($_SESSION['user_id'])) {
	$user = getUser($_SESSION['user_id']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- title -->
	<title>Contáctanos</title>
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
	<!--PreLoader-->
	<div class="loader">
		<div class="inner"></div>
		<div class="inner"></div>
		<div class="inner"></div>
		<div class="inner"></div>
		<div class="inner"></div>
	</div>
	<!--PreLoader Ends-->
	<?php include_once('./templates/navBar.php'); ?>
	<!-- breadcrumb-section -->
	<div class="breadcrumb-section breadcrumb-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="breadcrumb-text">
						<p>SECØDE_QR</p>
						<h1>Contáctanos</h1>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end breadcrumb section -->

	<!-- contact form -->
	<div class="feature-bg1">
		<div class="contact-from-section mt-150 mb-150">
			<div class="container">
				<div class="row">
					<div class="col-lg-8 mb-5 mb-lg-0">
						<div class="form-title">
							<h2>¿ Tienes alguna pregunta ?</h2>
							<p>Danos a conocer tus dudas u opiniones sobre nuestra web informática</p>
						</div>
						<div id="form_status"></div>
						<div class="contact-form">
							<form type="POST" id="SECØDE_QR contactanos" onSubmit="return_valid_datas( this );">
								<p>
									<input type="text" placeholder="Nombre" name="name" id="name">
								</p>
								<p>
									<input type="tel" placeholder="Teléfono" name="phone" id="phone">
									<input type="email" placeholder="Email" name="email" id="email">
								</p>
								<p><textarea name="message" id="message" cols="30" rows="10" placeholder="Mensaje"></textarea></p>
								<input type="hidden" name="token" value="FsWga4&@f6aw" />
								<p><input type="submit" value="Enviar"></p>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
	</div>
	<!-- end contact form -->
	<!-- google map section -->
	<div class="embed-responsive embed-responsive-21by9">
		<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d994.3846724145659!2d-74.11465906759243!3d4.496402420706137!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses!2sco!4v1647640013922!5m2!1ses!2sco" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
	</div>
	<?php include_once('./templates/footer.php'); ?>
	<?php include_once('./templates/footer_copyrights.php'); ?>
</body>
</html>