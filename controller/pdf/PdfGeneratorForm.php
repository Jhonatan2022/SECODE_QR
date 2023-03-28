<?php
session_start();
require_once '../../models/database/database.php';
require_once '../../main.php';

function arraytojson(){
            //covert array to json
            $array= $_POST['arraycond'];

            /* $datarray = json_decode($value, true); */
            $clndata = array();
            //var_dump($arrayName);
            if ('1'==$array) {
              $clndata+=array('1' => 'Presión alta');
            } elseif ('2'==$array) {
              $clndata+=array('1' => 'Diabetes');
            } elseif ('3'==$array) {
              $clndata+=array('1' => 'Afecciones cardíacas');
            } elseif ('4'==$array) {
              $clndata+=array('1' => 'Covid-19');
            } elseif ('5'==$array) {
              $clndata+=array('1' => 'Enfermedades respiratorias');
            }
    return $json = json_encode($clndata);
}


function globadata(){
    if($_POST['Genero']==1){
        $_POST['Genero']='Masculino';
    }elseif($_POST['Genero']==2){
        $_POST['Genero']='Femenino';
    }elseif($_POST['Genero']==3){
        $_POST['Genero']='Otro';
    }

    if($_POST['TipoAfiliacion']==1){
        $_POST['TipoAfiliacion']='Cotizante';
    }elseif($_POST['TipoAfiliacion']==2){
        $_POST['TipoAfiliacion']='Contributivo';
    }

    if($_POST['RH']==1){
        $_POST['RH']='Positivo';
    }elseif($_POST['RH']==2){
        $_POST['RH']='Negativo';
    }

    if($_POST['Tipo_de_sangre']==1){
        $_POST['Tipo_de_sangre']='A';
    }elseif($_POST['Tipo_de_sangre']==2){
        $_POST['Tipo_de_sangre']='B';
    }elseif($_POST['Tipo_de_sangre']==3){
        $_POST['Tipo_de_sangre']='AB';
    }elseif($_POST['Tipo_de_sangre']==4){
        $_POST['Tipo_de_sangre']='O';
    }
    /* if($_POST['IDcondicionesClinicas']==1){
        $condicione+='Presiona Alta, ';
    }elseif($_POST['IDcondicionesClinicas']==2){
        $condicione+='Diabetes, ';
    }elseif($_POST['IDcondicionesClinicas']==3){
        $condicione+='Afecciones cardiacas, ';
    }elseif($_POST['IDcondicionesClinicas']==4){
        $condicione+='Covid-19, ';
    }elseif($_POST['IDcondicionesClinicas']==5){
        $condicione+='Enfermedad Respiratoria,';
    } */

    global $data;
    $data=array(
        'Titulo'=>$_POST['Titulo'],
        'Nombre'=>$_POST['Nombre'],
        'FechaNacimiento'=>$_POST['FechaNacimiento'],
        'Nombre Eps'=>$_POST['NombreEps'],
        'Telefono'=>$_POST['Telefono'],
        'Correo'=>$_POST['Correo'],
        'Genero'=>$_POST['Genero'],
        'Tipo de Afiliacion'=>$_POST['TipoAfiliacion'],
        'RH'=>$_POST['RH'],
        'Tipo de Sangre'=>$_POST['Tipo_de_sangre'],
        /* 'Condiciones Clinicas'=>$condicione, */
    );
}

