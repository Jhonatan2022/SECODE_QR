<?php

class CrudEliminar extends \PHPUnit\Framework\TestCase
{



    public function testElimianar()
    {
        //Elimiar un usuario crud eliminar.

        $conexion = mysqli_connect("localhost", "root", "", "id16455213_secode_qr");
        extract($_POST);
        $Ndocumento =  123456;
        $consulta = "DELETE FROM usuario WHERE Ndocumento= $Ndocumento";
        $res = mysqli_query($conexion, $consulta);
        if($res){
            $mes="Se elimino correctamente";
        }else{
            $mes="No se elimino correctamente";
        }

        $this->assertEquals('Se elimino correctamente', $mes);
    }
}



