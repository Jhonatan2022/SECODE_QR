<?php



require_once '../models/database/database.php';

function getUser($id   ) {
    global $connection;
    $query = $connection->prepare('SELECT * FROM usuario WHERE Ndocumento = :id');
    $query->bindParam(':id', $id);
    $query->execute();
    $user = $query->fetch(PDO::FETCH_ASSOC);
    if (empty($user['Img_perfil']) || $user['Img_perfil'] == null) {
      $user['Img_perfil'] = "http://" . $_SERVER['HTTP_HOST'] . "/secodeqr/views/assets/img/userimg.png";
    } else {
      $user['Img_perfil'] = 'data:' . $user['TipoImg'] . ";base64," . base64_encode($user['Img_perfil']);
    }
    
    return $user;
    
}

function getClinicData($id,$isnew) {
  global $connection;
  if(!$isnew){
    $query = $connection->prepare('SELECT us.Nombre, us.FechaNacimiento, us.Genero,us.Telefono, us.Correo, us.id, dta.TipoAfiliacion,dta.RH, dta.Tipo_de_sangre , cd.Condicion
    FROM usuario AS us 
    INNER JOIN datos_clinicos AS dta
    INNER JOIN condicion as cd
      ON cd.Id_datos_clinicos = dta.Id_datos_clinicos and
        us.Ndocumento = :id');
    $query->bindParam(':id', $id);
    $query->execute();
    $data = $query->fetch(PDO::FETCH_ASSOC);
  }else{
    $query = $connection->prepare('SELECT us.Nombre, us.FechaNacimiento, eps.NombreEps, us.Telefono , us.Correo, us.Genero,dta.TipoAfiliacion,dta.RH, dta.Tipo_de_sangre
    FROM usuario AS us LEFT OUTER JOIN eps 
    ON eps.id = us.id 
    LEFT OUTER JOIN datos_clinicos AS dta
    ON us.Ndocumento= dta.NdocumentoUser
    WHERE us.Ndocumento =:id');
    $query->bindParam(':id', $id);
    $query->execute();
    $data = $query->fetch(PDO::FETCH_ASSOC);

  }
  return $data;
}

function userform($id) {
  //$data =implode(', ', $data1);
  global $connection;
  $query = $connection->prepare('SELECT Nombre,Direccion,Genero,Correo,FechaNacimiento,Telefono,Img_perfil FROM usuario WHERE Ndocumento = :id');
  $query->bindParam(':id', $id);
  $query->execute();
  $user = $query->fetch(PDO::FETCH_ASSOC);
  
  return $user;
}

function getRol($id) {
    global $connection;
    $query = $connection->prepare('SELECT * FROM rol WHERE Id_rol = :id');
    $query->bindParam(':id', $id);
    $query->execute();
    $rol = $query->fetch(PDO::FETCH_ASSOC);
    return $rol;
}

function updateUserData($id, array $data) {
    global $connection;
    $query = $connection->prepare('UPDATE usuario SET ' . implode(', ', $data) . ' WHERE Ndocumento = :id');
    $query->bindParam(':id', $id);
    $query->execute();
}


?>