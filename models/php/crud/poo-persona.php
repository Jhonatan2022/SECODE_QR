<?php

require_once("../../database/database.php");

class persona {
    private $Ndocumento;
    private $Direccion;
    private $Genero;
    private $FechaNacimiento;
    private $Id_Eps;
    private $Img_perfil;
    private $TipoImg;
    public function obtenerPersona($Ndocumento){
        $db = new Database();
        $select = $db ->prepare("SELECT * FROM usuario WHERE Ndocumento = :id");
        $select -> bindValue("id",$Ndocumento);
        $select -> execute();
        $persona = $select -> fetch();
        $myPersona = new Persona();
        $myPersona -> setId($persona["Ndocumento"]);
        $myPersona -> setNombre($persona["Nombre"]);
        $myPersona -> setCorreo($persona["Correo"]);
        $myPersona -> setGenero($persona["Genero"]);
        $myPersona -> setFechaNacimiento($persona["FechaNacimineto"]);
        $myPersona -> setTipoImg($persona["TipoImg"]);
        $myPersona -> setImgperfil($persona["Img_perfil"]);
        $myPersona -> setId_eps($persona["id"]);
        return $myPersona;
    }
    public function mostrar(){
        $db=Db::conectar();
        $listaPersona = [];
        $select = $db->query("SELECT * FROM usuario");
        foreach($select -> fetchAll() as $persona){
            $myPersona = new Persona();
            $myPersona -> setNdocumento($persona["Ndocumento"]);
            $myPersona -> setNombre($persona["Nombre"]);
            $myPersona -> setCorreo($persona["Correo"]);
            $myPersona -> setDireccion($persona["Direccion"]);
            $myPersona -> setGenero($persona["Genero"]);
            $myPersona -> setFechaNacimineto($persona["FechaNacimineto"]);
            $myPersona -> setid($persona["id"]);
            $myPersona -> setImg_perfil($persona["Img_perfil"]);
            $listaPersona[] = $myPersona;
        }
        return $listaPersona;
    }

    public function actualizar($persona){
        $db = Db::conectar();
        $actualizar = $db ->prepare("UPDATE usuario SET  Genero=:Genero, Correo=:Correo, Id_Eps=:Id_Eps,FechaNacimiento=:FechaNacimiento, Img_perfil=:Img_perfil, TipoImg=:TipoImg, Direccion=:Direccion  WHERE Ndocumento = :Ndocumento");
        $actualizar -> bindValue("Ndocumento",$persona -> getNdocumento());
        $actualizar -> bindValue("Genero",$persona -> getGenero());
        $actualizar -> bindValue("Correo",$persona -> getCorreo());
        $actualizar -> bindValue("Id_Eps",$persona -> getId_Eps());
        $actualizar -> bindValue("FechaNacimiento",$persona -> getFechaNacimiento());
        $actualizar -> bindValue("Img_perfil",$persona -> getImg_perfil());
        $actualizar -> bindValue("TipoImg",$persona -> getTipoImg());
        $actualizar -> bindValue("Direccion",$persona -> getDireccion());
        $actualizar -> execute();
    }
}