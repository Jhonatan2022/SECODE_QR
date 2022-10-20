<?php

if (! isset($_SESSION['user_id'])) {
  header('Location: ../views/');
  }

require_once '../models/database/database.php';

function getUser($id) {
    global $connection;
    $query = $connection->prepare('SELECT * FROM usuario WHERE Ndocumento = :id');
    $query->execute(['id' => $id]);
    $user = $query->fetch(PDO::FETCH_ASSOC);
    if (empty($user['Img_perfil']) || $user['Img_perfil'] == null) {
      $user['Img_perfil'] = "http://" . $_SERVER['HTTP_HOST'] . "/secodeqr/views/assets/img/userimg.png";
    } else {
      $user['Img_perfil'] = 'data:' . $user['TipoImg'] . ";base64," . base64_encode($user['Img_perfil']);
    }

    return $user;
}


?>