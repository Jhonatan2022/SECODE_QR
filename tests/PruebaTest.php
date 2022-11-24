<?php

use PHPUnit\Framework\TestCase;

class PruebaTest extends TestCase
{
    public function testTrueAssertsToTrue()
    {
        $this->assertTrue(true);
    }

    public function testLogin()
    {
        include_once 'ClaseEjemplo.php';
        $claseEjemplo = new ClaseEjemplo();
        $this->assertTrue($claseEjemplo->loginUsuario('amin', 'admin'));
        
    }

}


?>