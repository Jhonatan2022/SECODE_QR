<?php

class dataBase extends \PHPUnit\Framework\TestCase
{



    public function projectTest()
    {

        $server = 'localhost';
        $username = 'root';
        $password = '';
        $database = 'id16455213_secode_qr';

        try {
            $connection = new PDO("mysql:host=$server;dbname=$database", $username, $password);
            // set the PDO error mode to exception
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $res = "Connected successfully";
        } catch (PDOException $e) {
            $res = "Connection failed: " . $e->getMessage();
        }



        $this->assertEquals('Connected successfully', $res);
    }
}
