<?php



require_once '../models/database/database.php';

function getUser($id) {
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