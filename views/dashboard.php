<?php



session_start();
require_once '../models/database/database.php';
require_once '../models/user.php';
if (!isset($_SESSION["user_id"])) {
	header('Location: index.php');
}


function deleteQR($id, $path)
{global $connection;
	global $results;
	$query="SELECT qr.DatosClinicos FROM codigo_qr as qr WHERE qr.id_codigo= :id";
	$records = $connection->prepare($query);
	$records->bindParam(':id', $id);
	$records->execute();
	$resultsdta = $records->fetch(PDO::FETCH_ASSOC);

	$records = $connection->prepare('DELETE FROM codigo_qr WHERE Id_codigo = :id');
	$records->bindParam(':id', $id);
	if (!unlink('./pdf/' . $path)) {
		$message = array(' Error', 'Ocurrio un error al eliminar el codigo Qr. intente de nuevo.', 'error');
	} elseif ($records->execute()) {
		$message = array(' Exito', 'Codigo Qr eliminado correctamente.', 'success');
	} else {
		$message = array(' Error', 'Ocurrio un error al eliminar el codigo Qr. intente de nuevo.', 'error');
	}
	$records = $connection->prepare('DELETE FROM datos_clinicos WHERE datos_clinicos.IDDatosClinicos = :dta');
	$records->bindParam(':dta', $resultsdta['DatosClinicos']);
	if ($records->execute()) {
		$message = array(' Exito', 'Codigo Qr eliminado correctamente.', 'success');
	} else {
		$message = array(' Error', 'Ocurrio un error al eliminar el codigo Qr. intente de nuevo.', 'error');
	}
	return $message;
}


if (isset($_POST['action'])) {
	$id = $_POST['id_code'];
	$path = $_POST['path'];
	switch ($_POST['action']) {
		case 'Eliminar':
			$message = deleteQR($id, $path);
			break;
		case 'Editar':
			# code...
			break;
		default:
			# code...
			break;
	}
}


$user = getUser($_SESSION['user_id']);

