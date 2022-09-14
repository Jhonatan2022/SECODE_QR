<?php

require_once ("../includes/bd.php");

if (isset($_POST['accion'])){
    switch($_POST['accion']){
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


function editar_registro() {
    $conexion = mysqli_connect("localhost","root","","id16455213_secode_qr");
    extract($_POST);
    $consulta="UPDATE usuario SET Ndocumento = '$Ndocumento', Nombre = '$Nombre', Direccion = '$Direccion',
    Genero ='$Genero', Correo = '$Correo' , FechaNacimiento = '$FechaNacimiento' , Telefono = '$Telefono'  WHERE Ndocumento = '$Ndocumento'";

    mysqli_query($conexion, $consulta);
    header('Location: ../views/tablero.php');

}

function eliminar_registro() {
    $conexion = mysqli_connect("localhost","root","","id16455213_secode_qr");
    extract($_POST);
    $Ndocumento= $_POST['Ndocumento'];
    $consulta= "DELETE FROM usuario WHERE Ndocumento= $Ndocumento";
    mysqli_query($conexion, $consulta);

    header('Location: ../views/tablero.php');

}

function acceso_user() {
    $Ndocumento=$_POST['Ndocumento'];
    $Contrasena=$_POST['Contrasena'];
    session_start();
    $_SESSION['Ndocumento']=$Ndocumento;

    $conexion=mysqli_connect("localhost","root","","id16455213_secode_qr");
    $consulta= "SELECT * FROM usuario WHERE Ndocumento='$Ndocumento' AND Contrasena='$Contrasena'";
    $resultado=mysqli_query($conexion, $consulta);
    $filas= mysqli_num_rows($resultado);


    if($filas){

        header('Location: ../views/tablero.php');

    }else {
        header('Location: ../includes/login1.php');
        session_destroy();
    }


  
}