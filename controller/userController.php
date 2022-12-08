<?php


//namespace LuisFer\SecodeQr\userController;

require_once '../models/database/database.php';

class User{

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function GetDataUser(string $id, array $data){
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
}