$records = $connection->prepare('SELECT qr.Atributos, qr.Titulo, qr.RutaArchivo, qr.Duracion, qr.Descripcion, qr.Id_codigo, qr.nombre, qr.Atributo, atr.Atributosqr , eps.NombreEps, us.id
FROM codigo_qr AS qr
LEFT OUTER JOIN AtributosQr AS atr 
ON qr.Atributos = atr.IDAtributosQr
LEFT OUTER JOIN usuario as us
ON qr.Ndocumento = us.Ndocumento 
LEFT OUTER JOIN eps
ON us.id= eps.id
WHERE us.Ndocumento = :id');
$records->bindParam(':id', $_SESSION['user_id']);


if ($records->execute()) {
	$results = $records->fetchAll(PDO::FETCH_ASSOC);
	//$codes = $results;
} else {
	$message = array(' Error', 'Ocurrio un error en la consulta codigos user. intente de nuevo.', 'error');
}

if ($user['id'] == 10) {
	$newEps = true;

	$records = $connection->prepare('SELECT * FROM eps');
	//$records->bindParam(':id', $user['id']);
	if ($records->execute()) {
		$eps = $records->fetchAll(PDO::FETCH_ASSOC);
		//$codes = $results;
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
	<link rel="stylesheet" href="./assets/css/responsiveAll.css">

	<style>


		
	@media (min-width: 768px){
		.col-md-6 {
		max-width: 100%;
		}
	}
	</style>
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
					<h1>Mis codigos QR</h1>
				</div>
				<div class="container ">
					<hr>
					<?php if (count($results) < 1) { ?>
						<div class="container_empty ">

							<h3><i>No hay codigos Qr para mostrar</i></h3>

						</div>
					<?php } else {  ?>


						<?php foreach ($results as $code) { ?>
							<div class="roww2">
								<div class=" text-center">
									<div class="single-product-item">
										<div class="product-image">
											<a href="<?php echo $code['RutaArchivo'] ?>" target="BLANK">
												<img src="<?php echo 'https://quickchart.io/qr?text=' . $code['RutaArchivo'] . $code['Atributo'] ?>" alt=""></a>
										</div>
										<h3><?php echo $code['Titulo'] ?></h3>

										<p class="product-price"><span><?php // echo $code['description'] 
																		?></span> </p>

										<p class="product-price"><span><?php echo 'Fecha: ' . $code['Duracion'] ?></span> </p>
										<a class="cart-btn OptionsCodeQr <?= 'OptionsCodeQr' . $code['Id_codigo'] ?> "><i class="fas fa-pen"></i> opciones</a>
										<?php if($code['id']!=10){ ?>
										<a class="cart-btn OptionsCodeQr <?= 'OptionsCodeQr' . $code['Id_codigo'] ?> " href="
										<?php 
										switch($code['NombreEps']){
											case 'Capital Salud':
												echo 'https://www.capitalsalud.gov.co/menu-citas/';
											break;
											case 'Sanitas':
												echo 'https://www.epssanitas.com/';
											break;
											case 'Compesar':
												echo 'https://corporativo.compensar.com/salud/compensar-eps/cita-medica';
											break;
											case 'Colsubsidio':
												echo 'https://www.colsubsidio.com/tu-salud/ips/gestion';
											break;
											case 'Famisanar':
												echo 'https://www.cafam.com.co/tx/salud';
											break;
											case 'Comfenalco':
												echo 'https://www.comfenalcoeps.com/';
											break;
											default:
												echo 'https://www.google.com/search?q=citas+medicas+bogota&oq=citas+medicas+bogota';
											break;
										}

										?>
										" target="_blank" ><i class="fas fa-pen"></i> Solicitar Cita Medica</a>
										<?php } ?>
									</div>
								</div>
							</div>


							<div class="cont-optionsCode <?= 'contOptionsCode' . $code['Id_codigo'] ?>  ">
								<div class="divcont">
									<div class="icon-close <?= 'iconClose' . $code['Id_codigo'] ?>">
										<i>X</i>
									</div>
									<h3>Codigo Qr opciones</h3>
									<form action="./dashboard.php" method="POST">
										<div class="subcont-optionsCode">
											<label for="Titulo-code">Titulo</label><br>
											<input type="text" id='Titulo-code' value="<?php echo $code['Titulo'] ?>">
											<br>
											<label for="FileLinkPath"> Archivo</label>
											<a id="FileLinkPath" href='<?php echo $code['RutaArchivo'] ?>' target="BLANK">Archivo<?php echo '  ' . $code['Titulo'] . '.pdf' ?> </a>

											<br>
											<label>Fecha: <?php echo $code['Duracion'] ?></label>
											<details>
												<summary>
													Vista Previa
												</summary>

												<iframe src="<?php echo 'https://docs.google.com/gview?embedded=true&url=' . $code['RutaArchivo'] ?>" frameborder="0" width="100%" height="300px"></iframe>

											</details>

											<label for="Description-code">Descripcion</label><br>
											<textarea type="text" id="Description-code" class='Description-code' value=""><?php echo $code['Descripcion'] ?></textarea>
											<label for="UpdateDataForm">Other</label><br>
											<a href="./formulario_datos_clinicos.php?idFormEdit=<?php echo $code['Id_codigo'] ?>" type="button" class="button btn-info" id='UpdateDataForm' value="UpdateDataForm">Actualizar formulario <i class="fas fa-pen"> </i></a>
										</div>
										<input type="hidden" name="id_code" value="<?= $code['Id_codigo'] ?>">
										<input type="hidden" name="path" value="<?= $code['nombre'] ?>">
										<input class="button bg-succes fas fa-writte" type='submit' value="Actualizar" name="action">
										<input class="button btn-danger fas fa-trash" type="submit" value="Eliminar" name="action">


									</form>
								</div>


							</div>


							<?php
							$iconclose = "iconClose" . $code['Id_codigo'];
							$btnOptions = "OptionsCodeQr" . $code['Id_codigo'];
							$contOptions = "contOptionsCode" . $code['Id_codigo'];

							?>

							<?php
							echo " <script> " .
								" " .
								" var $iconclose = document.querySelector('.$iconclose'); " .
								" var $btnOptions = document.querySelector('.$btnOptions'); " .
								" var $contOptions = document.querySelector('.$contOptions'); " .
								" " .
								" $btnOptions.addEventListener('click', () => { " .
								" console.log('ok'); " .
								" $contOptions.style.opacity = '1'; " .
								" $contOptions.style.visibility = 'visible'; " .
								" }); " .
								" $iconclose.addEventListener('click', () => { " .
								" $contOptions.style.opacity = '0'; " .
								" $contOptions.style.visibility = 'hidden'; " .
								" }); " .
								" </script> ";
							?>

							<style>
								<?php echo '.cont-optionsCode' . $code['Id_codigo'] . ' {
                            opacity: 0;
                            visibility: hidden;
                        }' ?>
							</style>

							<?php if (isset($_GET['DataCode']) && !empty($_GET['DataCode']) && $_GET['DataCode'] == $code['Id_codigo']) {
								echo " <script> " .
									" " .
									" $contOptions.style.opacity = '1'; " .
									" $contOptions.style.visibility = 'visible'; " .
									" </script> ";
							} ?>

						<?php   }; ?>



					<?php } ?>
					<hr>
				</div>
			</div>
			<!-- end product section -->

			<div class="cont-button">

				<a href="./clinico.php" class="link-button-new">
					Nuevo <i class="fas fa-plus"></i>
				</a>
			</div>


			<?php if (isset($newEps) && $newEps) { ?>


				<script>
					function setEps() {

						Swal.fire({
							title: '<strong><u>Cual es tu eps?</u></strong>',
							icon: 'info',
							html:

								`

                            <form action="../controller/formOptions.php" method="POST" >

								<div class="form-group">
                                            <select class="form-control" >
                                                <option value="1">EPS</option>
												<option value="2">ARL</option>
												<option value="3">AFP</option>
												<option value="4">Caja de compensacion</option>
                                            </select>
								</div>
								<div class="form-group">
									
                                            <select class="form-control" name='Eps' >
                                            <?php foreach ($eps as $key => $value) {  ?>    

												<?php if ($value['id'] == $user['id']) { ?>
													<option value="<?php echo $value['id'] ?>" selected><?php echo $value['NombreEps'] ?></option>
												<?php } else { ?>

												<option value="<?php echo $value['id'] ?>"><?php echo $value['NombreEps'] ?></option>
												<?php } ?>
											<?php } ?>
                                            </select>
									
								</div>
                                <button type="submit" name="update" class="btn btn-primary">Submit</button>
                            </form>

`,
							showCloseButton: true,
							showCancelButton: true,
							focusConfirm: false,
							cancelButtonText: '<i class="fa fa-thumbs-down">  Haora no.</i>',
							cancelButtonAriaLabel: 'Thumbs down'
						})
					}
					setEps();
				</script>


				<a class="cart-btn OptionsCodeQr cont-button cont-buttonform" data-toggle="modal" onclick="setEps();">Cual es tu eps?</a>


			<?php } ?>



		</main>

		<!-- Estilos generales -->
		<?php
		include('./templates/footerWebUser.php')
		?>

	</div>
	<!-- <script src="./assets/js/dashboard.js"></script> -->
</body>

</html>