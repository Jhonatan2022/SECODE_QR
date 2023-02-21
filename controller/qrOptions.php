<?php

namespace LuisFer\Secodeqr\qrOptions;
//require_once '../models/database/database.php';


class QrOptions{
    public $connection;
    
    public function __construct(
        string $id_codigo,
        $connection
    )
    {
        $this->id_codigo = $id_codigo;
        $this->connection = $connection;
    }

    public function deleteQr($id){
        
        $records =$this->connection->prepare('DELETE FROM `codigo_qr` WHERE `codigo_qr`.`Id_codigo` = :id');
        $records->bindParam(':id', $id);
        if($records->execute()){
            $message = array(' Eliminado', 'El codigo QR fue eliminado correctamente.', 'success');
            echo 'ok';
        }else{
            $message = array(' Error', 'Ocurrio un error en la consulta datos user. intente de nuevo.', 'error');
            echo 'error';
        }
    }

}


