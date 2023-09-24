<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    http_response_code(404);
    header('Location: ../../index.php');
}
require_once('../config.php');
require_once('../../main.php');
require_once(BaseDir . '/models/database/database.php');
require_once('../../models/user.php');
$records = $connection->prepare('SELECT Ndocumento,Img_perfil, TipoImg,Nombre,rol FROM usuario WHERE Ndocumento = :id ');
$records->bindParam(':id', $_SESSION['user_id']);
if ($records->execute()) {
    $resultsUser = $records->fetch(PDO::FETCH_ASSOC);
} else {
    $message = array(' Error', 'Ocurrio un error en la consulta datos user. intente de nuevo.', 'error');
}
if ($resultsUser['rol'] == 2) {
    if (isset($_POST['accion'])) {
        switch ($_POST['accion']) {
            case 'editar_registro':
                editar_registro();
                break;
            case 'eliminar_registro':
                eliminar_registro();
                break;
            case 'acceso_user';
                acceso_user();
                break;
        }
    }
} else {
    http_response_code(404);
    header('Location: ../../index.php');
}
function editar_registro()
{
    $server = DB_SERVER;
    $username = DB_USERNAME;
    $password = DB_PASSWORD;
    $database = DB_NAME;
    $conexion = mysqli_connect($server, $username, $password, $database);
    extract($_POST);
    $consulta = "UPDATE usuario SET Ndocumento = '$Ndocumento', Nombre = '$Nombre', Direccion = '$Direccion',
    Genero ='$Genero', Correo = '$Correo' , FechaNacimiento = '$FechaNacimiento' , Telefono = '$Telefono', rol = '$rol'  WHERE Ndocumento = '$Ndocumento'";
    if (mysqli_query($conexion, $consulta)) {
        header('Location: ../views/tablero.php?estado=1');
    } else {
        header('Location: ../views/tablero.php?estado=2');
    }
}
function eliminar_registro()
{
    global $connection;
    for ($i = 1; $i < 3; $i++) {
        if (getQR($_POST['Ndocumento']) != 0) {
            $del = 'codigo_qr';
        }
        $query = $connection->prepare('DELETE FROM ' . $del . ' WHERE Ndocumento = ' . $_POST['Ndocumento']);
        $query->execute();
    }
    $form = getFormula($_POST['Ndocumento']);
    foreach ($form as $key) {
        unlink('../../models/img/' . $key['ArchivoFormulaMedica']);
    }
    $query = $connection->prepare('DELETE FROM FormularioMedicamentos WHERE Ndocumento = :id');
    $query->bindParam(':id', $_POST['Ndocumento']);
    $query->execute();
    $query = $connection->prepare('DELETE FROM Suscripcion WHERE Ndocumento = :id');
    $query->bindParam(':id', $_POST['Ndocumento']);
    $query->execute();
    $query = $connection->prepare('DELETE FROM datos_clinicos WHERE Ndocumento = :id');
    $query->bindParam(':id', $_POST['Ndocumento']);
    $query->execute();
    $query = $connection->prepare('DELETE FROM usuario WHERE Ndocumento = :id');
    $query->bindParam(':id', $_POST['Ndocumento']);
    $query->execute();
    header('Location: ../views/tablero.php');
}
function acceso_user()
{
    $server = DB_SERVER;
    $username = DB_USERNAME;
    $password = DB_PASSWORD;
    $database = DB_NAME;
    $Ndocumento = $_POST['Ndocumento'];
    $Contrasena = $_POST['Contrasena'];
    session_start();
    $_SESSION['Ndocumento'] = $Ndocumento;
    $conexion = mysqli_connect($server, $username, $password, $database);
    $consulta = "SELECT * FROM usuario WHERE Ndocumento='$Ndocumento' AND Contrasena='$Contrasena'";
    $resultado = mysqli_query($conexion, $consulta);
    $filas = mysqli_num_rows($resultado);
    if ($filas) {
        header('Location: ../views/tablero.php');
    } else {
        header('Location: ../includes/login1.php');
        session_destroy();
    }
}