<?php
//DB remoto 
/*
$server = 'localhost';
$username = 'id16455213_teamsecode';
$password = 'kEl42Sx/PoX$2!)a';
$database = 'id16455213_secode_qr';
*/
//servidor local

$server = 'localhost';
$username = 'root';
$password = '';
$database = 'id16455213_secode_qr';

try {
    $connection= new PDO("mysql:host=$server;dbname=$database", $username, $password);
    // set the PDO error mode to exception
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully"; 
    } catch(PDOException $e) {    
    echo "Connection failed: " . $e->getMessage();
    }


?>