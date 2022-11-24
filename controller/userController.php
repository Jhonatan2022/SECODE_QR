<?php


namespace LuisFer\Secodeqr\UserController;

require_once '../models/database/database.php';

class Usuario{

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function GetDataUser(string $id, array $data){
        $query= "";
        $params=$connection->prepare($query);
        $params=f
    }


}