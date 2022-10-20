<?php



    if(strlen($_POST['Ndocumento'])>=1 && strlen($_POST['Nombre'])>=1 && strlen($_POST['Direccion'])>=1
     && strlen($_POST['Genero'])>=1 && strlen($_POST['Correo'])>=1  && strlen($_POST['FechaNacimiento'])>=1 && strlen($_POST['Telefono'])>=1){

        $Ndocumento = $_POST['Ndocumento'];
        $Nombre = $_POST['Nombre'];
        $Direccion = $_POST['Direccion'];
        $Genero = $_POST['Genero'];
        $Correo = $_POST['Correo'];
        $FechaNacimiento = $_POST['FechaNacimiento'];
        $Telefono = $_POST['Telefono'];
       
        $consulta="INSERT INTO usuario (Ndocumento, Nombre, Direccion, Genero, Correo, FechaNacimiento, Telefono) VALUES ('$Ndocumento','$Nombre','$Direccion','$Genero','$Correo','$FechaNacimiento','$Telefono')";
        $server = 'localhost';
        $username = 'root';
        $password = '';
        $database = 'id16455213_secode_qr';
        $conexion = mysqli_connect($server,$username,$password,$database);
        mysqli_query($conexion, $consulta);
        mysqli_close($conexion);

        header('location: ../views/tablero.php');
     }else
       {
         echo "Error";
       } 
?>