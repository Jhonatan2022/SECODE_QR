<?php



session_start();
require_once '../models/database/database.php';
require_once '../models/user.php';
if (!isset($_SESSION["user_id"])) {
	header('Location: index.php');
}


if(isset($_GET['ResponseQR']) && $_GET['ResponseQR'] == 1){
	$message = array(' Exito', 'Codigo Qr eliminado correctamente.', 'success');
}elseif(isset($_GET['ResponseQR']) && $_GET['ResponseQR'] == 'error'){
	$message = array(' Error', 'Ocurrio un error al eliminar el codigo Qr. intente de nuevo.', 'error');
}
if(isset($_GET['Editar']) && $_GET['Editar'] == 'ok'){
	$message = array(' Exito', 'Codigo Qr editado correctamente.', 'success');
}elseif(isset($_GET['Editar']) && $_GET['Editar'] == 'error'){
	$message = array(' Error', 'Ocurrio un error al editar el codigo Qr. intente de nuevo.', 'error');
}


$user = getUser($_SESSION['user_id']);
verifyDateExpiration($user['Ndocumento']);

if(isset($_GET['GenerateError']) && $_GET['GenerateError'] == '1'){
	$message = array(' Error', 'No puede crear mas Codigos Qr, actualice su membresia', 'error');
}if(isset($_GET['GenerateError']) && $_GET['GenerateError'] == '2'){
	$message = array(' Error', 'No puede Editar formularios, actualice su membresia', 'error');
}

