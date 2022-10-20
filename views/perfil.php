<?php

session_start();

if(!isset($_SESSION['user_id'])){
header('Location: ./index.php');
}

require_once '../models/database/database.php';
require_once '../models/user.php';

$user = getUser($_SESSION['user_id']);


?>


<!DOCTYPE html>
<html lang="es">

<head>

    <title>Perfil de usuario</title>
    <link rel="stylesheet" href="./assets/css/perfil.css">
 <?php include('./templates/header.php');?>

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

    <?php include('./templates/navBar.php'); ?>

    <section class="seccion-perfil-usuario">
        <div class="perfil-usuario-header">
            <div class="perfil-usuario-portada">
                <div class="perfil-usuario-avatar">
                    
                    <img src="<?php echo $user['Img_perfil'] ?>"
                        alt="img-avatar">
                    <button type="button" class="boton-avatar">
                        <i class="fas fa-image"></i>
                    </button>
                    <script>
                        let button=document.querySelector('.boton-avatar')
                        button.addEventListener('onclick',()=>{
                            
                        })
                    </script>
                </div>
            </div>
        </div>
        <div class="perfil-usuario-body">
            <div class="perfil-usuario-bio">
                <h1></h1>
                <h3 class="titulo"><?php echo $user['Nombre'] ?> <a href="" class="boton-edit"><i class="fas fa-pencil-alt"></i></a></h3>
                <p class="texto">
                </p>
            </div>
            <div class="perfil-usuario-footer">
                <ul class="lista-datos">
                    <li><i class="icono fas fa-map-signs"></i> Direccion: <strong><?php echo $user['Direccion'] ?></strong> </li>
                    <li><i class="icono fas fa-phone"></i> Telefono: <strong>
                    <?php echo $user['Telefono'] ?>
                    </strong> </li>
                    <li><i class="icono fas fa-user"></i> Genero <strong>
                    <?php echo $user['Genero'] ?>
                    </strong></li>
                    <li><i class="icono fas fa-building"></i> Cargo</li>
                </ul>
                <ul class="lista-datos">
                    <li><i class="icono fas fa-map-marker-alt"></i> Ubicacion.</li  >
                    <li><i class="icono fas fa-calendar-alt"></i> Fecha nacimiento: <strong>
                    <?php echo $user['FechaNacimiento'] ?>
                    </strong>  </li>
                    <li><i class="icono fas fa-user-check"></i> Registro.</li>
                    <li><i class="icono fas fa-share-alt"></i> Redes sociales.</li>
                </ul>
            </div>
            <div class="redes-sociales">
                <a href="" class="boton-redes facebook fab fa-facebook-f"><i class="icon-facebook"></i></a>
                <a href="" class="boton-redes twitter fab fa-twitter"><i class="icon-twitter"></i></a>
                <a href="" class="boton-redes instagram fab fa-instagram"><i class="icon-instagram"></i></a>
                
            </div>
        </div>
        <div>
            <br>
        </div>
    </section>
    <div>
        <br>
        <br>
    </div>
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