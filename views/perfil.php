<!--Conexión base de datos-->
<?php
session_start();

require_once '../models/database/database.php';
//require_once '../controller/userController.php';
require_once '../models/user.php';

if (/* !isset($_SESSION['user_id']) &&  */isset($_GET['compartir']) && filter_var($_GET['compartir'], FILTER_VALIDATE_INT ) ) {

    $query = $connection->prepare("SELECT * FROM usuario WHERE CompartirUrl = :compartir");
    $query->bindParam(':compartir', $_GET['compartir']);
    $query->execute();
    $userperfil = $query->fetch(PDO::FETCH_ASSOC);
    $suscripcion=getSuscription($userperfil['Ndocumento']);
    if($suscripcion['CompartirPerfil']=='NO'|| $userperfil['Compartido']!=1 || $userperfil <1){
        header('Location: ./index.php');
        exit;
    }
    $roluser = $userperfil;
    $user=getUserData($userperfil['Ndocumento']);
    $userForm = userform($userperfil['Ndocumento']);
    $localidad = localidad();
    $tipodoc = tipoDocumento();
    $estrato = estrato();

    $queryQR=$connection->prepare("SELECT * FROM codigo_qr WHERE Ndocumento = :id AND Privacidad = 1");
    $queryQR->bindParam(':id', $user['Ndocumento']);
    $queryQR->execute();
    $results= $queryQR->fetchAll(PDO::FETCH_ASSOC);

    $compartido=true;
}elseif(isset($_SESSION['user_id']) && !isset($_GET['compartir'])){
    $roluser = getUser($_SESSION['user_id']);
    $suscripcion = getSuscription($_SESSION['user_id']);

if (isset($_REQUEST['update'])) {

    $id_us = $_SESSION["user_id"];
    $nombre = $_POST["Nombre"];
    $direccion = $_POST["Direccion"];
    $genero = $_POST["Genero"];
    $correo = $_POST["Correo"];
    $fechaNacimiento = $_POST["FechaNacimiento"];
    $telefono = $_POST["Telefono"];
    $Apellidos = $_POST["Apellidos"];
    $Localidad = $_POST["Localidad"];
    $Estrato = $_POST["Estrato"];
    $TipoDoc = $_POST["TipoDoc"];

    $sql = "SELECT COUNT(us.Correo) FROM usuario AS us WHERE us.Correo =:correo AND us.Ndocumento != :id";
    $query = $connection->prepare($sql);
    $query->bindParam(':correo', $correo);
    $query->bindParam(':id', $id_us);
    $query->execute();
    $count = $query->fetchColumn();
    if ($count > 0) {
        $message = ['error', "Correo ya registrado por otro usuario, intente de nuevo", 'error'];
    } else {

        if (
            $_POST["Nombre"] != ""
            || $_POST["Direccion"] != ""
            || $_POST["Genero"] != ""
            || $_POST["Correo"] != ""
            || $_POST["FechaNacimiento"] != ""
            || $_POST["Telefono"] != ""
            || $_POST["Apellidos"] != ""
            || $_POST["Localidad"] != ""
            || $_POST["Estrato"] != ""
            || $_POST["TipoDoc"] != ""

        ) {
            $fechaNacimiento = date("Y-m-d", strtotime($fechaNacimiento));
            if (isset($_FILES['Img_perfil']) && $_FILES['Img_perfil']['error'] == UPLOAD_ERR_OK) {
                $permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png", "image/pneg");
                $limite_kb = 1000; //10 mb maximo

                if ((in_array($_FILES['Img_perfil']['type'], $permitidos) && $_FILES['Img_perfil']['size'] <= $limite_kb * 1024)) {
                    $tipoArchivo = $_FILES["Img_perfil"]["type"];
                    $tamanoArchivo = $_FILES["Img_perfil"]["size"];

                    $imagenSubida = fopen($_FILES["Img_perfil"]["tmp_name"], "r");
                    $binariosImagen = fread($imagenSubida, $tamanoArchivo);
                    //$binariosImagen = PDO::quote($binariosImagen,);
                    $img = $binariosImagen;


                    $sql = "UPDATE usuario SET Img_perfil = :img , TipoImg = :tipo,
                Nombre = :nombre, Direccion = :direccion, Genero = :genero, Correo = :correo, FechaNacimiento = :fechaNacimiento, Telefono = :telefono, Apellidos = :apellidos, Localidad = :localidad, Estrato = :estrato, TipoDoc = :tipodoc
                WHERE Ndocumento = :id";
                    $query = $connection->prepare($sql);
                    $query->bindParam(':id', $id_us);
                    $query->bindParam(':img', $img);
                    $query->bindParam(':tipo', $tipoArchivo);
                    $query->bindParam(':nombre', $nombre);
                    $query->bindParam(':direccion', $direccion);
                    $query->bindParam(':genero', $genero);
                    $query->bindParam(':correo', $correo);
                    $query->bindParam(':fechaNacimiento', $fechaNacimiento);
                    $query->bindParam(':telefono', $telefono);
                    $query->bindParam(':apellidos', $Apellidos);
                    $query->bindParam(':localidad', $Localidad);
                    $query->bindParam(':estrato', $Estrato);
                    $query->bindParam(':tipodoc', $TipoDoc);

                    if ($query->execute()) {
                        $message = ['Actualización exitosa', 'Los datos se han actualizado correctamente', 'success'];
                    }
                } else {
                    $message = ['error', "Archivo no permitido, es tipo de archivo prohibido o excede el tamano de $limite_kb Kilobytes", 'error'];
                }
            } else {
                if (isset($_POST['quitarfoto'])) {
                    $sql = "UPDATE usuario SET Img_perfil = null , TipoImg = null WHERE Ndocumento = :id";
                    $query2 = $connection->prepare($sql);
                    $query2->bindParam(':id', $id_us);
                    $query2->execute();
                }

                $sql = "UPDATE usuario SET 
                Nombre = :nombre, Direccion = :direccion, Genero = :genero, Correo = :correo, FechaNacimiento = :fechaNacimiento, Telefono = :telefono, Apellidos = :apellidos, Localidad = :localidad, Estrato = :estrato, TipoDoc = :tipodoc
                WHERE Ndocumento = :id";
                $query = $connection->prepare($sql);
                $query->bindParam(':id', $id_us);
                $query->bindParam(':nombre', $nombre);
                $query->bindParam(':direccion', $direccion);
                $query->bindParam(':genero', $genero);
                $query->bindParam(':correo', $correo);
                $query->bindParam(':fechaNacimiento', $fechaNacimiento);
                $query->bindParam(':telefono', $telefono);
                $query->bindParam(':apellidos', $Apellidos);
                $query->bindParam(':localidad', $Localidad);
                $query->bindParam(':estrato', $Estrato);
                $query->bindParam(':tipodoc', $TipoDoc);
                if ($query->execute()) {
                    $message = ['Actualización exitosa', 'Los datos se han actualizado correctamente', 'success'];
                }
            }
        }
    }
}
verifyDateExpiration($_SESSION['user_id']);
$user = getUserData($_SESSION['user_id']);
$userForm = userform($_SESSION['user_id']);
$localidad = localidad();
$tipodoc = tipoDocumento();
$estrato = estrato();
$compartido=false;
}else{
    header('Location: ./index.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>Perfil de usuario</title>
    <!--style perfil-->

    <?php include('./templates/header.php');
    include('./templates/sweetalerts2.php'); ?>

    <link rel="stylesheet" href="./assets/css/perfil.css">

    <style>
        label {
            color: #4b0081;
            font-size: larger;
            font-weight: bolder;
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
        <div class="inner"></div>
    </div>
    <!--PreLoader Ends-->

    <!--Portada de usuario-->
    <?php include('./templates/navBar.php'); ?>


    <?php if (!empty($message)) {
    ?>

        <script>
            Swal.fire(
                '<?php echo $message[0]; ?>',
                '<?php echo $message[1]; ?>',
                '<?php echo $message[2]; ?>')
        </script>
    <?php }; ?>

    <section class="seccion-perfil-usuario">
        <div class="perfil-usuario-header">
            <div class="perfil-usuario-portada">
                <div class="perfil-usuario-avatar">

                    <img src="<?php echo $user['Img_perfil'] ?>" alt="img-avatar">
                    <input type="file" class="boton-avatar" id="boton-avatar" accept=".png, .jpg, ,jpeg ">
                    <label class="boton-avatar" for="boton-avatar"> <i class="boton-redes fas fa-image"></i></label>

                    </button>
                    <script>
                        let button = document.querySelector('.boton-avatar')
                        button.addEventListener('onclick', () => {

                        })
                    </script>
                </div>
            </div>
        </div>
        <!--fin de portada de usuario-->

        <!--Datos del usuario-->
        <div class="perfil-usuario-body">
            <div class="perfil-usuario-bio">
                <h3 class="titulo"><?= $user['Nombre'] . ' ' . $user['Apellidos'] ?>
                <?php if(! $compartido){ ?>
                    <a data-toggle="modal" data-target="#myModal" class="boton-edit">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                <?php } ?>
                </h3>
                <div class="flex-container" style="display: flex;flex-direction: column;flex-wrap: wrap;justify-content: center;align-items: center;align-content: center;">
                    <?php if ($roluser['rol'] == 2 && ! $compartido) {
                        echo '<div class="admin_div"><a href="../admin/views/tablero.php">Tablero de gestion  </a></div>';
                    } ?>
                    <div class="flex-items">
                        Descripcion
                    </div>
                    <?php if ( ! $compartido && $suscripcion['CompartirPerfil'] == "SI" ) { ?>
                        <label for="">Compartir Perfil</label>
                        <a data-toggle="modal" data-target="#myModalPerfil" class="boton-edit">
                            <i class="fas fa-user-alt"></i>
                        </a>
                        <div class="modal" id="myModalPerfil">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Compartir Perfil</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Modal body -->
                                    <div class="modal-body">

                                        <div class="flex-items" style="float: right;">
                                            <form>
                                                <label for="CompartirPerfil">Compartir perfil.</label>
                                                <input type="checkbox" id="CompartirPerfil" value=" " onclick="recordatorio();" name="CompartirPerfil" <?php if($roluser['Compartido']==1){echo 'checked';}?>>
                                                <?php if($roluser['Compartido']==1){?>
                                                <div id="contperfil"  >
                                                    <a href="<?= 'http://' . $_SERVER['HTTP_HOST'] . '/secodeqr/views/perfil.php?compartir=' . $roluser['CompartirUrl'] . '&tipo=usuario' ?>">
                                                        <?= 'http://' . $_SERVER['HTTP_HOST'] . '/secodeqr/views/perfil.php?compartir=' . $roluser['CompartirUrl'] . '&tipo=usuario' ?>
                                                    </a>
                                                    <br>
                                                    <a href="<?= 'http://' . $_SERVER['HTTP_HOST'] . '/secodeqr/views/perfil.php?compartir=' . $roluser['CompartirUrl'] . '&tipo=usuario' ?>" target="_blank">
                                                        <img src="<?= 'https://quickchart.io/qr?text=' .'http://' . $_SERVER['HTTP_HOST'] . '/secodeqr/views/perfil.php?compartir=' . $roluser['CompartirUrl'] . '&tipo=usuario'.'&centerImageUrl=https://programacion3luis.000webhostapp.com/secode/views/assets/img/logo.png&size=300&ecLevel=H&centerImageWidth=120&centerImageHeight=120' ?>" alt="">
                                                    </a>
                                                </div>
                                                <?php }?>
                                            </form>
                                            <script>
                                                function recordatorio() {
                                                    <?php if ($roluser['Compartido'] == 1) { ?>
                                                        Swal.fire({
                                                            title: 'Desactivar compartir perfil',
                                                            text: "Esta opción le permite desactivar la opción de compartir su perfil con otras personas, ¿Desea continuar?",
                                                            icon: 'warning',
                                                            showCancelButton: true,
                                                            confirmButtonColor: '#3085d6',
                                                            cancelButtonColor: '#d33',
                                                            confirmButtonText: 'Si, desactivar!'
                                                        }) <?php } else { ?>
                                                        Swal.fire({
                                                            title: 'Compartir perfil',
                                                            text: "Esta opción le permite compartir su perfil con otras personas, ¿Desea continuar?",
                                                            icon: 'warning',
                                                            showCancelButton: true,
                                                            confirmButtonColor: '#3085d6',
                                                            cancelButtonColor: '#d33',
                                                            confirmButtonText: 'Si, compartir!'
                                                        })
                                                    <?php } ?>
                                                        .then((result) => {
                                                            var CompartirPerfil = document.getElementById("CompartirPerfil");
                                                            if (result.isConfirmed) {
                                                                $.ajax({
                                                                    url: '../controller/compartirp.php',
                                                                    type: 'POST',
                                                                    data: {
                                                                        id: 1,
                                                                        compartir: <?= $roluser['Compartido'] ?>
                                                                    },
                                                                    success: function(data) {
                                                                        if (data == 1) {
                                                                            Swal.fire(
                                                                                'Cambios actualizados',
                                                                                'Sus cambios han sido actualizados',
                                                                                'success'
                                                                            )
                                                                            setTimeout(function() {
                                                                                window.location.reload();
                                                                            }, 1600);
                                                                        } else {
                                                                            Swal.fire(
                                                                                'Cambios  no actualizados',
                                                                                'Sus cambios no han sido actualizados' + data,
                                                                                'error'
                                                                            )
                                                                        }
                                                                    }
                                                                })
                                                            }else{
                                                                if (CompartirPerfil.checked) {
                                                                    CompartirPerfil.checked = false;
                                                                } else {
                                                                    CompartirPerfil.checked = true;
                                                                }
                                                            }
                                                        })
                                                    }
                                            </script>
                                        </div>
                                    </div>
                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="flex-items">

                    </div>
                </div>
                <p class="texto">
                </p>
            </div>
            <?php if(! $compartido){ ?>
            <!-- The Modal -->
            <div class="modal" id="myModal">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Actualizacion de datos.</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">


                            <form action="" method="post" enctype="multipart/form-data">

                                <?php
                                foreach ($userForm as $key => $value) { ?>
                                    <div class="form-group">
                                        <label for="<?= $key ?>"><?= $key ?></label>
                                        <input <?php
                                                switch ($key) {
                                                    case 'Nombre':
                                                        echo  'value="' . $value . ' " maxlength="28" ';
                                                        break;
                                                    case 'Apellidos':
                                                        echo  'value="' . $value . ' " maxlength="28" ';
                                                        break;
                                                    case 'Img_perfil':
                                                        echo 'type="file" ';
                                                        break;
                                                    case 'FechaNacimiento':
                                                        $value2 = date('Y-m-d', strtotime($value));
                                                        echo 'type="date" required ' . 'value="' . $value2 . '" ';
                                                        break;
                                                    case 'Correo':
                                                        echo 'type="email" maxlength="35" ' . 'value="' . $value . ' " ';
                                                        break;
                                                    case 'Localidad':
                                                        echo 'type="hidden"  ' . 'value="' . $value . ' " ';
                                                        break;
                                                    case 'Genero':
                                                        echo 'type="hidden"  ' . 'value="' . $value . ' " ';
                                                        break;
                                                    case 'Estrato':
                                                        echo 'type="hidden"  ' . 'value="' . $value . ' " ';
                                                        break;
                                                    case 'TipoDoc':
                                                        echo 'type="hidden"  ' . 'value="' . $value . ' " ';
                                                        break;
                                                    case 'Telefono':
                                                        echo 'type="tel" maxlength="12" ' . 'value="' . $value . ' " ';
                                                        break;
                                                    default:
                                                        echo 'type="text" maxlength="35" ' . 'value="' . $value . ' " ';
                                                        break;
                                                }
                                                ?> class="form-control" style="    width: 99%;
                                                padding: 15px;
                                                border: 2px solid #4b0081;
                                                border-radius: 5px;" id="<?= $key ?>" name="<?= $key ?>">

                                    </div>

                                    <div class="form-group">
                                        <?php if ($key === 'Genero') { ?>
                                            <select class="form-control" id="<?= $key ?>" name="<?= $key ?>">
                                                <option value="1" <?php if ($value === '1') {
                                                                        echo 'selected';
                                                                    } ?>>Masculino</option>
                                                <option value="2" <?php if ($value === '2') {
                                                                        echo 'selected';
                                                                    } ?>>Femenino</option>
                                            </select>
                                        <?php }
                                        if ($key == 'Localidad') { ?>
                                            <select class="form-control" id="<?= $key ?>" name="<?= $key ?>">
                                                <?php foreach ($localidad as $keylocalidad => $valuelocalidad) { ?>
                                                    <option value="<?= $valuelocalidad['IDLocalidad'] ?>" <?php if ($value === $valuelocalidad['IDLocalidad']) {
                                                                                                                echo 'selected';
                                                                                                            } ?>>
                                                        <?= $valuelocalidad['Localidad'] ?></option>
                                                <?php } ?>
                                            </select>
                                        <?php }
                                        if ($key == 'Estrato') {  ?>
                                            <select class="form-control" id="<?= $key ?>" name="<?= $key ?>">
                                                <?php foreach ($estrato as $keylocalidad => $valuelocalidad) { ?>
                                                    <option value="<?= $valuelocalidad['IDEstrato'] ?>" <?php if ($value === $valuelocalidad['IDEstrato']) {
                                                                                                            echo 'selected';
                                                                                                        } ?>>
                                                        <?= $valuelocalidad['Estrato'] ?></option>
                                                <?php } ?>
                                            </select>
                                        <?php }
                                        if ($key == 'TipoDoc') {  ?>
                                            <select class="form-control" id="<?= $key ?>" name="<?= $key ?>">
                                                <?php foreach ($tipodoc as $keylocalidad => $valuelocalidad) { ?>
                                                    <option value="<?= $valuelocalidad['IDTipoDoc'] ?>" <?php if ($value === $valuelocalidad['IDTipoDoc']) {
                                                                                                            echo 'selected';
                                                                                                        } ?>>
                                                        <?= $valuelocalidad['TipoDocumento'] ?></option>
                                                <?php } ?>
                                            </select>
                                        <?php } ?>
                                    </div>
                                <?php  } ?>
                                <label for="quitarfoto">Restablecer foto de perfil</label>
                                <input type="checkbox" name="quitarfoto" id="quitarfoto" value="1">
                                <br>

                                <button type="submit" name="update" class="btn btn-primary">Submit</button>
                            </form>
                            <div style="border: 3px solid purple; border-radius: 5px; display: inline; float: right; font-weight:bolder; ">
                                <a href="../controller/cambiarpass.php" style="margin: 1em">cambiar contraseña</a>
                            </div>
                            <div style="border: 3px solid red; border-radius: 5px; display: inline; float: right; font-weight:bolder; ">
                                <a href="#" onclick="verificar()" style="margin: 1em">
                                    <li class="fa fa-trash"></li> Eliminar cuenta
                                </a>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>

                    </div>
                </div>
            </div>
            <?php } ?>
            <div class="perfil-usuario-footer">
                <ul class="lista-datos">
                    <li><i class="icono fas fa-home"></i>Direccion: <strong><?php echo $user['Direccion'] ?></strong> </li>
                    <li><i class="icono fas fa-phone"></i>Telefono: <strong>
                            <?php echo $user['Telefono'] ?>
                        </strong> </li>
                    <li><i class="icono fas fa-user"></i>Genero <strong>
                            <?php echo $user['Genero'] ?>
                        </strong></li>
                    <li><i class="icono fas fa-building"></i>Eps:
                        <strong>
                            <?= $user['NombreEps'] ?>
                        </strong>
                    </li>
                    <li><i class="icono fas fa-user"></i>ROL:
                        <strong>
                            <?= $user['rol'] ?>
                        </strong>
                    </li>
                </ul>
                <ul class="lista-datos">
                    <li><i class="icono fas fa-address-card"></i>Tipo de documento:
                        <strong>
                            <?= $user['TipoDocumento'] ?>
                        </strong>
                    </li>
                    <li><i class="icono fas fa-map-marker-alt"></i>Localidad:
                        <strong>
                            <?= $user['Localidad'] ?>
                        </strong>
                    </li>
                    <li><i class="icono fas fa-calendar-alt"></i>Fecha nacimiento: <strong>
                            <?php echo $user['FechaNacimiento'] ?>
                        </strong> </li>
                    <li><i class="icono fas fa-user-check"></i>Estrato:
                        <strong>
                            <?= $user['Estrato'] ?>
                        </strong>
                    </li>
                    <li><i class="icono fas fa-envelope"></i>Correo:
                        <strong>
                            <?= $user['Correo'] ?>
                        </strong>
                    </li>
                </ul>
            </div>
            <div class="redes-sociales">
                <a href="" class="boton-redes qr fas fa-qrcode"><i class=""></i></a>
                <a href="" class="boton-redes compartir fas fa-share-alt"><i class=""></i></a>
            </div>
        </div>
        <!--Fin de datos del usuario-->
        <div>
            <br>
        </div>
    </section>
    <?php if($compartido){ ?>
        <br>
        <br>
        <br>
        <br>
        <br>
    <section>
        <div class="container">
        <?php foreach ($results as $code) { ?>
            <button class="accordion">Ver codigos QR</button>
            <div class="panel">
                <br>
                <br>
            <div class="roww2">
								<div class=" text-center">
									<div class="single-product-item">
										<div class="product-image">
											<a href="<?php echo $code['RutaArchivo'] ?>" target="BLANK">
												<img src="<?php echo 'https://quickchart.io/qr?text=' . $code['RutaArchivo'] . $code['Atributo'] ?>" alt=""></a>
										</div>
                                        <div class="product-text">
                                            <h4><?php echo $code['Titulo'] ?></h4>
                                            <p><?php echo ''//$code['Descripcion'] ?></p>
                                            <a href="<?php echo $code['RutaArchivo'] ?>" target="BLANK" class="btn btn-primary">Descargar</a>
                                        </div>
                                    </div>
                                </div>
            </div>
            </div>
            <style>
        .accordion {
        background-color: #eee;
        color: #444;
        cursor: pointer;
        padding: 18px;
        width: 100%;
        border: none;
        text-align: left;
        outline: none;
        font-size: 15px;
        transition: 0.4s;
        }

        .active, .accordion:hover {
        background-color: #ccc;
        }

        .accordion:after {
        content: '\002B';
        color: #777;
        font-weight: bold;
        float: right;
        margin-left: 5px;
        }

        .active:after {
        content: "\2212";
        }

        .panel {
        padding: 0 18px;
        background-color: white;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.2s ease-out;
        }
        </styl>
</style>
        <?php } ?>
        </div>
    </section>
    <?php } ?>
    <!--soluión temporal ante problema de footer-->
    <div>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
    </div>
    <!--Fin de la solución temporal ante prblema de footer-->

    <!--Footer-->
    <!-- copyright -->
    <?php
    include('./templates/footer_copyrights.php');
    ?>
    <!-- end copyright -->
    <!--Footer Ends-->

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
    <script>
        var acc = document.getElementsByClassName("accordion");
        var i;

        for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.maxHeight) {
            panel.style.maxHeight = null;
            } else {
            panel.style.maxHeight = panel.scrollHeight + "px";
            } 
        });
        }
        function verificar() {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Esta seguro de eliminar su cuenta?',
                text: "Perdera todos sus datos, no podra recuperarlos, realize una copia de seguridad antes de eliminar su cuenta!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'si, Eliminarla!',
                cancelButtonText: 'No, cancelar!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    swalWithBootstrapButtons.fire(
                        'Deleted!',
                        'Su cuenta ha sido eliminada',
                        'success'
                    );
                    <?php $datos = '?Ndocumento=' . $user['Ndocumento'] . '&token=' . $user['token_reset']; ?>
                    setTimeout(() => {
                        window.location.href = `../controller/eliminar.php<?= $datos ?>`;
                    }, 2000);
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelado',
                        'Su cuenta no ha sido eliminada',
                        'error'
                    )
                }
            })
        }
        <?php if($compartido){ ?>
            Swal.fire({
                icon: 'warning',
                title: 'Vista de perfil de otro usuario',
                text: 'Usted esta viendo el perfil de otro usuario, no podra realizar cambios',
                footer: '<a href>Why do I have this issue?</a>'
            })
        <?php } ?>
    </script>
</body>

</html>