<?php

session_start();
require_once '../models/database/database.php';
require_once '../models/user.php';

if (isset($_SESSION["user_id"])) {
	$user = getUser($_SESSION['user_id'] );
	//secure fingerprint session 
	$key = $user['Ndocumento'];
	if (isset($_SESSION['fingerprint']) && $_SESSION['fingerprint'] != md5($_SERVER['HTTP_USER_AGENT'] . $key . $_SERVER['REMOTE_ADDR'])) {       
		session_destroy();
		header('Location: iniciar.php');
		exit();     
	}
	verifyDateExpiration($user['Ndocumento']);

	if ($user['id'] == 10) {
		$newEps = true;
		$eps = Eps();
	}
}


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

	<?php
	include('./templates/sweetalerts2.php'); ?>
	


	<link rel="stylesheet" href="oo.css">
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
						<h1>Manuales de usuario y ayuda.</h1>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end breadcrumb section -->
	<div class="package-container">

<br>
<br>
<br>
	<section>
        <div class="container">
            <button class="accordion" ><strong>¿Como registrarse e iniciar sesión ?</strong></button>
            <div class="panel">
				<br>
				
				<iframe src="https://scribehow.com/embed/Como_registrarse_e_iniciar_sesion___r79u6PFnQUuJ-BLiBlesPQ" width="100%" height="640" allowfullscreen frameborder="0"></iframe>
				
			</div>
			<br>
		</div>
		<div class="container">
            <button class="accordion" ><strong>¿Como comprar un plan en la plataforma?</strong></button>
            <div class="panel">
				<br>
				
				<iframe src="https://scribehow.com/embed/Como_comprar_un_plan_en_la_plataforma__un__i7VJTSmMcmWdVINPUg" width="100%" height="640" allowfullscreen frameborder="0"></iframe>
				
			</div>
			<br>
		</div>
		<div class="container">
            <button class="accordion" ><strong>¿Como actualizar mis datos de perfil usuario?</strong></button>
            <div class="panel">
				<br>
				
				<iframe src="https://scribehow.com/embed/Como_actualizar_mis_datos_de_perfil_usuario__sXpVBh3USTmmXxah0aH0Wg" width="100%" height="640" allowfullscreen frameborder="0"></iframe>
				
			</div>
			<br>
		</div>
		<div class="container">
            <button class="accordion" ><strong>¿Como generar un código Qr aparir de mis datos clínicos?</strong></button>
            <div class="panel">
				<br>
				
				<iframe src="https://scribehow.com/embed/Como_generar_un_codigo_Qr_aparir_de_mis_datos_clinicos__NZfUkgG0R9GTn1fPKmj12Q" width="100%" height="640" allowfullscreen frameborder="0"></iframe>
				
			</div>
			<br>
		</div>
		<div class="container">
            <button class="accordion" ><strong>¿Como compartir tu perfil y tus códigos Qr con otros?</strong></button>
            <div class="panel">
				<br>
				
				<iframe src="https://scribehow.com/embed/Como_compartir_tu_perfil_y_tus_codigos_Qr_con_otros__Owgs6HUMTbWPb7gBrIyzDA" width="100%" height="640" allowfullscreen frameborder="0"></iframe>
				
			</div>
			<br>
		</div>
	</section>

	</div>
	<br>
	<br>
	<br>
	<br>
	<style>
        .accordion {
        background-color: #eee;
        color: #444;
        cursor: pointer;
        padding: 18px;
        width: 100%;
        border: none;
        text-align: left;
        outline: none;
        font-size: 15px;
        transition: 0.4s;
        }

        .active, .accordion:hover {
        background-color: #ccc;
        }

        .accordion:after {
        content: '\002B';
        color: #777;
        font-weight: bold;
        float: right;
        margin-left: 5px;
        }

        .active:after {
        content: "\2212";
        }

        .panel {
        padding: 0 18px;
        background-color: white;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.2s ease-out;
        }
        </style>
		<script>
			        var acc = document.getElementsByClassName("accordion");
        var i;

        for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.maxHeight) {
            panel.style.maxHeight = null;
            } else {
            panel.style.maxHeight = panel.scrollHeight + "px";
            } 
        });
        }
		</script>
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
