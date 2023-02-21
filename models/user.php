<?php



#require_once '../models/database/database.php';

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
function getUserData($id){ //complete info user data without table condicion clinica
  global $connection;
  $query = $connection->prepare('SELECT 
  us.Ndocumento,tipdoc.TipoDocumento,us.Nombre,us.Apellidos,us.Correo,tipsus.TipoSuscripcion, sus.FechaExpiracion ,us.Direccion,lc.Localidad, gn.Genero, estr.Estrato, eps.NombreEps, rl.rol, us.FechaNacimiento,us.Telefono, us.Img_perfil, us.token_reset, us.TipoImg, sus.numero_recibo, tipsus.precio, sus.fecha_inicio
  FROM usuario AS us
  LEFT OUTER JOIN tipodocumento AS tipdoc
  ON us.TipoDoc = tipdoc.IDTipoDoc
  LEFT OUTER JOIN genero AS gn
  ON us.Genero = gn.IDGenero
  LEFT OUTER JOIN estrato AS est 
  ON us.Estrato = est.IDEstrato
  LEFT OUTER JOIN rol AS rl
  ON us.rol = rl.id
  LEFT OUTER JOIN localidad AS lc
  ON us.Localidad = lc.IDLocalidad
  
  LEFT OUTER JOIN Suscripcion as sus
  ON sus.Ndocumento = us.Ndocumento
  LEFT OUTER JOIN TipoSuscripcion AS tipsus
  ON sus.TipoSuscripcion = tipsus.IDTipoSuscripcion
  
  LEFT OUTER JOIN eps 
  ON us.id = eps.id
  LEFT OUTER JOIN estrato AS estr 
  ON us.Estrato = estr.IDEstrato
  WHERE us.Ndocumento = :id');
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

?>