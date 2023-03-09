<?php 
    $mysqli = new mysqli ("localhost", "root", "", "finalsecode");

    $salida ="";
    $query ="SELECT * FROM usuario ORDER BY Ndocumento";
    
    if(isset ($_POST['consulta'])){
        $q = $mysqli -> real_escape_string($_POST['consulta']);
        $query = "SELECT Ndocumento, TipoDoc, Nombre, Apellidos, Correo, Direccion, Localidad, Genero, Estrato, Rol, FechaNacimiento, Telefono
        FROM usuario WHERE Nombre LIKE '%".$q."%' OR Apellidos  LIKE '%".$q."%' OR Correo  LIKE '%".$q."%' OR Direccion  LIKE '%".$q."%' OR Localidad  LIKE '%".$q."%' OR Genero  LIKE '%".$q."%'
        OR Estrato  LIKE '%".$q."%' OR Rol  LIKE '%".$q."%' OR FechaNacimiento  LIKE '%".$q."%' OR Telefono  LIKE '%".$q."%'";

    }

    $resultado = $mysqli->query($query);

    if ($resultado ->num_rows > 0){

    }else{
        
    }


?>