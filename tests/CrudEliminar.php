<?php

class CrudEliminar extends \PHPUnit\Framework\TestCase
{



    public function testElimianar()
    {
        //Elimiar un usuario crud eliminar.

        $conexion = mysqli_connect("localhost", "root", "", "id16455213_secode_qr");
        extract($_POST);
        $Ndocumento =  12345;
        $consulta = "DELETE FROM usuario WHERE Ndocumento= $Ndocumento";
        $res = mysqli_query($conexion, $consulta);


        $this->assertEquals(1, $res);
    }
}



