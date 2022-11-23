<?php
$Ndocumento= $_GET['id'];
require('../../main.php');
require_once(BaseDir.'/models/database/database.php');

//$conexion= mysqli_connect("localhost", "root", "", "id16455213_secode_qr");
//$resultado = mysqli_query($conexion, $consulta);
//$usuario = mysqli_fetch_assoc($resultado);
$consulta= "SELECT * FROM usuario WHERE Ndocumento = :documento";
$param=$connection->prepare($consulta);
$param->bindParam(':documento', $Ndocumento);
$param->execute();
$usuario = $param->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion SECODE</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/es.css">
    <link rel="stylesheet" href="../css/fontawesome.css">
    <script src="https://kit.fontawesome.com/9165abed33.js" crossorigin="anonymous"></script>
</head>

<body id="page-top">
<nav class="main-navbar">
        <ul class="navbar-container">
            <li class="logo" style="margin-top: -4px;">
                <a href="../views/tablero.php" class="navbar-link">
                <img src="../img/logito.svg" style="width:50px; margin-right:-10px;">
                    <span class="link-text" style="font-weight:500;">SECODE_QR</span>
                </a>
            </li>
            <li class="navbar-item">
                <a href="../views/tablero.php" class="navbar-link">
                <svg aria-hidden="true" focusable="false" data-prefix="fab" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="fa-primary" role="img" style="width:20px; margin-top:-40px;">
                    <path d="M0 96C0 60.7 28.7 32 64 32H448c35.3 0 64 28.7 64 64V416c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V96zm64 64V416H224V160H64zm384 0H288V416H448V160z"/></svg>
                    <span class="link-text" style="margin-top:-40px;" >Tablero Gestión</span>
                </a>
            </li>
            <li class="navbar-item">
                <a href="../views/registraru.php" class="navbar-link">
                <svg aria-hidden="true" focusable="false" data-prefix="fab" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" style="width:20px;  margin-top:-40px;">
                    <path d="M352 128c0 70.7-57.3 128-128 128s-128-57.3-128-128S153.3 0 224 0s128 57.3 128 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"/></svg>
                    <span class="link-text" style="margin-top:-40px;" >Registrar</span>
                </a>
            </li>
            <li class="navbar-item">
                <a href="#" class="navbar-link">
                <svg  aria-hidden="true" focusable="false" data-prefix="fab" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="fa-primary" role="img" style="width:17px;  margin-top:-40px;">
                    <path d="M96 0C43 0 0 43 0 96V416c0 53 43 96 96 96H384h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V384c17.7 0 32-14.3 32-32V32c0-17.7-14.3-32-32-32H384 96zm0 384H352v64H96c-17.7 0-32-14.3-32-32s14.3-32 32-32zm32-240c0-8.8 7.2-16 16-16H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16zm16 48H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/></svg>
                    </svg>
                    <span class="link-text" style="margin-top:-40px;" >Manual uso</span>
                </a>
            </li>
            <li class="navbar-item">
                <a href="#" class="navbar-link">
                <svg  aria-hidden="true" focusable="false" data-prefix="fab"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="fa-primary" role="img" style="width:20px;  margin-top:-40px;">
                    <path d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0S96 57.3 96 128s57.3 128 128 128zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"/></svg>
                    <span class="link-text" style="margin-top:-40px;" >Perfil</span>
                </a>
            </li>
            <li class="navbar-item">
                <a href="#" class="navbar-link">
                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="power-off" class="fa-primary"
                        role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width:20px;  margin-top:-50px;">
                        <path fill="currentColor"
                            d="M400 54.1c63 45 104 118.6 104 201.9 0 136.8-110.8 247.7-247.5 248C120 504.3 8.2 393 8 256.4 7.9 173.1 48.9 99.3 111.8 54.2c11.7-8.3 28-4.8 35 7.7L162.6 90c5.9 10.5 3.1 23.8-6.6 31-41.5 30.8-68 79.6-68 134.9-.1 92.3 74.5 168.1 168 168.1 91.6 0 168.6-74.2 168-169.1-.3-51.8-24.7-101.8-68.1-134-9.7-7.2-12.4-20.5-6.5-30.9l15.8-28.1c7-12.4 23.2-16.1 34.8-7.8zM296 264V24c0-13.3-10.7-24-24-24h-32c-13.3 0-24 10.7-24 24v240c0 13.3 10.7 24 24 24h32c13.3 0 24-10.7 24-24z">
                        </path>
                    </svg>
                    <span class="link-text" style="margin-top:-50px;" >Cerrar sesión</span>
                </a>
            </li>
        </ul>
    </nav>
    
    <img src="../img/SECODE_QR.png" style="margin-left:550px;">
    <hr class="hr" style="margin-left:120px;">


    <form action="../includes/funcion.php" method="POST">
            <div class="card-3d-wrap mx-auto">
            <div class="card-front">
                <div class="center-wrap">
                    <h4 class="mb-4 pb-3">Edidar Datos De Usuario</h4>
                    <div class="form-group">
                        <input class="form-style" type="text" id="Ndocumento" name="Ndocumento"   value ="<?php echo $usuario["Ndocumento"]; ?>"required>
                        <i class="input-icon fas fa-regular fa-id-card-clip"></i>
                    </div>
                    <div class="form-group mt-2">
                        <input class="form-style" type="text" id="Nombre" name="Nombre"  placeholder="Nombres de usuario" value ="<?php echo $usuario["Nombre"]; ?>"required>
                        <i class="input-icon fas fa-user"></i>
                    </div>
                    <div class="form-group mt-2">
                        <input class="form-style" type="text" id="Direccion" name="Direccion"   placeholder="Direccion" value ="<?php echo $usuario["Direccion"]; ?>"required>
                        <i class="input-icon fas fa-regular fa-location-dot"></i>
                    </div>
                    <div class="form-group mt-2">
                        <input class="form-style" type="text" id="Genero" name="Genero"   placeholder="Genero usuario" value ="<?php echo $usuario["Genero"]; ?>"required>
                        <i class="input-icon fas fa-solid fa-venus-mars"></i>
                    </div>
                    <div class="form-group mt-2">
                        <input class="form-style" type="email" id="Correo" name="Correo"   placeholder="Correo usuario" value ="<?php echo $usuario["Correo"]; ?>"required>
                        <i class="input-icon fas fa-at"></i>
                    </div>
                    <div class="form-group mt-2">
                        <input class="form-style" type="date" id="FechaNacimiento" name="FechaNacimiento"   placeholder="Fecha de nacimiento usuario" value ="<?php echo $usuario["FechaNacimiento"]; ?>"required>
                        <i class="input-icon fas fa-solid fa-calendar-days"></i>
                    </div>
                    <div class="form-group mt-2">
                        <input class="form-style" type="Telefono" name="Telefono" id="Telefono"   placeholder="Telefono" value ="<?php echo $usuario["Telefono"]; ?>"required>
                        <input type="hidden" name="accion" value = "editar_registro">
                        <i class="input-icon fas fa-phone"></i>
                    </div>
                    <div class="boton">
                        <div class="btn"><button type="submit" >Editar Datos</button></div>
                        <div class="btn"><a href="tablero.php">Cancelar</a></div>
                    </div>
                </div>
            </div>
        </div>
    </form>
               
</body>
</html>