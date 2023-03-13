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
if ($resultsUser['rol'] === '2') {
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
        try{
            $query = $connection->prepare('UPDATE TipoSuscripcion SET TipoSuscripcion = :tipo, precio = :precio, cantidad_qr = :cantidad, citas = :citas, Editar = :editar, nombre_archivo = :nombrear, EditarQR = :editqr, CompartirPerfil = :CompartirPerfil, RellenarFormulario = :RellenarFormulario WHERE IDTipoSuscripcion = :id');
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
            background-color: #6D5A73;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='615' height='615' viewBox='0 0 200 200'%3E%3Cg %3E%3Cpolygon fill='%23a00a30' points='100 57.1 64 93.1 71.5 100.6 100 72.1'/%3E%3Cpolygon fill='%23b62940' points='100 57.1 100 72.1 128.6 100.6 136.1 93.1'/%3E%3Cpolygon fill='%23a00a30' points='100 163.2 100 178.2 170.7 107.5 170.8 92.4'/%3E%3Cpolygon fill='%23b62940' points='100 163.2 29.2 92.5 29.2 107.5 100 178.2'/%3E%3Cpath fill='%23CC3F51' d='M100 21.8L29.2 92.5l70.7 70.7l70.7-70.7L100 21.8z M100 127.9L64.6 92.5L100 57.1l35.4 35.4L100 127.9z'/%3E%3Cpolygon fill='%232a8e51' points='0 157.1 0 172.1 28.6 200.6 36.1 193.1'/%3E%3Cpolygon fill='%234cad6d' points='70.7 200 70.8 192.4 63.2 200'/%3E%3Cpolygon fill='%236CCC8A' points='27.8 200 63.2 200 70.7 192.5 0 121.8 0 157.2 35.3 192.5'/%3E%3Cpolygon fill='%234cad6d' points='200 157.1 164 193.1 171.5 200.6 200 172.1'/%3E%3Cpolygon fill='%232a8e51' points='136.7 200 129.2 192.5 129.2 200'/%3E%3Cpolygon fill='%236CCC8A' points='172.1 200 164.6 192.5 200 157.1 200 157.2 200 121.8 200 121.8 129.2 192.5 136.7 200'/%3E%3Cpolygon fill='%232a8e51' points='129.2 0 129.2 7.5 200 78.2 200 63.2 136.7 0'/%3E%3Cpolygon fill='%236CCC8A' points='200 27.8 200 27.9 172.1 0 136.7 0 200 63.2 200 63.2'/%3E%3Cpolygon fill='%234cad6d' points='63.2 0 0 63.2 0 78.2 70.7 7.5 70.7 0'/%3E%3Cpolygon fill='%236CCC8A' points='0 63.2 63.2 0 27.8 0 0 27.8'/%3E%3C/g%3E%3C/svg%3E");
        }

        label {
            font-weight: bolder;
            font-size: larger;
        }
    </style>
</body>

</html>