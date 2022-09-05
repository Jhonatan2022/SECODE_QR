<?php


session_start();
require_once '../models/database/database.php';

if (!isset($_SESSION["user_id"])) {
	header('Location: index.php');
} else {

	$records = $connection->prepare('SELECT Ndocumento,Img_perfil, TipoImg FROM usuario WHERE Ndocumento = :id');
	$records->bindParam(':id', $_SESSION['user_id']);

	if ($records->execute()) {
		$resultsUser = $records->fetch(PDO::FETCH_ASSOC);
	} else {
		$message = array(' Error', 'Ocurrio un error en la consulta datos user. intente de nuevo.', 'error');
	}

	$records = $connection->prepare('SELECT Atributos,Titulo,RutaArchivo,Duracion,Descripcion,Id_codigo FROM codigo_qr WHERE Ndocumento = :id');
	$records->bindParam(':id', $_SESSION['user_id']);
	
	
	if ($records->execute()) {
		$results = $records->fetchAll(PDO::FETCH_ASSOC);
		//$codes = $results;
	} else {
		$message = array(' Error', 'Ocurrio un error en la consulta codigos user. intente de nuevo.', 'error');
	}
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
	<title>Dashboard</title>
	<?php
	include('./templates/header.php');
	include('./templates/sweetalerts2.php');
	?>
	<link rel="stylesheet" href="./assets/css/dashborad.css">
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
		<main class="container">
			<!-- product section -->
			<div class="product-section mt-150 mb-150 pt-4">
				<div class="container pt-4 mb-5 center">
					<h1>
						Mis codigos QR
					</h1>
				</div>
				<div class="container">


	<?foreach ($results as $code) { ?>



				<div class="roww ">
					<div class="col-lg-4 col-md-6 text-center">
						<div class="single-product-item">
							<div class="product-image">
								<a href="<?php echo $code['RutaArchivo'] ?>">
								<img src="<?php echo 'https://quickchart.io/qr?text='.$code['RutaArchivo'].$code['Atributos'] ?>" alt=""></a>
							</div>
							<h3><?php echo $code['Titulo'] ?></h3>

							<p class="product-price"><span><?php // echo $code['description'] ?></span> </p>

							<p class="product-price"><span><?php  echo 'Fecha: '.$code['Duracion'] ?></span> </p>
							<a  class="cart-btn" id="OptionsCodeQr"><i class="fas fa-pen"></i> opciones</a>
						</div>
					</div>
				</div>


				<div class="cont-optionsCode" id='cont-optionsCode'>
	<div class="divcont">
	<div class="icon-close">
	<i>X</i>
	</div>
	<h3>Codigo Qr opciones</h3>
	<form action="" method="post">
	<div class="subcont-optionsCode">
		<label for="Titulo-code">Titulo</label><br>
		<input type="text" id='Titulo-code' value="<?php echo $code['Titulo'] ?>">
		<br>
		<label for="FileLinkPath"> Ruta del archivo</label>
		<a id="FileLinkPath" href='<?php echo $code['RutaArchivo'] ?>' target="BLANK"><?php echo $code['RutaArchivo'] ?> </a>
		
		<br>
		<label >Fecha: <?php  echo $code['Duracion'] ?></label>
			<details>
				<summary>
				Vista Previa
				</summary>
				
				<iframe src="<?php echo $code['RutaArchivo']?>" frameborder="0" width="100%" height="300px"></iframe>
				
			</details>

	<label for="Description-code">Descripcion</label><br>
	<textarea type="text" id='Description-code' value=""><?php echo $code['Descripcion'] ?></textarea>
	<label for="UpdateDataForm">Other</label><br>
	<a href="./clinico.php?idFormEdit=<?php echo $code['Id_codigo'] ?>" type="button" class="button btn-info" id='UpdateDataForm' value="UpdateDataForm">Actualizar formulario <i class="fas fa-pen"> </i></a>
	</div>

	<input class="button bg-succes fas fa-writte" type='submit' value="Actualizar">
	<input class="button btn-danger fas fa-trash" type="submit" value="Eliminar">
	

	</form>
	</div>
	
	
</div>

	<?   }; ?>



				</div>
			</div>
			<!-- end product section -->

			<div class="cont-button">
					
			<a href="./formulario.php" class="link-button-new">
					Nuevo  <i class="fas fa-plus"></i>
			</a>
			</div>

		</main>

		<?php

		include('./templates/footerWebUser.php')
		?>

	</div>
	<script src="./assets/js/dashboard.js"></script>
</body>

</html>