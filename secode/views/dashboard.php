<?php


session_start();
require_once '../models/database/database.php';

if (!isset($_SESSION["user_id"])) {
	header('Location: index.php');
} else {

	$records = $connection->prepare('SELECT Ndocumento,Img_perfil, TipoImg FROM usuario WHERE Ndocumento = :id');
	$records->bindParam(':id', $_SESSION['user_id']);
	if ($records->execute()) {
		$results = $records->fetch(PDO::FETCH_ASSOC);
	} else {
		$message = array(' Error', 'Ocurrio un error en la consulta datos user. intente de nuevo.', 'error');
	}
	$records = $connection->prepare('SELECT Code_url,Titulo  FROM codigo_qr WHERE Ndocumento = :id');
	$records->bindParam(':id', $_SESSION['user_id']);
	if ($records->execute()) {
		$results = $records->fetch(PDO::FETCH_ASSOC);
		$codes = $results;
	} else {
		$message = array(' Error', 'Ocurrio un error en la consulta codigos user. intente de nuevo.', 'error');
	}
}




//apis de generacion del qr

'https://quickchart.io/qr?text=jkdhkfjhdskfjhsdkfjhsdkjfhsdlkfjhsdkfjhsdklfjhsdkjfhsdkfjhsd%27s%20my%20text&centerImageUrl=https://raw.githubusercontent.com/luis-fer993/Pineapple-editor/master/img-pineappple.png&dark=a06800&light=f52fff&size=300&ecLevel=H&centerImageWidth=30&centerImageHeight=30';


?>


<!DOCTYPE html>
<html lang="en">

<head>
	<title>dashboard</title>
	<?php
	include('./templates/header.php');
	include('./templates/sweetalerts2.php');
	?>
</head>

<body>

	<?php if (!empty($message)) {
	?>

		<script>
			Swal.fire(
				'<?php echo $message[0]; ?>',
				'<?php echo $message[1]; ?>',
				'<?php echo $message[2]; ?>')
		</script>
	<?php };
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
	<div class=container">

		<header>
			<?php
			include('./templates/navBar.php');
			?>

		</header>
		<main class="container">.,.,
			<!-- product section -->
			<div class="product-section mt-150 mb-150 pt-4">
				<div class="container pt-4 mb-5 center">
					<h1>
						Mis codigos QR
					</h1>
				</div>
				<div class="container">


					<?
					foreach ($codes as $results) {
						//for ($codes; $codes <= count($results);$codes++){ 

					?>



						<div class="roww">
							<div class="col-lg-4 col-md-6 text-center">
								<div class="single-product-item">
									<div class="product-image">
										<a href="single-product.html"><img src="<?php echo $codes['Code_url'] ?>" alt=""></a>
									</div>
									<h3><?php echo $codes['Titulo'] ?></h3>
									<p class="product-price"><span><?php // echo $code['description'] 
																	?></span> </p>
									<a href="cart.html" class="cart-btn"><i class="fas fa-pen"></i> opciones</a>
								</div>
							</div>
						</div>

					<?   }; ?>



				</div>
			</div>
			<!-- end product section -->

		</main>

		<?php

		include('./templates/footerWebUser.php')
		?>

	</div>
</body>

</html>