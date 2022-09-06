<?php


session_start();

if(! isset($_SESSION['user_id'])){
    http_response_code(404);
    header('Location: ../views/');
   
}else{


    $data=array('Nombre'=>$_POST['UserName'],
    'Direccion'=>$_POST['UserLocationDir'],
    'FechaNacimineto'=>$_POST['UserDateBorn'],
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

?>




<?php
ob_start();
    $imgLogo= "http://".$_SERVER['HTTP_HOST']."/SECODE_QR/secode/views/assets/img/nosotros.jpg ";
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
        Entrega de evidencia
        <img src="https://external-content.duckduckgo.com/iu/?u=http%3A%2F%2F2.bp.blogspot.com%2F-QrRgcI7ytzM%2FVWA07PLEpRI%2FAAAAAAAACnE%2Fux2xfsx8Ltk%2Fs1600%2FSena-colombia-logo-vector.png&f=1&nofb=1" alt="logo sena" srcset="" style="
        width: 30px;height: 30px; object-fit: cover;float: right;">
    </h2>


    <div style="padding:10px; border-radius:3px; margin: 0 auto; margin-top:20px;margin-bottom: 20px; outline:2px solid #5d2aaf; width: 90%;font-family: 'Nunito', sans-serif; background-color: #d0d3ec;">

    

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
   

<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Perferendis iste consequuntur at accusantium. Labore dolores omnis architecto totam aliquam aut dignissimos autem. Mollitia iste animi totam perferendis culpa error nihil.</p>

<?php //include('../views/templates/footerWebUser.php') ?>
</body>
</html>


<?php

$html_doc=ob_get_clean();


require_once './dompdf/autoload.inc.php';

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



// Output the generated PDF to Browser
$dompdf->stream('archivo.pdf',array('Attachment'=>false));


?>