$records = $connection->prepare('SELECT qr.Privacidad, qr.Atributos, qr.Titulo, qr.RutaArchivo, qr.Duracion, qr.Descripcion, qr.Id_codigo, qr.FormularioMedicamentos, qr.nombre, qr.Atributo, atr.Atributosqr , eps.NombreEps, us.id
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
$suscripcion = getSuscription($_SESSION['user_id']);

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
										<h3><?php if($code['Titulo'] != (null || '') ){ echo $code['Titulo'];}else{echo 'Sin Titulo';} ?></h3>
										<p class="product-price"><span style="border: 3px solid purple; border-radius:5px;padding:5px"><a href="http://<?=$_SERVER['HTTP_HOST'].'/secodeqr/views/pdf/form.php?formulario='.$code['nombre']?>" target="_blank" rel="noopener noreferrer"><strong>Ver en Nuevo diseño</strong></a></span> </p>
										<div class="container" style="width:300px; height:fit-content; min-height:6.5rem; max-height:7.5rem; max-width:300px;background-color: #d5d5d5; border-radius:10px ">
										<p class="product-price" style="text-overflow:ellipsis;overflow: visible; white-space:wrap" ><?='<strong>Descripcion: </strong><br>'.$code['Descripcion'] ?></p>
										</div>
										<br>
										<p class="product-price"><span><?php echo ' <strong>Fecha: </strong>' . $code['Duracion'] ?></span> </p>
										<?php if($suscripcion['CompartirPerfil'] == 'SI' /* && $user['Compartido'] == 1 */){ ?>
										<div>
											<?php
												$PrivacidadQR ='PrivacidadQR'.$code['Id_codigo'];
												$EstadoQR = 'EstadoQR'.$code['Id_codigo'];
											?>
											<label for="<?=$PrivacidadQR?>" style="font-size: larger; font-weight:bolder">Privacidad del codigo Qr</label>
											<input type="checkbox" name="Privacidad" id="<?=$PrivacidadQR?>" <?php if($code['Privacidad'] == 1){echo 'checked';} ?> >
											<p id="<?=$EstadoQR?>" style="font-weight: bolder; color:purple;text-transform: uppercase; border: 4px solid purple; border-radius:5px; display:inline-block; padding:.7rem; "><?php if($code['Privacidad'] == 1){echo 'publico';}else{echo 'privado';} ?></p>
											<script>
												<?php echo "".
												"var $PrivacidadQR = document.getElementById('$PrivacidadQR');".
												"var $EstadoQR = document.getElementById('$EstadoQR');";
												?>
												<?php echo "$PrivacidadQR"?>.addEventListener('change', function() {
													if (<?php echo "$PrivacidadQR"?>.checked) {
														// Hacer algo si el checkbox ha sido seleccionado
														$.ajax({
															url: '../controller/compartirp.php',
															type: 'POST',
															data: {
																Privacidad: 1,
																idQr: <?php echo $code['Id_codigo'] ?>
															},
															success: function(response) {
																if(response == 10){
																	Swal.fire({
																		title: 'Correcto',
																		text: 'Activado correctamente',
																		icon: 'success',
																		confirmButtonText: 'Aceptar'
																	})
																	<?php echo "$EstadoQR"?>.innerHTML = 'Publico';
																}
															}
														});
													} else {
														// Hacer algo si el checkbox ha sido deseleccionado
														//alert('Publico');
														$.ajax({
															url: '../controller/compartirp.php',
															type: 'POST',
															data: {
																Privacidad: 0,
																idQr: <?php echo $code['Id_codigo'] ?>
															},
															success: function(response) {
																if(response == 10){
																	Swal.fire({
																		title: 'Correcto',
																		text: 'Desactivado correctamente',
																		icon: 'success',
																		confirmButtonText: 'Aceptar'
																	})
																	<?php echo "$EstadoQR"?>.innerHTML = 'Privado';
																}
															}
														});
													}
												});
											</script>
										</div>
										<?php } ?>
										<a class="cart-btn OptionsCodeQr <?= 'OptionsCodeQr' . $code['Id_codigo'] ?> "><i class="fas fa-pen"></i> opciones</a>

										<?php if($code['id']!=10 && $suscripcion['citas']=='SI'){ ?>
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


							<div class="cont-optionsCode <?= 'contOptionsCode' . $code['Id_codigo'] ?>  " style='z-index:1100'>
								<div class="divcont">
									<div class="icon-close <?= 'iconClose' . $code['Id_codigo'] ?>">
										<i>X</i>
									</div>
									<h3>Codigo Qr opciones</h3>
									<form action="../controller/dashboard.php" method="POST">
										<div class="subcont-optionsCode">
											<label for="Titulo-code" style="font-size: larger; font-weight:bolder">Titulo</label><br>
											<input type="text" id='Titulo-code' name="Titulo" value="<?php echo $code['Titulo'] ?>">
											<br>
											<label for="FileLinkPath"> Archivo</label>
											<a id="FileLinkPath" href='<?php echo $code['RutaArchivo'] ?>' target="BLANK">Archivo<?php echo '  ' . $code['Titulo'] . '.pdf' ?> </a>

											<br>
											<label style="font-size: larger; font-weight:bolder">Fecha: <?php echo $code['Duracion'] ?></label>
											<details>
												<summary style="font-size:larger; font-weight:bolder;">
													Vista Previa (Dispositivos moviles)
												</summary>

												<iframe src="<?php echo 'https://docs.google.com/gview?embedded=true&url=' . $code['RutaArchivo'] ?>" frameborder="0" width="100%" height="500px"></iframe>

											</details>

											<label for="Description-code" style="font-size: larger; font-weight:bolder">Descripcion</label><br>
											<textarea type="text" maxlength="95" id="Description-code" class='Description-code' name="Descripcion" value=""><?= $code['Descripcion'] ?></textarea>
											<label for="UpdateDataForm" style="font-size:Medium; font-weight:bolder; color:purple;" >Other</label><br>
											<?php 
											$qrhref = 'qrhref'.$code['Id_codigo'];
											$qrimg = 'qrimg'.$code['Id_codigo'];
											$qrText ='qrText'.$code['Id_codigo'];
											$qrSize='qrSize'.$code['Id_codigo'];
											$qrEc='qrEc'.$code['Id_codigo'];
											$qrFg='qrFg'.$code['Id_codigo'];
											$qrBg='qrBg'.$code['Id_codigo'];
											$url = 'url'.$code['Id_codigo'];
											$elts='elts'.$code['Id_codigo'];
											$elt='elt'.$code['Id_codigo'];
											$type = 'type'.$code['Id_codigo'];
											$updateQr = 'updateQr'.$code['Id_codigo'];
											$i = 'i'.$code['Id_codigo'];
											?>
											<?php if($suscripcion['EditarQR']=='SI'):?>
											<input id="<?=$qrhref?>" type="hidden" name="" value="">
											<?php endif;?>
											<details style="background-color: #d5d5d5; border-radius: 7px; font-size:larger; font-weight:bolder;">
												<summary style="font-size:medium;">
													Personalizar Qr
												</summary>												
												<?php include './templates/qr.php' ?>
											</details>
											<br>
											<?php if($suscripcion['Editar']=='SI' && $code['FormularioMedicamentos'] == null ):?>
											<a style="font-size:medium; font-weight:bolder; padding:5px" href="./formulario_datos_clinicos.php?idFormEdit=<?php echo $code['Id_codigo'] ?>" type="button" class="button btn-info" id='UpdateDataForm' value="UpdateDataForm">Actualizar formulario <i class="fas fa-pen"> </i></a>
											<?php elseif($suscripcion['Editar']=='SI' && $code['FormularioMedicamentos'] != null):?>
												
											<?php else:?>
												<a style="font-size:medium; font-weight:bolder; padding:5px"  href="#" type="button" class="button btn-info disabled" >Actualizar formulario <i class="fas fa-pen"> </i></a>
												<h5 style="color:tomato">Por favor Actualiza tu Membresia 🎁</h5>
											<?php endif;?>
										</div>
										<input type="hidden" name="id_code" value="<?= $code['Id_codigo'] ?>">
										<input type="hidden" name="path" value="<?= $code['nombre'] ?>">
										<?php if($suscripcion['precio']==0):?>
												<input class="button bg-succes fas fa-writte" type='submit' value="Actualizar" name="#">
												<input class="button btn-danger fas fa-trash" type="submit" value="Eliminar" name="#">
												<h5 style="color:tomato">Por favor Actualiza tu Membresia 🎁</h5>
											<?php else:?>
												<input class="button bg-succes fas fa-writte" type='submit' value="Actualizar" name="action">
												<input class="button btn-danger fas fa-trash" type="submit" value="Eliminar" name="action">
										<?php endif;?>
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

				<a href="./formulario_datos_clinicos.php" class="link-button-new">
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
							cancelButtonText: '<i class="fa fa-thumbs-down">  Ahora no.</i>',
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
</body>

</html>