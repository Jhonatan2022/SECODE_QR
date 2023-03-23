<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    http_response_code(404);
    header('Location: ../../index.php');
}

require_once('../../main.php');
require_once(BaseDir . '/models/database/database.php');
require_once(BaseDir . '/models/user.php');
$user = getUser($_SESSION['user_id']);
$resultsUser = getUser($_SESSION['user_id']);
if ($resultsUser['rol'] == 2) {
    if(isset($_POST['IDTipoSuscripcion'], $_POST['submit'])){
        $id = $_POST['IDTipoSuscripcion'];
        $tipo = $_POST['TipoSuscripcion'];
        $precio = $_POST['precio'];
        $cantidad = $_POST['cantidad_qr'];
        $editar = $_POST['Editar'];
        $citas = $_POST['citas'];
        $nombre_archivo = $_POST['nombre_archivo'];
        $editarqr = $_POST['EditarQR'];
        $compartirperfil= $_POST['CompartirPerfil'];
        $RellenarFormulario = $_POST['RellenarFormulario'];
        $EnviarMensaje = $_POST['EnviarMensaje'];
        try{
            $query = $connection->prepare('UPDATE TipoSuscripcion SET TipoSuscripcion = :tipo, precio = :precio, cantidad_qr = :cantidad, citas = :citas, Editar = :editar, nombre_archivo = :nombrear, EditarQR = :editqr, CompartirPerfil = :CompartirPerfil, RellenarFormulario = :RellenarFormulario, EnviarMensaje = :EnviarMensaje WHERE IDTipoSuscripcion = :id');
            $query->bindParam(':id', $id);
            $query->bindParam(':tipo', $tipo);
            $query->bindParam(':precio', $precio);
            $query->bindParam(':cantidad', $cantidad);
            $query->bindParam(':citas', $citas);
            $query->bindParam(':editar', $editar);
            $query->bindParam(':nombrear', $nombre_archivo);
            $query->bindParam(':editqr', $editarqr);
            $query->bindParam(':CompartirPerfil', $compartirperfil);
            $query->bindParam(':RellenarFormulario', $RellenarFormulario);
            $query->bindParam(':EnviarMensaje', $EnviarMensaje);
            if($query->execute()){
                $message = array('completado exitosamente', 'Datos actualizados correctamente', 'success');
            }else{
                $message = array('Error', 'No se pudo actualizar los datos, sin error', 'error');
            }
        }catch(PDOException $e){
            $message = array('Error', 'No se pudo actualizar los datos con error '.$e, 'error');
        }
    }
    $planes = getTipoSuscripcion();
} else {
    http_response_code(404);
    header('Location: ../../index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head> 
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- favicon -->
    <link rel="shortcut icon" type="image/png" href="../../views/assets/img/logo.png">
    <!-- google font -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <!-- fontawesome -->
    <link rel="stylesheet" href="../../views/assets/css/all.min.css">
    <!-- bootstrap -->
    <link rel="stylesheet" href="../../views/assets/bootstrap/css/bootstrap.min.css">
    <!-- animate css -->
    <link rel="stylesheet" href="../../views/assets/css/animate.css">
    <!-- mean menu css -->
    <link rel="stylesheet" href="../../views/assets/css/meanmenu.min.css">
    <!-- main style -->
    <link rel="stylesheet" href="../../views/assets/css/main.css">
    <!-- responsive -->
    <link rel="stylesheet" href="../../views/assets/css/responsive.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="../css/es.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

<!-- use Sweet Alerts2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>planes</title>
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
    <?php include('../../views/templates/navBar.php') ?>
    <main class="container">
        <div class="container">
            <div class="row">
                <div class="col-12" style="margin-top: 7rem;">
                <a href="tablero.php" style="color: black; font-size:2rem; font-weight:bolder"> <-- REGRESAR</a>
                    <h1>Planes</h1>

                    <?php foreach ($planes as $key) { ?>
                        <form action="" method="post" class="form" style="display:inline-block;">
                            <table border="2px">
                                <?php foreach ($key as $valkey => $value) { ?>

                                    <tr>
                                        <td>
                                            <label for="<?= $valkey ?>"><?= $valkey ?></label>
                                        </td>
                                        <td>
                                            <?php switch ($valkey) { 
                                            case 'IDTipoSuscripcion': ?>
                                                    <input class="form-control" type="hidden" name="<?= $valkey ?>" id="<?= $valkey ?>" value="<?= $value ?>">
                                                    <?php break; ?>
                                            <?php case 'TipoSuscripcion': ?>
                                                    <input class="form-control" type="text" maxlength="15" name="<?= $valkey ?>" id="<?= $valkey ?>" value="<?= $value ?>">
                                                    <?php break; ?>
                                                <?php
                                                case 'precio': ?>
                                                    <input class="form-control" type="tel" maxlength="6" name="<?= $valkey ?>" id="<?= $valkey ?>" value="<?= $value ?>">
                                                    <?php break; ?>
                                                <?php
                                                case 'cantidad_qr': ?>
                                                    <input class="form-control" type="tel" maxlength="2" name="<?= $valkey ?>" id="<?= $valkey ?>" value="<?= $value ?>">
                                                    <?php break; ?>
                                                <?php
                                                case 'Editar': ?>
                                                    <select name="<?=$valkey?>" id="<?=$valkey?>">
                                                        <option value="NO" <?php if ($value === 'NO') {
                                                                                echo 'selected';
                                                                            } ?>>NO</option>
                                                        <option value="SI" <?php if ($value === 'SI') {
                                                                                echo 'selected';
                                                                            } ?>>SI</option>
                                                    </select>
                                                    <?php break; ?>
                                                <?php
                                                case 'citas': ?>
                                                    <select name="<?=$valkey?>" id="<?=$valkey?>">
                                                        <option value="NO" <?php if ($value === 'NO') {
                                                                                echo 'selected';
                                                                            } ?>>NO</option>
                                                        <option value="SI" <?php if ($value === 'SI') {
                                                                                echo 'selected';
                                                                            } ?>>SI</option>
                                                    </select>
                                                    <?php break; ?>
                                                <?php
                                                case 'EditarQR': ?>
                                                    <select name="<?=$valkey?>" id="<?=$valkey?>">
                                                        <option value="NO" <?php if ($value === 'NO') {
                                                                                echo 'selected';
                                                                            } ?>>NO</option>
                                                        <option value="SI" <?php if ($value === 'SI') {
                                                                                echo 'selected';
                                                                            } ?>>SI</option>
                                                    </select>
                                                    <?php break; ?>
                                                <?php
                                                case 'CompartirPerfil': ?>
                                                    <select name="<?=$valkey?>" id="<?=$valkey?>">
                                                        <option value="NO" <?php if ($value === 'NO') {
                                                                                echo 'selected';
                                                                            } ?>>NO</option>
                                                        <option value="SI" <?php if ($value === 'SI') {
                                                                                echo 'selected';
                                                                            } ?>>SI</option>
                                                    </select>
                                                    <?php break; ?>
                                                <?php
                                                case 'RellenarFormulario': ?>
                                                    <select name="<?=$valkey?>" id="<?=$valkey?>">
                                                        <option value="NO" <?php if ($value === 'NO') {
                                                                                echo 'selected';
                                                                            } ?>>NO</option>
                                                        <option value="SI" <?php if ($value === 'SI') {
                                                                                echo 'selected';
                                                                            } ?>>SI</option>
                                                    </select>
                                                    <?php break; ?>
                                                <?php
                                                case 'EnviarMensaje': ?>
                                                    <select name="<?=$valkey?>" id="<?=$valkey?>">
                                                        <option value="NO" <?php if ($value === 'NO') {
                                                                                echo 'selected';
                                                                            } ?>>NO</option>
                                                        <option value="SI" <?php if ($value === 'SI') {
                                                                                echo 'selected';
                                                                            } ?>>SI</option>
                                                    </select>
                                                    <?php break; ?>
                                                <?php
                                                default: ?>
                                                    <input class="form-control" type="text" name="<?= $valkey ?>" id="<?= $valkey ?>" value="<?= $value ?>">
                                                    <?php break; ?>
                                            <?php } ?>

                                        </td>
                                    </tr>

                                <?php } ?>
                            </table>
                            <input type="submit" name="submit" value="Actualizar" class="button">
                        </form>
                        <br>
                        <br>
                        <br>
                        <br>
                    <?php } ?>
                </div>
            </div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>

    <!-- jquery -->
    <script src="../../views/assets/js/jquery-1.11.3.min.js"></script>
    <!-- bootstrap -->
    <script src="../../views/assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- isotope -->
    <script src="../../views/assets/js/jquery.isotope-3.0.6.min.js"></script>
    <!-- magnific popup -->
    <script src="../../views/assets/js/jquery.magnific-popup.min.js"></script>
    <!-- mean menu -->
    <script src="../../views/assets/js/jquery.meanmenu.min.js"></script>
    <!-- sticker js -->
    <script src="../../views/assets/js/sticker.js"></script>
    <!-- main js -->
    <script src="../../views/assets/js/main.js"></script>
    <style>
        body {
            background-color: #ffffff;
background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1600 900'%3E%3Cdefs%3E%3ClinearGradient id='a' x1='0' x2='0' y1='1' y2='0' gradientTransform='rotate(263,0.5,0.5)'%3E%3Cstop offset='0' stop-color='%230FF'/%3E%3Cstop offset='1' stop-color='%23CF6'/%3E%3C/linearGradient%3E%3ClinearGradient id='b' x1='0' x2='0' y1='0' y2='1' gradientTransform='rotate(288,0.5,0.5)'%3E%3Cstop offset='0' stop-color='%23F00'/%3E%3Cstop offset='1' stop-color='%23FC0'/%3E%3C/linearGradient%3E%3C/defs%3E%3Cg fill='%23FFF' fill-opacity='0' stroke-miterlimit='10'%3E%3Cg stroke='url(%23a)' stroke-width='17.16'%3E%3Cpath transform='translate(-187.6 32.8) rotate(17.8 1409 581) scale(1.0406)' d='M1409 581 1450.35 511 1490 581z'/%3E%3Ccircle stroke-width='5.720000000000001' transform='translate(-145 118) rotate(26.4 800 450) scale(1.04055)' cx='500' cy='100' r='40'/%3E%3Cpath transform='translate(77.4 -273) rotate(255 401 736) scale(1.04055)' d='M400.86 735.5h-83.73c0-23.12 18.74-41.87 41.87-41.87S400.86 712.38 400.86 735.5z'/%3E%3C/g%3E%3Cg stroke='url(%23b)' stroke-width='5.2'%3E%3Cpath transform='translate(708 -29.2) rotate(7.3 150 345) scale(0.9162)' d='M149.8 345.2 118.4 389.8 149.8 434.4 181.2 389.8z'/%3E%3Crect stroke-width='11.440000000000001' transform='translate(-373 -304) rotate(295.2 1089 759)' x='1039' y='709' width='100' height='100'/%3E%3Cpath transform='translate(-607.2 192.8) rotate(49.2 1400 132) scale(0.91)' d='M1426.8 132.4 1405.7 168.8 1363.7 168.8 1342.7 132.4 1363.7 96 1405.7 96z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
background-attachment: fixed;
background-size: cover;}

        label {
            font-weight: bolder;
            font-size: larger;
        }
		nav.main-menu ul li a {
			color: black;
		}
    </style>
</body>

</html>