if(! isset($_SESSION['user_id'])){
    http_response_code(404);
    //header('Location: ../views/');
}else{
    if(isset($_GET['formulario']) && $_GET['formulario'] == 'clinico' && !isset($_GET['idclinico'])){//flata validar primero edicion de formulario

        $json = arraytojson();

        $query = $connection->prepare('insert into datos_clinicos 
        (NDocumento,TipoAfiliacion,RH,Tipo_de_sangre,arraycond,AlergiaMedicamento) 
        values (:NDocumento,:TipoAfiliacion,:RH,:Tipo_de_sangre,:arraycond,:AlergiaMedicamento)');
                $query->bindParam(':NDocumento', $_SESSION['user_id']);
                $query->bindParam(':TipoAfiliacion', $_POST['TipoAfiliacion']);
                $query->bindParam(':RH', $_POST['RH']);
                $query->bindParam(':Tipo_de_sangre', $_POST['Tipo_de_sangre']);
                $query->bindParam(':arraycond', $json);
                $query->bindParam(':AlergiaMedicamento', $_POST['AlergiaMedicamento']);
                $result=$query->execute();
        if($result){
            $query = $connection->prepare('SELECT * FROM datos_clinicos WHERE NDocumento = :NDocumento ORDER by -IDDatosClinicos;');
            $query->bindParam(':NDocumento', $_SESSION['user_id']);
            $query->execute();
            $resultclinico=$query->fetch(PDO::FETCH_ASSOC);

        }else{
            echo 'error';
        }


//generate random string
$rand_token = openssl_random_pseudo_bytes(16);
//change binary to hexadecimal
$token = bin2hex($rand_token);

//name pdf doc
$name=$token.'.pdf';
        $variable = false;

     $urlCodeForm='http://'.$_SERVER['HTTP_HOST'].'/secodeqr/views/pdf/myform.php?formulario='.$name;
     $atribDefault=1;

     $duration=date("Y-m-d");

     $consult='INSERT INTO codigo_qr 
     (`Id_codigo`,`nombre`, `Duracion`, `Ndocumento`, `Titulo`, `DatosClinicos`, `RutaArchivo` ) 
     VALUES (null ,:nombre, :Duracion, :Ndoc, :Titulo, :iddatos,:Ruta) ';
    
    $params= $connection->prepare($consult);
    $params->bindParam(':Ndoc',$_SESSION['user_id']);
    $params->bindParam(':Duracion',$duration);
    $params->bindParam(':nombre',$name);
    $params->bindParam(':Titulo', $data['Titulo']);
    $params->bindParam(':Ruta',$urlCodeForm);
    $params->bindParam(':iddatos',$resultclinico['IDDatosClinicos']);
    /* $params->bindParam(':AtribDefault',$atribDefault); */
    if ($params->execute()) {
        $p=$connection->prepare('SELECT Id_codigo 
        FROM codigo_qr 
        WHERE Ndocumento = :Ndoc
        ORDER BY Id_codigo DESC LIMIT 1 ');
        $p->bindParam(':Ndoc',$_SESSION['user_id']);
        if ($p->execute()) {
            $idcode=$p->fetch(PDO::FETCH_ASSOC);
            $id=$idcode['Id_codigo'];
            if ($variable){
                header('Location: '.$_SERVER['HTTP_REFERER'].'&GenerateError=22&Data='.$id);
            }else{
                header('Location: '.$_SERVER['HTTP_REFERER'].'?GenerateError=22&Data='.$id);
            }
            
        }else{
            echo 'no';
            header('Location: '.$_SERVER['HTTP_REFERER'].'?GenerateError=1');
        }        
    }else{
        header('Location: '.$_SERVER['HTTP_REFERER'].'?GenerateError=1');
    }

        globadata();


    }elseif(isset($_GET['formulario']) && $_GET['formulario'] == 'medico' && !isset($_GET['idclinico'])){

        if (isset($_FILES['imagenFormula']) && $_FILES['imagenFormula']['error'] == UPLOAD_ERR_OK) {
            #
            #if the user send a file to update the profile image 
            #types of files permited
            $permitidos = array("image/jpg", "image/jpeg", "image/png", "image/pneg");
            $limite_kb = 3000; //10 mb maximo tamaño archivo

            if ((in_array($_FILES['imagenFormula']['type'], $permitidos) && $_FILES['imagenFormula']['size'] <= $limite_kb * 1024)) {
                
                $extencion = pathinfo($_FILES['imagenFormula']['name'], PATHINFO_EXTENSION); #the extension of the file
                $numbers = random_int(3244, 14323433); #generate a random number
                $nombre = date("Y-m-d-H-i-s").$numbers.'.'.$extencion ; #add the date to the name of the file
                $ruta = '../../models/img/'; #the path to save the file
                $ruta = $ruta . $nombre; #the path to save the file
                $query = $connection->prepare('INSERT INTO FormularioMedicamentos (Ndocumento, ArchivoFormulaMedica) VALUES (:id, :ruta)');
                $query->bindParam(':id', $_SESSION['user_id']);
                $query->bindParam(':ruta', $nombre);
                $result = $query->execute();
                if ($result && move_uploaded_file($_FILES['imagenFormula']['tmp_name'], $ruta)) {
                    $query = $connection->prepare('SELECT * FROM FormularioMedicamentos WHERE NDocumento = :NDocumento ORDER by -IDFormularioMedicamentos;');
                    $query->bindParam(':NDocumento', $_SESSION['user_id']);
                    $query->execute();
                    $resultclinico=$query->fetch(PDO::FETCH_ASSOC);

                    //generate random string
                    $rand_token = openssl_random_pseudo_bytes(16);
                    //change binary to hexadecimal
                    $token = bin2hex($rand_token);
                                    
                    //name pdf doc
                    $name=$token.'.pdf';
                        $variable = false;
                                
                     $urlCodeForm='http://'.$_SERVER['HTTP_HOST'].'/secodeqr/views/pdf/myform.php?formulario='.$name;
                     $atribDefault=1;
                                
                     $duration=date("Y-m-d");
                                
                     $consult='INSERT INTO codigo_qr 
                     (`Id_codigo`,`nombre`, `Duracion`, `Ndocumento`, `Titulo`, `FormularioMedicamentos`, `RutaArchivo` ) 
                     VALUES (null ,:nombre, :Duracion, :Ndoc, :Titulo, :iddatos,:Ruta) ';
                    
                    $params= $connection->prepare($consult);
                    $params->bindParam(':Ndoc',$_SESSION['user_id']);
                    $params->bindParam(':Duracion',$duration);
                    $params->bindParam(':nombre',$name);
                    $params->bindParam(':Titulo', $_POST['Titulo']);
                    $params->bindParam(':Ruta',$urlCodeForm);
                    $params->bindParam(':iddatos',$resultclinico['IDFormularioMedicamentos']);
                    /* $params->bindParam(':AtribDefault',$atribDefault); */
                    if ($params->execute()) {
                        $p=$connection->prepare('SELECT Id_codigo 
                        FROM codigo_qr 
                        WHERE Ndocumento = :Ndoc
                        ORDER BY Id_codigo DESC LIMIT 1 ');
                        $p->bindParam(':Ndoc',$_SESSION['user_id']);
                        if ($p->execute()) {
                            $idcode=$p->fetch(PDO::FETCH_ASSOC);
                            $id=$idcode['Id_codigo'];
                            
                            header('Location: '.'http://'.$_SERVER['HTTP_HOST'].'/secodeqr/views/formulario_medicamentos.php?GenerateError=22&Data='.$id);                            
                        }else{
                            header('Location: '.'http://'.$_SERVER['HTTP_HOST'].'/secodeqr/views/formulario_medicamentos.php?GenerateError=1');
                        }
                } else {
                    header('Location: '.'http://'.$_SERVER['HTTP_HOST'].'/secodeqr/views/formulario_medicamentos.php?GenerateError=1');
                }
            } else {
                header('Location: '.'http://'.$_SERVER['HTTP_HOST'].'/secodeqr/views/formulario_medicamentos.php?GenerateError=1');
            }            

    }elseif (isset($_GET['formulario']) && $_GET['formulario'] == 'clinico' && isset($_GET['idclinico']) ) {
        $variable=true;
                //update the database with the new data
                #try{
                $json = arraytojson();
                $date= date('Y-m-d');
                $query = $connection->prepare('UPDATE datos_clinicos AS dt LEFT OUTER JOIN codigo_qr as qr ON qr.DatosClinicos = dt.IDDatosClinicos
                SET dt.TipoAfiliacion = :TipoAfiliacion, dt.Tipo_de_sangre = :Tipo_de_sangre, dt.RH = :RH,
                dt.AlergiaMedicamento = :AlergiaMedicamento, dt.arraycond = :arraycond , qr.Titulo = :Titulo, qr.Duracion = :Duracion
                WHERE dt.NDocumento = :Ndocumento AND qr.id_codigo = :IDDatosClinicos ');
                $query->bindParam(':Ndocumento', $_SESSION['user_id']);
                $query->bindParam(':TipoAfiliacion', $_POST['TipoAfiliacion']);
                $query->bindParam(':RH', $_POST['RH']);
                $query->bindParam(':Tipo_de_sangre', $_POST['Tipo_de_sangre']);
                $query->bindParam(':arraycond', $json);
                $query->bindParam(':AlergiaMedicamento', $_POST['AlergiaMedicamento']);
                $query->bindParam(':IDDatosClinicos', $_GET['idclinico']);
                $query->bindParam(':Titulo', $_POST['Titulo']);
                $query->bindParam(':Duracion', $date);
                if ($query->execute()){
                    $variable=false;
                    $query = $connection->prepare('SELECT * FROM datos_clinicos WHERE NDocumento = :NDocumento ORDER by -IDDatosClinicos;');
                    $query->bindParam(':NDocumento', $_SESSION['user_id']);
                    $query->execute();
                    $resultclinico=$query->fetch(PDO::FETCH_ASSOC);
                    echo 'success';
                    header('Location:  ../../views/formulario_datos_clinicos.php?GenerateError=22&Data='.$resultclinico['IDDatosClinicos']);
                }
                #}catch(PDOException $e){
                #    echo $e->getMessage();
                #}
                global $data;
    }
    else{
        $data=array(
            'Titulo'=>$_POST['TituloForm'],
            'Nombre'=>$_POST['UserName'],
            'Direccion'=>$_POST['UserLocationDir'],
            'FechaNacimiento'=>$_POST['UserDateBorn'],
            'Telefono'=>$_POST['UserPhone'],
            'Correo'=>$_POST['UserEmail'],
            /*
            'Genero'=>$_POST['nameUser'],
            'RH'=>$_POST['nameUser'],
            'TipoAfiliacion'=>$_POST['nameUser'],
            'Subsidio'=>$_POST['nameUser'],
            'Departamento'=>$_POST['nameUser'],
            'Tipo_de_sangre'=>$_POST['nameUser'],
            'Estrato'=>$_POST['nameUser'],
            'EsAlergico'=>$_POST['nameUser'],*/
        );
    }
}

}
}

?>
