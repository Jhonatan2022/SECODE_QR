<?php
class CrudInsertar extends \PHPUnit\Framework\TestCase
{
    public function testInsertar()
    {
        $server = 'localhost';
        $username = 'root';
        $password = '';
        $database = 'id16455213_secode_qr';

        try {
            $connection = new PDO("mysql:host=$server;dbname=$database", $username, $password);
            // set the PDO error mode to exception
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Connected successfully"; 
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        //Insertar un usuario crud eliminar. PDO
        $email_user = 'email@outlook.com';
        $numdoc = intval('1022936458');
        $password_user = 'micontra12345';
        $name_user = 'mi nombre';
        $token = rand(124324, 876431167878435);

        $consult = "INSERT INTO usuario 
        (Ndocumento, Nombre,direccion,Genero,Correo,Contrasena,FechaNacimiento,id,Img_perfil,token_reset,TipoImg) 
        VALUES 
        (:ndoc, :username, null, null, :useremail, :userpassword, null, :ideps, null, :token, null)";
        $params = $connection->prepare($consult);
        $params->bindParam(':useremail', $email_user);
        $password = password_hash($password_user, PASSWORD_BCRYPT);
        $params->bindParam(':userpassword', $password);
        $params->bindParam(':username', $name_user);
        $id_eps = 10;
        $params->bindParam(':ideps', $id_eps);
        $params->bindParam(':ndoc', $numdoc);
        $params->bindParam(':token', $token);
        //establecemos los parametros de la consulta

        if ($params->execute()) {
            $message = array(' Ok Registrado ', ' Realizado correctamente, usuario registrado, inicie sesión, para continuar...', 'success');
        } else {
            $message = array('Error', 'No se pudo registrar el usuario', 'error');
        }
        $this->assertEquals(' Ok Registrado ', $message[0]);
    }
}