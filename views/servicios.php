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
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Servicios SECODE_QR</title>

	<!-- favicon -->
	<link rel="shortcut icon" type="image/png" href="./assets/img/logo.png">
<?php include('./templates/header.php');
	include('./templates/sweetalerts2.php') ?>
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
		<?php foreach($planinfo as $plan){?>
			<div class="packages">
			<h4 class="h"><?=$plan['TipoSuscripcion']?></h4>
			<hr>
			<h4 class="text2">$ <?=$plan['precio']?> COP</h4>
			<ul class="list">
				<hr>
				<li class="included"><i class="fas fa-check"></i><?php if ($plan['tiempo']==0){echo 'Tiempo indefinido ';}else{echo $plan['tiempo'].' Meses ';}?></li>
				<li class="included"><i class="fas fa-check"></i><?=$plan['cantidad_qr']?> QR en la nube</li>
				<li class="<?php if($plan['Editar']=='SI'){echo "included"; }else{ echo "excluded";} ?>"><i class="fas <?php if($plan['Editar']=='SI'){echo "fas fa-check"; }else{ echo "fas fa-close";} ?>"></i><?=$plan['Editar']?> hay opción actualizar código</li>
				<li class="<?php if($plan['citas']=='SI'){echo "included"; }else{ echo "excluded";} ?>"><i class="fas <?php if($plan['citas']=='SI'){echo "fas fa-check"; }else{ echo "fas fa-close";} ?>"></i>
				<?=$plan['citas']?> hay opcion de reenvio a pagina de citas Eps</li>
				<li class="<?php if($plan['EditarQR']=='SI'){echo "included"; }else{ echo "excluded";} ?>"><i class="fas <?php if($plan['EditarQR']=='SI'){echo "fas fa-check"; }else{ echo "fas fa-close";} ?>"></i>
				<?=$plan['EditarQR']?> hay opcion de personalizar Qr</li>
				<li class="<?php if($plan['CompartirPerfil']=='SI'){echo "included"; }else{ echo "excluded";} ?>"><i class="fas <?php if($plan['EditarQR']=='SI'){echo "fas fa-check"; }else{ echo "fas fa-close";} ?>"></i>
				<?=$plan['CompartirPerfil']?> hay opcion de compartir mi perfil.</li>
				<li class="<?php if($plan['RellenarFormulario']=='SI'){echo "included"; }else{ echo "excluded";} ?>"><i class="fas <?php if($plan['EditarQR']=='SI'){echo "fas fa-check"; }else{ echo "fas fa-close";} ?>"></i>
				<?=$plan['RellenarFormulario']?> hay opcion de autorellenar formularios</li>
				<li class="<?php if($plan['EnviarMensaje']=='SI'){echo "included"; }else{ echo "excluded";} ?>"><i class="fas <?php if($plan['EditarQR']=='SI'){echo "fas fa-check"; }else{ echo "fas fa-close";} ?>"></i>
				<?=$plan['EnviarMensaje']?> hay opcion de enviar mensajes a usuario (SOLO CUENTAS VERIFICADAS)</li>
			</ul>
			<a href="<?=$plan['nombre_archivo'];?>" class="button 
			<?php
			if($plan['IDTipoSuscripcion']==1){echo 'button1';} 
			elseif($plan['IDTipoSuscripcion']==2){echo 'button1';}
			elseif($plan['IDTipoSuscripcion']==3){echo 'button2';}
			elseif($plan['IDTipoSuscripcion']==4){echo 'button3';}?>"><?php if($plan['IDTipoSuscripcion']==1){echo 'Iniciar';}else{echo 'Obtener';}?></a>
		</div>
		<?php }?>
	</div>
	</div>
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

<?php if (isset($_GET['error'])) { ?>
	<script>
		Swal.fire({
			icon: 'error',
			title: 'Oops...',
			text: 'Error al realizar la compra',
		})
	</script>
<?php } ?>
</body>
</html>