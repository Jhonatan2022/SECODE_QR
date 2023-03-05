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

function getClinicData($id,$isnew, $codigo) {
  global $connection;
  if(!$isnew){ /* si es true -> evalua false  */
    $query = $connection->prepare('SELECT qr.Titulo, us.Nombre, us.FechaNacimiento, eps.NombreEps, us.Telefono , us.Correo, us.Genero,dta.TipoAfiliacion,dta.RH, dta.Tipo_de_sangre, dta.CondicionClinica, dta.arraycond, dta.AlergiaMedicamento
    FROM usuario AS us LEFT OUTER JOIN eps 
    ON eps.id = us.id 
    LEFT OUTER JOIN datos_clinicos AS dta
    ON us.Ndocumento= dta.NDocumento
    LEFT OUTER JOIN codigo_qr as qr
    ON dta.IDDatosClinicos = qr.DatosClinicos
    WHERE us.Ndocumento = :id and qr.id_codigo = :codigo');
    $query->bindParam(':id', $id);
    $query->bindParam(':codigo', $codigo);
    $query->execute();
    $data = $query->fetch(PDO::FETCH_ASSOC);
  }else{
    $query = $connection->prepare('SELECT qr.Titulo, us.Nombre, us.FechaNacimiento, eps.NombreEps, us.Telefono , us.Correo, us.Genero,dta.TipoAfiliacion,dta.RH, dta.Tipo_de_sangre, dta.CondicionClinica, dta.arraycond, dta.AlergiaMedicamento
    FROM usuario AS us LEFT OUTER JOIN eps 
    ON eps.id = us.id 
    LEFT OUTER JOIN datos_clinicos AS dta
    ON us.Ndocumento= dta.NDocumento
    LEFT OUTER JOIN codigo_qr as qr
    ON dta.IDDatosClinicos = qr.DatosClinicos
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

//functioons to return info data user

function getUserData($id){ //complete info user data without table condicion clinica
  global $connection;
  $query = $connection->prepare('SELECT 
  us.Ndocumento,tipdoc.TipoDocumento,us.Nombre,us.Apellidos,us.Correo,tipsus.TipoSuscripcion, sus.FechaExpiracion ,us.Direccion,lc.Localidad, gn.Genero, estr.Estrato, eps.NombreEps, rl.rol, us.FechaNacimiento,us.Telefono, us.Img_perfil, us.token_reset, us.TipoImg
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

//function for the data tables
function localidad() {
  global $connection;
  $query = $connection->prepare('SELECT * FROM localidad');
  $query->execute();
  $eps = $query->fetchAll(PDO::FETCH_ASSOC);
  return $eps;
}
function afiliacion() {
  global $connection;
  $query = $connection->prepare('SELECT * FROM afiliacion');
  $query->execute();
  $afl = $query->fetchAll(PDO::FETCH_ASSOC);
  return $afl;
}
function Eps() {
    global $connection;
    $query = $connection->prepare('SELECT * FROM eps');
    $query->execute();
    $eps = $query->fetchAll(PDO::FETCH_ASSOC);
    return $eps;
}
function Genero() {
  global $connection;
  $query = $connection->prepare('SELECT * FROM Genero');
  $query->execute();
  $eps = $query->fetchAll(PDO::FETCH_ASSOC);
  return $eps;
}
function rh() {
  global $connection;
  $query = $connection->prepare('SELECT * FROM RH');
  $query->execute();
  $eps = $query->fetchAll(PDO::FETCH_ASSOC);
  return $eps;
}
function tipoSangre() {
  global $connection;
  $query = $connection->prepare('SELECT * FROM TipoSangre');
  $query->execute();
  $eps = $query->fetchAll(PDO::FETCH_ASSOC);
  return $eps;
}
function condicionClinica() {
  global $connection;
  $query = $connection->prepare('SELECT * FROM CondicionClinica');
  $query->execute();
  $eps = $query->fetchAll(PDO::FETCH_ASSOC);
  return $eps;
}
function tipoDocumento() {
  global $connection;
  $query = $connection->prepare('SELECT * FROM tipodocumento');
  $query->execute();
  $eps = $query->fetchAll(PDO::FETCH_ASSOC);
  return $eps;
}
function tipoSubsidio() {
  global $connection;
  $query = $connection->prepare('SELECT * FROM TipoSubsidio');
  $query->execute();
  $eps = $query->fetchAll(PDO::FETCH_ASSOC);
  return $eps;
}
function tipoSuscripcion() {
  global $connection;
  $query = $connection->prepare('SELECT * FROM TipoSuscripcion');
  $query->execute();
  $eps = $query->fetchAll(PDO::FETCH_ASSOC);
  return $eps;
}
function alergia() {
  global $connection;
  $query = $connection->prepare('SELECT * FROM AlergiaMedicamento');
  $query->execute();
  $eps = $query->fetchAll(PDO::FETCH_ASSOC);
  return $eps;
}
?>