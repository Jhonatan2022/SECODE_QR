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
    $query= 'SELECT * FROM Administrador';
    $params = $connection->prepare($query);
    $params->execute();
    $data = $params->fetchAll(PDO::FETCH_ASSOC);
  
    $query= 'SELECT * FROM usuario';
    $params = $connection->prepare($query);
    $params->execute();
    $dataUser = $params->fetchAll(PDO::FETCH_ASSOC);
    
#AddUserAdmin();
    if(isset($_POST['enviar'],$_POST['correo'])){
        $correo = $_POST['correo'];
        $query= 'INSERT INTO Administrador (Correo, TipoRol ) VALUES (:correo, 2)';
        $params = $connection->prepare($query);
        $params->bindParam(':correo', $correo);
        $params->execute();
        $message = array('completado exitosamente', 'Usuario agregado Correctamente', 'success');
    }
    if(isset($_POST['delete'],$_POST['id'],$_POST['correo'])){
        $id = $_POST['id'];
        $query= "DELETE FROM Administrador WHERE IDAdministrador = :id ";
        $params = $connection->prepare($query);
        $params->bindParam(':id', $id);
        $params->execute();
        $query= 'UPDATE usuario SET rol = 1 WHERE Correo = :correo';
        $params = $connection->prepare($query);
        $params->bindParam(':correo', $_POST['correo']);
        $params->execute();
        $message = array('completado exitosamente', 'Usuario ELIMINADO exitosamente', 'success');
    }

    $query= 'SELECT * FROM Administrador';
    $params = $connection->prepare($query);
    $params->execute();
    $data = $params->fetchAll(PDO::FETCH_ASSOC);
    
}else{
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
    <title>Acceso</title>
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
            <div class="col-12" style="margin-top: 7rem; background-color:#88ccce33; padding:2rem;">
            <a href="tablero.php" style="color: black; font-size:2rem; font-weight:bolder"> <-- REGRESAR</a>
                <h1>Agregar administrador</h1>
                    <form action="getAcces.php" method="POST" class="form">
                        <label for="correo">Correo:</label>
                        <input type="email" name="correo" id="correo"class="form-control" placeholder="Correo" required>
                        <br>
                        <input type="submit" value="Enviar" name="enviar">
                    </form>
            </div>
                <div class="col-12" >
                    <h1>Administradores:</h1>
                    <?php foreach($data as $row){ ?>
                        <table border="2px" class="">
                        <?php foreach ($row as $valkey => $value) { ?>
                        <tr>
                        <td>
                            <label for="<?= $valkey ?>"><?= $valkey ?></label>
                        </td>
                        </tr>
                        <tr>
                        <td>
                            <input type="text" name="<?= $valkey ?>" id="<?= $valkey ?>" value="<?= $value ?>" disabled>
                        </td>
                        </tr>
                        <?php } ?>
                        </table>
                        <form action="" method="post">
                            <input type="hidden" name="id" value="<?= $row['IDAdministrador'] ?>">
                            <input type="hidden" name="correo" value="<?= $row['Correo'] ?>">
                            <input type="submit" class="btn" name="delete" value="Eliminar">
                        </form>
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
background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100%25'%3E%3Cdefs%3E%3ClinearGradient id='a' gradientUnits='userSpaceOnUse' x1='0' x2='0' y1='0' y2='100%25' gradientTransform='rotate(276,643,311)'%3E%3Cstop offset='0' stop-color='%23ffffff'/%3E%3Cstop offset='1' stop-color='%23ACF1FF'/%3E%3C/linearGradient%3E%3Cpattern patternUnits='userSpaceOnUse' id='b' width='300' height='250' x='0' y='0' viewBox='0 0 1080 900'%3E%3Cg fill-opacity='0.03'%3E%3Cpolygon fill='%23444' points='90 150 0 300 180 300'/%3E%3Cpolygon points='90 150 180 0 0 0'/%3E%3Cpolygon fill='%23AAA' points='270 150 360 0 180 0'/%3E%3Cpolygon fill='%23DDD' points='450 150 360 300 540 300'/%3E%3Cpolygon fill='%23999' points='450 150 540 0 360 0'/%3E%3Cpolygon points='630 150 540 300 720 300'/%3E%3Cpolygon fill='%23DDD' points='630 150 720 0 540 0'/%3E%3Cpolygon fill='%23444' points='810 150 720 300 900 300'/%3E%3Cpolygon fill='%23FFF' points='810 150 900 0 720 0'/%3E%3Cpolygon fill='%23DDD' points='990 150 900 300 1080 300'/%3E%3Cpolygon fill='%23444' points='990 150 1080 0 900 0'/%3E%3Cpolygon fill='%23DDD' points='90 450 0 600 180 600'/%3E%3Cpolygon points='90 450 180 300 0 300'/%3E%3Cpolygon fill='%23666' points='270 450 180 600 360 600'/%3E%3Cpolygon fill='%23AAA' points='270 450 360 300 180 300'/%3E%3Cpolygon fill='%23DDD' points='450 450 360 600 540 600'/%3E%3Cpolygon fill='%23999' points='450 450 540 300 360 300'/%3E%3Cpolygon fill='%23999' points='630 450 540 600 720 600'/%3E%3Cpolygon fill='%23FFF' points='630 450 720 300 540 300'/%3E%3Cpolygon points='810 450 720 600 900 600'/%3E%3Cpolygon fill='%23DDD' points='810 450 900 300 720 300'/%3E%3Cpolygon fill='%23AAA' points='990 450 900 600 1080 600'/%3E%3Cpolygon fill='%23444' points='990 450 1080 300 900 300'/%3E%3Cpolygon fill='%23222' points='90 750 0 900 180 900'/%3E%3Cpolygon points='270 750 180 900 360 900'/%3E%3Cpolygon fill='%23DDD' points='270 750 360 600 180 600'/%3E%3Cpolygon points='450 750 540 600 360 600'/%3E%3Cpolygon points='630 750 540 900 720 900'/%3E%3Cpolygon fill='%23444' points='630 750 720 600 540 600'/%3E%3Cpolygon fill='%23AAA' points='810 750 720 900 900 900'/%3E%3Cpolygon fill='%23666' points='810 750 900 600 720 600'/%3E%3Cpolygon fill='%23999' points='990 750 900 900 1080 900'/%3E%3Cpolygon fill='%23999' points='180 0 90 150 270 150'/%3E%3Cpolygon fill='%23444' points='360 0 270 150 450 150'/%3E%3Cpolygon fill='%23FFF' points='540 0 450 150 630 150'/%3E%3Cpolygon points='900 0 810 150 990 150'/%3E%3Cpolygon fill='%23222' points='0 300 -90 450 90 450'/%3E%3Cpolygon fill='%23FFF' points='0 300 90 150 -90 150'/%3E%3Cpolygon fill='%23FFF' points='180 300 90 450 270 450'/%3E%3Cpolygon fill='%23666' points='180 300 270 150 90 150'/%3E%3Cpolygon fill='%23222' points='360 300 270 450 450 450'/%3E%3Cpolygon fill='%23FFF' points='360 300 450 150 270 150'/%3E%3Cpolygon fill='%23444' points='540 300 450 450 630 450'/%3E%3Cpolygon fill='%23222' points='540 300 630 150 450 150'/%3E%3Cpolygon fill='%23AAA' points='720 300 630 450 810 450'/%3E%3Cpolygon fill='%23666' points='720 300 810 150 630 150'/%3E%3Cpolygon fill='%23FFF' points='900 300 810 450 990 450'/%3E%3Cpolygon fill='%23999' points='900 300 990 150 810 150'/%3E%3Cpolygon points='0 600 -90 750 90 750'/%3E%3Cpolygon fill='%23666' points='0 600 90 450 -90 450'/%3E%3Cpolygon fill='%23AAA' points='180 600 90 750 270 750'/%3E%3Cpolygon fill='%23444' points='180 600 270 450 90 450'/%3E%3Cpolygon fill='%23444' points='360 600 270 750 450 750'/%3E%3Cpolygon fill='%23999' points='360 600 450 450 270 450'/%3E%3Cpolygon fill='%23666' points='540 600 630 450 450 450'/%3E%3Cpolygon fill='%23222' points='720 600 630 750 810 750'/%3E%3Cpolygon fill='%23FFF' points='900 600 810 750 990 750'/%3E%3Cpolygon fill='%23222' points='900 600 990 450 810 450'/%3E%3Cpolygon fill='%23DDD' points='0 900 90 750 -90 750'/%3E%3Cpolygon fill='%23444' points='180 900 270 750 90 750'/%3E%3Cpolygon fill='%23FFF' points='360 900 450 750 270 750'/%3E%3Cpolygon fill='%23AAA' points='540 900 630 750 450 750'/%3E%3Cpolygon fill='%23FFF' points='720 900 810 750 630 750'/%3E%3Cpolygon fill='%23222' points='900 900 990 750 810 750'/%3E%3Cpolygon fill='%23222' points='1080 300 990 450 1170 450'/%3E%3Cpolygon fill='%23FFF' points='1080 300 1170 150 990 150'/%3E%3Cpolygon points='1080 600 990 750 1170 750'/%3E%3Cpolygon fill='%23666' points='1080 600 1170 450 990 450'/%3E%3Cpolygon fill='%23DDD' points='1080 900 1170 750 990 750'/%3E%3C/g%3E%3C/pattern%3E%3C/defs%3E%3Crect x='0' y='0' fill='url(%23a)' width='100%25' height='100%25'/%3E%3Crect x='0' y='0' fill='url(%23b)' width='100%25' height='100%25'/%3E%3C/svg%3E");
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