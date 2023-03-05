<?php
session_start();
require_once '../../models/database/database.php';
require_once '../../main.php';
if(! isset($_SESSION['user_id'])){
    http_response_code(404);
    //header('Location: ../views/');
}else{
    if(isset($_GET['formulario']) && $_GET['formulario'] == 'clinico'){//flata validar primero edicion de formulario

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


        $json = json_encode($clndata);

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
    }elseif (isset($_GET['formulario']) && $_GET['formulario'] == 'clinico' && isset($_GET['idclinico']) ) {
        $variable=true;
                //update the database with the new data
                $query = $connection->prepare('UPDATE datos_clinicos SET TipoAfiliacion = :TipoAfiliacion, RH = :RH, Tipo_de_sangre = :Tipo_de_sangre, IDcondicionesClinicas = :IDcondicionesClinicas, AlergiaMedicamento = :AlergiaMedicamento WHERE NDocumento = :NDocumento AND IDDatosClinicos = :IDDatosClinicos');
                $query->bindParam(':NDocumento', $_POST['NDocumento']);
                $query->bindParam(':TipoAfiliacion', $_POST['TipoAfiliacion']);
                $query->bindParam(':RH', $_POST['RH']);
                $query->bindParam(':Tipo_de_sangre', $_POST['Tipo_de_sangre']);
                $query->bindParam(':IDcondicionesClinicas', $_POST['IDcondicionesClinicas']);
                $query->bindParam(':AlergiaMedicamento', $_POST['AlergiaMedicamento']);
                $query->bindParam(':IDDatosClinicos', $_GET['idclinico']);
                $query->execute();
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
?><?php
ob_start();
    $imgLogo= "http://".$_SERVER['HTTP_HOST']."/secodeqr/secode/views/assets/img/nosotros.jpg ";
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php //include('../views/templates/header.php')?>
    <title>Formulario</title>
</head>
<body>

<!-- <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@500&display=swap" rel="stylesheet"> -->

<div style="max-width: 700px; margin:0 auto; ">
    <h2 style="padding: 10px; border-left: 10px solid rgb(255, 95, 95); background:rgb(222, 221, 228); font-family: Verdana, Geneva, Tahoma, sans-serif;

    font-family: 'Nunito', sans-serif;">
        Datos Documento Clinico
        <img src="https://programacion3luis.000webhostapp.com/secode/views/assets/img/logo.png" alt="logo secodeqr" style="
        width: 30px;height: 30px; object-fit: cover;float: right;">
    </h2>

    </div>
    <center>
    <hr width="15%" style="background:rgb(74, 69, 92); height: 5px; border-radius: 5px; ">
    </center>
    <div>
        <h2 style="text-align: center;">Datos:</h2>

<?php foreach($data as $key => $value){  ?>

    <p style="padding:5px;background:#d0d3ec; color:black">
            <spam style="color:#5d2aaf;font-weight: bold;"> <?php echo $key ?> </spam>
            <?php echo $value ?>
        </p>


   <?php  }?>

    </div>


</div>
   

<p>
    Formulario de datos clinicos de paciente, para el manejo de la informacion de los pacientes en el sistema de salud. <br>
    En este formulario se encuentran los datos basicos del paciente, como su nombre, fecha de nacimiento, genero, tipo de sangre, etc.<br>


</p>
<strong> <i>
    Este documento fue generado por el sistema de secodeqr, para el manejo de la informacion de los pacientes en el sistema de salud.
    Cualquier duda o inquietud, comunicarse con el administrador del sistema.
    Si este documento no le pertenece, comunicarse con el usuario que lo genero.
</i></strong>

<strong>
    <p style="text-align: center;">
        <a href="http://secodeqr.000webhostapp.com/">Secode Qr</a>
    </p>
</strong>

<?php //include('../views/templates/footerWebUser.php') ?>
</body>
</html>
<?php
$html_doc=ob_get_clean();
require_once '../../main.php';
require_once BaseDir.'/vendor/autoload.php';
// reference the Dompdf namespace
use Dompdf\Dompdf;
// instantiate and use the dompdf class

$dompdf = new Dompdf();
$dompdf->loadHtml($html_doc);

$options=$dompdf->getOptions();;
$options->set(array('isRemoteEnabled'=>true));
$dompdf->setOptions($options);

//$dompdf->setPaper('A4', 'landscape');
$dompdf->setPaper('A4');

// Render the HTML as PDF
$doc=$dompdf->render();

$output = $dompdf->output();

//generate random string
$rand_token = openssl_random_pseudo_bytes(16);
//change binary to hexadecimal
$token = bin2hex($rand_token);

//name pdf doc
$name=$token.'.pdf';
$file=file_put_contents($name, $output);

$des='../../views/pdf/'.$name;
//echo $file;
$source = './'.$name;

 if(rename($source,$des) ){
     $Moved = true;
     $urlCodeForm='http://'.$_SERVER['HTTP_HOST'].'/secodeqr/views/pdf/'.$name;
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
 }else{
    $Moved=false;
 }

?>
