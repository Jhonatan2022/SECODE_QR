<?php 
session_start();
require_once '../models/database/database.php';
require_once '../models/user.php';

if(isset($_SESSION['user_id'])){
$user = getUser($_SESSION['user_id']);

$plan = $_GET['plan'];
if ($plan == 22){$plan = 2;
}
elseif($plan == 56){$plan = 4;
}
elseif($plan == 99){$plan = 3;
}else{
	header('Location: ./iniciar.php');
}

$query1='SELECT tps.precio, tps.TipoSuscripcion FROM TipoSuscripcion AS tps WHERE tps.IDTipoSuscripcion = :plan';
$query = $connection->prepare($query1);
$query->bindParam(':plan', $plan);
$query->execute();
$precio = $query->fetch(PDO::FETCH_ASSOC);

//datos recibo
$idfactura = random_int(2142314324,8957349578);
//date now 
$date= date('Y-m-d');

$query1='INSERT INTO Suscripcion (IDSuscripcion,Ndocumento,FechaExpiracion, TipoSuscripcion, fecha_inicio, numero_recibo) 
VALUES (null, :ndoc, null, :tipsus, :fecha, :numr)';
$query = $connection->prepare($query1);
$query->bindParam(':ndoc', $_SESSION['user_id']);
$query->bindParam(':tipsus', $plan);
$query->bindParam(':fecha', $date);
$query->bindParam(':numr', $idfactura);
if($query->execute()){
	$pdf='../controller/pdf/pdfpago.php';
}else{
	$pdf='#';
}

}else{
	header('Location: ./iniciar.php');
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo de pago</title>
    <!-- LInk desde el panel de datos de Pypal, (SDK Javascript)-->
    <script src="https://www.paypal.com/sdk/js?client-id=AVhw-RveYQh4KiLBXWa8eXUIo0pAE3d0xrgq9VK9MHGvZ65eozHU62aKJYLGNqrqWXdT0gm-En9KYCX2&currency=USD"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">


	<link rel="stylesheet" href="assets/css/service.css" />
  <!-- favicon -->
	<link rel="shortcut icon" type="image/png" href="./assets/img/logo.png">
	<!-- google font -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
	<!-- fontawesome -->
	<link rel="stylesheet" href="./assets/css/all.min.css">
	<!-- bootstrap -->
	<link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.min.css">
	<!-- animate css -->
	<link rel="stylesheet" href="./assets/css/animate.css">
	<!-- mean menu css -->
	<link rel="stylesheet" href="./assets/css/meanmenu.min.css">
	<!-- main style -->
	<link rel="stylesheet" href="./assets/css/main.css">
	<!-- responsive -->
	<link rel="stylesheet" href="./assets/css/responsive.css">

    <link rel="stylesheet" href="./assets/css/Paypal.css" />
    
</head>
<body>
    <div class="container">
    <header>
    <div class="top-header-area" id="sticker">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-sm-12 text-center">
					<div class="main-menu-wrap">
						<!-- logo -->
						<div class="site-logo">
							<a href="index.php">
								<img src="../assets/img/logo.png" alt="">	
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
								<li class="login-box"><a href="servicios.html">
									<span></span>
									<span></span>
									<span></span>
									<span></span> SECODE_QR PLUS </a></li>
							</ul>
						</nav>	
						<div class="mobile-menu"></div>
                        <hr style="width:100%; color:black;">
						<!-- menu end -->
					</div>
				</div>
			</div>
		</div>
	</div>
    </header>
    </div>
<main>
<div class = "recibo">
<table style="margin:25vh auto; background-color:#F1F0F1;">
  <caption>Copyrights &copy; 2022 - SECØDE_QR, Salud e información al instante.</caption>
  <thead>
    <tr class="tabla1">
      <th scope="col"><img src="../views/assets/img/logo.png" alt="SECODE_QR" width="100px"></th>
      <th scope="col">SECODE_QR</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row" colspan="2">Localización: Bogotá D.C, Colombia</th>
      <th scope="row" colspan="2">Consumidor: <?= $user['Nombre']?>  </th>
      <th scope="row" colspan="2">Tipo de plan: <?=$precio['TipoSuscripcion']?></th>
    </tr>
    <tr>
      <th scope="row" colspan="2">Correo: team.secode@gmail.com</th>
      <th scope="row" colspan="2">Correo Usuario: <?= $user['Correo']?></th>
    </tr>
    <tr>
      <th scope="row" colspan="2">NIT: 12345678-1</th>
      <th scope="row" colspan="2">Fecha: <?= $date ?>  </th>
	  <th><button><a download="Recibo de pago" href="<?=$pdf?>" onclick="config()">Descargar</a></button></th>
    </tr>
  </tbody>
  <tfoot>
    <tr>
      <th scope="row" colspan="2">Recibo N°: <?= $idfactura ?></th>
      <th colspan="3">Monto a pagar: <?=' $'.$precio['precio']?>COP</th>
    </tr>
  </tfoot>
</table>
</div>

</main>
    
<footer style="position:fixed; bottom:0; width:100%;">
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
	<script src="./assets/js/jquery-1.11.3.min.js"></script>
	<!-- bootstrap -->
	<script src="./assets/bootstrap/js/bootstrap.min.js"></script>
	<!-- isotope -->
	<script src="./assets/js/jquery.isotope-3.0.6.min.js"></script>
	<!-- magnific popup -->
	<script src="./assets/js/jquery.magnific-popup.min.js"></script>
	<!-- mean menu -->
	<script src="./assets/js/jquery.meanmenu.min.js"></script>
	<!-- sticker js -->
	<script src="./assets/js/sticker.js"></script>
	<!-- main js -->
	<script src="./assets/js/main.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


	<script>
		function config(){
			setTimeout(() => {
				Swal.fire({
				position: 'center',
				icon: 'success',
				title: 'Descarga completada',
				text:'Esta factura será enviada a su correo electrónico',
				showConfirmButton: true,
				timer: 3500
				})
			}, 3500);
		};
	</script>
</footer>

</body>
</html>