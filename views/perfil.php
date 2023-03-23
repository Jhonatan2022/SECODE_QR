<!--Conexión base de datos-->
<?php
session_start(); # init the session user if exist

require_once '../models/database/database.php';
//require_once '../controller/userController.php';
require_once '../models/user.php'; # import the fucntions of user

#
# firts validation, if the profile is shared by the owner user
#

if (/* !isset($_SESSION['user_id']) &&  */isset($_GET['compartir']) && filter_var($_GET['compartir'], FILTER_VALIDATE_INT ) ) {

    #verify if the url shared is asociate to an user 

    $query = $connection->prepare("SELECT * FROM usuario WHERE CompartirUrl = :compartir");
    $query->bindParam(':compartir', $_GET['compartir']);
    $query->execute();
    $userperfil = $query->fetch(PDO::FETCH_ASSOC);          # save the result into varible
    $suscripcion=getSuscription($userperfil['Ndocumento']); # get the suscription of user 
    
    ## validate the permissions of share Profile 

    if($suscripcion['CompartirPerfil']=='NO'|| $userperfil['Compartido']!=1 || $userperfil <1){
        header('Location: ./index.php'); # if not return to the init page
        exit;
    }
    
    # if is validate the permissions we declarate variables for the view
    #

    $roluser = $userperfil;                             # all data from user
    $user=getUserData($userperfil['Ndocumento']);       # equal variable 
    $userForm = userform($userperfil['Ndocumento']);    # data visible for the interface of user
    $localidad = localidad();   ## variable localidad
    $tipodoc = tipoDocumento(); ## documnet type
    $estrato = estrato();       ## Estrato

    if(isset($_SESSION['user_id'])){                    # if exixs an user with started session 
        $SessionUser = getUser($_SESSION['user_id']);   # save his data in a varible 
    }

    $queryQR=$connection->prepare("SELECT * FROM codigo_qr WHERE Ndocumento = :id AND Privacidad = 1");
    $queryQR->bindParam(':id', $user['Ndocumento']);    #Consult to DB searching the codes QR's with 
    $queryQR->execute();                                #Privacy in mode public
    $results= $queryQR->fetchAll(PDO::FETCH_ASSOC);     #save ALL the results in a varible

    $compartido=true;       # Set the varible status in mode true.
}elseif(isset($_SESSION['user_id']) && !isset($_GET['compartir'])){         # if the user is in his profile without share 
    $roluser = getUser($_SESSION['user_id']);               #Set the varibles with the info of session user
    $suscripcion = getSuscription($_SESSION['user_id']);    #Set the varible suscription

if (isset($_REQUEST['update'])) {     #we validate, is there a try to update data in the form user

    $id_us = $_SESSION["user_id"];                  #
    $nombre = ucwords( $_POST["Nombre"]);           # we save the values that we recive by POST method
    $direccion = $_POST["Direccion"];               #if exixst
    $genero = $_POST["Genero"];                     #
    $correo = $_POST["Correo"];                     #
    $fechaNacimiento = $_POST["FechaNacimiento"];   #
    $telefono = $_POST["Telefono"];                 #
    $Apellidos = ucwords( $_POST["Apellidos"]);     #
    $Localidad = $_POST["Localidad"];
    $Estrato = $_POST["Estrato"];
    $TipoDoc = $_POST["TipoDoc"];
    
    if($correo!=$roluser['Correo']){
        $verificado= 0;
    }else{
        $verificado= $roluser['Verificado'];
    }

    $sql = "SELECT COUNT(us.Correo) FROM usuario AS us WHERE us.Correo =:correo AND us.Ndocumento != :id";
    $query = $connection->prepare($sql);    #we validate that the email had not been registed in DB
    $query->bindParam(':correo', $correo);  #
    $query->bindParam(':id', $id_us);       #
    $query->execute();                      #exucute the consult
    $count = $query->fetchColumn();         #save the results ina a varible
    if ($count > 0) {           # we compare the varible is not mayor like 0
        $message = ['error', "Correo ya registrado por otro usuario, intente de nuevo", 'error'];   # return the message 
    } else {        # if all is correct

        if (                                # we cerify the values of POST aren't empty
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
            $fechaNacimiento = date("Y-m-d", strtotime($fechaNacimiento)); #we convert the date 
            if (isset($_FILES['Img_perfil']) && $_FILES['Img_perfil']['error'] == UPLOAD_ERR_OK) {
                #
                #if the user send a file to update the profile image 
                #types of files permited
                $permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png", "image/pneg");
                $limite_kb = 1000; //10 mb maximo tamaño archivo

                if ((in_array($_FILES['Img_perfil']['type'], $permitidos) && $_FILES['Img_perfil']['size'] <= $limite_kb * 1024)) {
                    #we validate the params
                    $tipoArchivo = $_FILES["Img_perfil"]["type"];   #the file type
                    $tamanoArchivo = $_FILES["Img_perfil"]["size"]; #the size of the file

                    $imagenSubida = fopen($_FILES["Img_perfil"]["tmp_name"], "r");
                    $binariosImagen = fread($imagenSubida, $tamanoArchivo);
                    //$binariosImagen = PDO::quote($binariosImagen,);
                    $img = $binariosImagen;         #img in bynaru mode to send to DB

                    #consult to Db for update the data
                    $sql = "UPDATE usuario SET Img_perfil = :img , TipoImg = :tipo,
                Nombre = :nombre, Direccion = :direccion, Genero = :genero, Correo = :correo, FechaNacimiento = :fechaNacimiento, Telefono = :telefono, Apellidos = :apellidos, Localidad = :localidad, Estrato = :estrato, TipoDoc = :tipodoc, Verificado = :verificado
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
                    $query->bindParam(':verificado', $verificado);

                    if ($query->execute()) {    #if all correct return the message
                        $message = ['Actualización exitosa', 'Los datos se han actualizado correctamente', 'success'];
                    }
                } else {    #return bad message 
                    $message = ['error', "Archivo no permitido, es tipo de archivo prohibido o excede el tamano de $limite_kb Kilobytes", 'error'];
                }
            } else {    #if not exixst the file to upload
                if (isset($_POST['quitarfoto'])) { #if the user want to quit his image profile
                    $sql = "UPDATE usuario SET Img_perfil = null , TipoImg = null WHERE Ndocumento = :id";
                    $query2 = $connection->prepare($sql);
                    $query2->bindParam(':id', $id_us);
                    $query2->execute();
                }
                #create consulto update data without file upload
                $sql = "UPDATE usuario SET 
                Nombre = :nombre, Direccion = :direccion, Genero = :genero, Correo = :correo, FechaNacimiento = :fechaNacimiento, Telefono = :telefono, Apellidos = :apellidos, Localidad = :localidad, Estrato = :estrato, TipoDoc = :tipodoc, Verificado = :verificado
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
                $query->bindParam(':verificado', $verificado);
                if ($query->execute()) {    #return message
                    $message = ['Actualización exitosa', 'Los datos se han actualizado correctamente', 'success'];
                }
            }
        }
    }
}
verifyDateExpiration($_SESSION['user_id']); #we execute te function to validate the expiration time to the suscription user
$user = getUserData($_SESSION['user_id']);  #set user data
$userForm = userform($_SESSION['user_id']); #set user form
$localidad = localidad();
$tipodoc = tipoDocumento();
$estrato = estrato();
$compartido=false;      ## Set the varible status in mode false.
}else{
    header('Location: ./index.php'); #if the user aren't log in, return to index page
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
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
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
                <div style="line-height: 0; margin-top:35px;" class="titulo">
                <h3><?= $user['Nombre'] . ' ' . $user['Apellidos'] ?></h3>
                <?php if(! $compartido){ ?> 
                    <!-- if the profile aren't in shared mode -->
                    <div style=" margin-top:3rem">
                    <a data-toggle="modal" data-target="#myModal" class="boton-edit">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    <label for="" style="font-size: 18px;">Editar Datos</label>
                    <br>
                    <?php if ( ! $compartido && $suscripcion['CompartirPerfil'] == "SI" ) { ?>
                    <a data-toggle="modal" data-target="#myModalPerfil" class="boton-edit" >
                    <i class="fas fa-user-alt"></i></a>
                    <label for="" style="font-size: 18px;">Compartir Perfil</label>
                    <?php } ?>
                    <?php if($roluser['Verificado'] != 1 && ! $compartido){ ?>
                    <div class="flex-items">
                        <a href="##"  id="btnVerificarEmail" style="font-size:15px ; position:absolute; right:2rem ; top:7.5rem; border:3px solid purple; border-radius:5px; padding:15px" >VERIFICAR CUENTA</a>
                    </div>
                    <?php } ?>
                    </div>                     
                <?php } ?>
                </div>
                <div class="flex-container" style="display: flex;flex-direction: column;flex-wrap: wrap;justify-content: center;align-items: center;align-content: center; margin-top:2rem">
                    <?php if ($roluser['rol'] == 2 && ! $compartido) { 
                        ## if the user is an administrator 
                        echo '<div class="admin_div"><a href="../admin/views/tablero.php">Tablero de gestion  </a></div>';
                    } ?>
                    <div class="flex-items">
                        Descripcion
                    </div>
                    <?php if ( ! $compartido && $suscripcion['CompartirPerfil'] == "SI" ) { ?>
                        <!-- if the user have permissions to share his profile  -->
                        
                         <div class="modal" id="myModalPerfil"><!-- modal of options share profile; default hidden -->
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
                                                <!-- input to check the option, it is validate to db status; when click execute a fucntion to activate o deactivate -->
                                                <?php if($roluser['Compartido']==1){?>
                                                    <!-- if the profile is shared we display the data to share -->
                                                <div id="contperfil"  >
                                                    <a href="<?= 'http://' . $_SERVER['HTTP_HOST'] . '/secodeqr/views/perfil.php?compartir=' . $roluser['CompartirUrl'] . '&tipo=usuario' ?>" target="_blank">
                                                        <?= 'http://' . $_SERVER['HTTP_HOST'] . '/secodeqr/views/perfil.php?compartir=' . $roluser['CompartirUrl'] . '&tipo=usuario' ?>
                                                    </a>
                                                    <!-- link to share -->
                                                    <br>
                                                    <a href="<?= 'http://' . $_SERVER['HTTP_HOST'] . '/secodeqr/views/perfil.php?compartir=' . $roluser['CompartirUrl'] . '&tipo=usuario' ?>" target="_blank">
                                                        <img src="<?= 'https://quickchart.io/qr?text=' .'http://' . $_SERVER['HTTP_HOST'] . '/secodeqr/views/perfil.php?compartir=' . $roluser['CompartirUrl'] . '&tipo=usuario'.'&centerImageUrl=https://programacion3luis.000webhostapp.com/secode/views/assets/img/logo.png&size=300&ecLevel=H&centerImageWidth=120&centerImageHeight=120' ?>" alt="">
                                                    </a>
                                                    <!-- image to share -->
                                                </div>
                                                <?php }?>
                                            </form>
                                            <script>
                                                function recordatorio() {
                                                    <?php if ($roluser['Compartido'] == 1) { ?>
                                                        //if in the db the status is shared; activated
                                                        Swal.fire({
                                                            title: 'Desactivar compartir perfil',
                                                            text: "Esta opción le permite desactivar la opción de compartir su perfil con otras personas, ¿Desea continuar?",
                                                            icon: 'warning',
                                                            showCancelButton: true,
                                                            confirmButtonColor: '#3085d6',
                                                            cancelButtonColor: '#d33',
                                                            confirmButtonText: 'Si, desactivar!'
                                                        }) <?php } else { ?>
                                                            // if in the DB the status is disabled;
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
                                                            //save de varible input checkbox
                                                            if (result.isConfirmed) {
                                                                $.ajax({                                    //send the data with ajax
                                                                    url: '../controller/compartirp.php',    //file to send
                                                                    type: 'POST',                           //method
                                                                    data: {                                 // data to send
                                                                        id: 1,
                                                                        compartir: <?= $roluser['Compartido'] ?>    //status bd
                                                                    },
                                                                    success: function(data) {
                                                                        if (data == 1) {    //if the result = 1
                                                                            Swal.fire(
                                                                                'Cambios actualizados',
                                                                                'Sus cambios han sido actualizados',
                                                                                'success'
                                                                            )
                                                                            setTimeout(function() {
                                                                                window.location.reload();   //reload the page after 1.5 segs
                                                                            }, 1600);
                                                                        } else {                            //if have an error
                                                                            Swal.fire(
                                                                                'Cambios  no actualizados',
                                                                                'Sus cambios no han sido actualizados' + data,
                                                                                'error'
                                                                            )
                                                                        }
                                                                    }
                                                                })
                                                            }else{      // if the operation is canceled
                                                                if (CompartirPerfil.checked) {
                                                                    CompartirPerfil.checked = false;    //return the values to original status
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
                    <?php if($roluser['Verificado'] != 1 && ! $compartido){ ?>
                        <!-- if the user have not verified his email -->
                    
                    <script>
                        var btnVerificarEmail = document.getElementById("btnVerificarEmail");
                        btnVerificarEmail.addEventListener("click", function() {
                            Swal.fire({
                                title: 'Verificar cuenta',
                                text: "Esta opción le permite verificar su cuenta,mediante correo electronico ¿Desea continuar?",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Si, verificar!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $.ajax({
                                        url: '../controller/verificar.php',
                                        type: 'POST',
                                        data: {
                                            verificar: 1
                                        },
                                        success: function(data) {
                                            if (data == 1) {
                                                Swal.fire(
                                                    'Correo de verificacion enviado',
                                                    'Por favor revise su bandeja de entrada, si no encuentra el correo revise su bandeja de spam',
                                                    'success'
                                                )
                                            } else {
                                                Swal.fire(
                                                    'ocurrio un error',
                                                    'error: ' + data,
                                                    'error'
                                                )
                                            }
                                        }
                                    })
                                }
                            })
                        });
                    </script>
                    <?php } ?>
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
                            <div style="border: 3px solid purple; border-radius: 5px; display: inline; float: right; font-weight:bolder; margin:8px ">
                                <a href="../controller/cambiarpass.php" style="margin: 1em">
                                <li class="fa fa-key"></li> Cambiar contraseña</a>
                            </div>
                            <div style="border: 3px solid red; border-radius: 5px; display: inline; float: right; font-weight:bolder;margin:8px  ">
                                <a href="##" onclick="verificar()" style="margin: 1em">
                                    <li class="fa fa-trash"></li> Eliminar cuenta
                                </a>
                            </div>
                            <?php if ($suscripcion['precio'] != 0){ ?>
                            <div style="border: 3px solid red; border-radius: 5px; display: inline; float: right; font-weight:bolder; margin:8x ">
                                <a href="##" onclick="borrarsus()" style="margin: 1em">
                                    <li class="fas fa-credit-card"></li> Eliminar suscripcion
                                </a>
                            </div>
                            <?php } ?>
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
            <button class="accordion" >Enviar mensaje a <?php echo $user['Nombre'] ?></button>
            <div class="panel">
                <div class="col-lg-5">
        <div class="contact-wrap w-100 p-md-5 p-4">
            <h3 class="mb-4">Get in touch</h3>
            <form method="POST" id="contactForm" name="contactForm" novalidate="novalidate" >
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" maxlength="45">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <textarea name="message" class="form-control" id="message" cols="30" rows="5"
                                placeholder="Message" maxlength="70"></textarea>
                        </div>
                    </div>
                    <input type="hidden" id="emailTo" name="emailTo" value="<?=$user['Correo']?>">
                    <div class="col-md-12">
                        <div class="form-group">
                            <?php if(isset($_SESSION['user_id']) && $suscripcion['EnviarMensaje']=='SI' && $SessionUser['Verificado']==1){ ?>
                                <a href="#" id="btnEnviarMensage" class="button bg-succes fas fa-user" style=" border:3px solid purple; border-radius:5px; padding:5px">
                                    Enviar mensaje
                                </a>
                                <script>
                                    var btnEnviarMensage = document.getElementById('btnEnviarMensage');
                                    var subject = document.getElementById('subject');
                                    var message = document.getElementById('message');
                                    var emailTo = document.getElementById('emailTo').value;
                                    btnEnviarMensage.addEventListener('click', function(){
                                        if(subject.value == '' || message.value == ''){
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Oops...',
                                                text: 'Por favor llena todos los campos!',
                                            })
                                        }else{
                                            $.ajax({
                                                url: '../controller/sendmsg.php',
                                                type: 'POST',
                                                data: {
                                                    subject: subject.value,
                                                    message: message.value,
                                                    emailTo: emailTo
                                                },
                                                success: function(data){
                                                    if(data == 'success'){
                                                        Swal.fire({
                                                            icon: 'success',
                                                            title: 'Mensaje enviado',
                                                            text: 'El mensaje se envio correctamente',
                                                        })
                                                        setTimeout(function(){
                                                            location.reload();
                                                        }, 1500);
                                                    }else{
                                                        Swal.fire({
                                                            icon: 'error',
                                                            title: 'Oops...',
                                                            text: 'Algo salio mal! '+data,
                                                        })
                                                    }
                                                }
                                            });
                                        }
                                    });
                                </script>
                                <?php }elseif(! isset($_SESSION['user_id'])){?>
                                    <a href="iniciar.php" class="button bg-succes fas fa-user" style=" border:3px solid purple; border-radius:5px; padding:5px">
                                     INICIAR SESION</a>
                                <?php }elseif($SessionUser['Verificado']!=1){ ?>
                                    <a href="##" class="button bg-succes fas fa-user" style=" border:3px solid purple; border-radius:5px; padding:5px; cursor:not-allowed">
                                     Enviar mensaje</a>
                                     <h5 style="color:tomato">Por favor primero verifica tu cuenta. ✅ Y Actualiza tu Membresia 🎁 </h5>
                               <?php }else{ ?>
                                    <a href="##" class="button bg-succes fas fa-envelope" style=" border:3px solid purple; border-radius:5px; padding:5px; cursor:not-allowed">
                                     Enviar </a>
                                        <h5 style="color:tomato">Por favor Actualiza tu Membresia 🎁</h5>
                                <?php } ?>
                            
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
            </div>
            <br>
            <button class="accordion">Ver codigos QR</button>
            <div class="panel">
                <br>
                <br>
                <?php foreach ($results as $code) { ?>
                <!-- for each -->
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
            <?php } ?>
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
        </style>
</style>
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
        function borrarsus(){
            Swal.fire({
                title: 'Esta seguro de eliminar su suscripcion?',
                text: "NO se podra recuperar su suscripcion, y las funciones de su plan se desactivaran, no se dara ningun reembolso!  . NO perdera sus datos, solo su suscripcion",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'si, Eliminarla!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '../controller/eliminarSuscripcion.php',
                        type: 'POST',
                        data: {id: <?= $user['Ndocumento'] ?>},
                        success: function(data){
                            if (data == 1) {
                                Swal.fire(
                                    'Deleted!',
                                    'Su suscripcion ha sido eliminada',
                                    'success'
                                )
                                setTimeout(function(){
                                    location.reload();
                                }, 2000);
                            }else{
                                Swal.fire(
                                    'Error!',
                                    'No se pudo eliminar su suscripcion'+data,
                                    'error'
                                )
                            }
                        }
                    })

                    Swal.fire(
                    'Deleted!',
                    'Su cuenta ha sido eliminada',
                    'success'
                    )
                }
            })
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