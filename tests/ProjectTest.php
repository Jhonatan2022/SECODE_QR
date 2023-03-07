<?php

class projectTest extends \PHPUnit\Framework\TestCase
{
    
    public function testPushAndPop()
    {        /*
             _       _         _                         _ 
          __| | __ _| |__  ___| |__   ___   __ _ _ __ __| |
         / _` |/ _` | '_ \/ __| '_ \ / _ \ / _` | '__/ _` |
        | (_| | (_| | | | \__ \ |_) | (_) | (_| | | | (_| |
         \__,_|\__,_|_| |_|___/_.__/ \___/ \__,_|_|  \__,_|

        */

        if (!isset($_SESSION["user_id"])) {
            $message = array(' Error', 'No ha iniciado sesion ', 'error');
            //header('Location: index.php');
        } else {

            $records = $connection->prepare('SELECT Ndocumento,Img_perfil, TipoImg FROM usuario WHERE Ndocumento = :id');
            $records->bindParam(':id', $_SESSION['user_id']);

            if ($records->execute()) {
                $resultsUser = $records->fetch(PDO::FETCH_ASSOC);
            } else {
                $message = array(' Error', 'Ocurrio un error en la consulta datos user. intente de nuevo.', 'error');
            }

            $records = $connection->prepare('	SELECT Atributos,Titulo,RutaArchivo,Duracion,Descripcion,Id_codigo FROM codigo_qr WHERE Ndocumento = :id');
            $records->bindParam(':id', $_SESSION['user_id']);


            if ($records->execute()) {
                $results = $records->fetchAll(PDO::FETCH_ASSOC);
                //$codes = $results;
            } else {
                $message = array(' Error', 'Ocurrio un error en la consulta codigos user. intente de nuevo.', 'error');
            }
        }

        $this->assertEquals('No ha iniciado sesion ', $message[1]);
    }
}
