<?php


session_start();

require_once '../../models/database/database.php';
require_once '../../models/user.php';


    if (isset($_GET['formulario'])) {
        $form = $_GET['formulario'];

        $data=$connection->prepare('SELECT * FROM codigo_qr WHERE nombre = :nombre');
        $data->execute([':nombre' => $form]);
        $numQr = $data->rowCount();
        if($numQr < 1 ){
            http_response_code(404);
            header('Location: ../index.php?codigoQR=1');
        }



        $query = 'SELECT qr.Titulo, qr.Duracion , us.Nombre, tpd.TipoDocumento, us.Ndocumento, us.FechaNacimiento, eps.NombreEps, us.Telefono , us.Correo, gn.Genero ,est.Estrato, lc.Localidad,af.Afiliacion, RH.RH, tps.TipoSangre , dta.CondicionClinica, dta.arraycond, alg.AlergiaMedicamento
        FROM usuario AS us LEFT OUTER JOIN eps 
        ON eps.id = us.id 
        LEFT OUTER JOIN genero as gn 
        ON gn.IDGenero = us.Genero
        LEFT OUTER JOIN estrato as est 
        ON est.IDEstrato = us.Estrato
        LEFT OUTER JOIN localidad as lc 
        ON lc.IDLocalidad = us.Localidad
        LEFT OUTER JOIN tipodocumento as tpd
        ON tpd.IDTipoDoc = us.TipoDoc
        
        LEFT OUTER JOIN datos_clinicos AS dta
        ON us.Ndocumento= dta.NDocumento
        
        LEFT OUTER JOIN RH
        ON RH.IDRH = dta.RH
        LEFT OUTER JOIN TipoSangre as tps
        ON tps.IDTipoSangre = dta.Tipo_de_sangre
        LEFT OUTER JOIN AlergiaMedicamento as alg
        ON alg.IDAlergiaMedicamento = dta.AlergiaMedicamento
        LEFT OUTER JOIN afiliacion as af
        ON af.IDAfiliacion = dta.TipoAfiliacion
        
        LEFT OUTER JOIN codigo_qr as qr
        ON dta.IDDatosClinicos = qr.DatosClinicos
        WHERE qr.nombre = :nombre /* AND id_codigo = :idcode  */;';
        $params = $connection->prepare($query);
        $params->bindParam(':nombre', $form);
        /* $params->bindParam(':idcode', $id); */
        $params->execute();
        $data = $params->fetch(PDO::FETCH_ASSOC);
    } else {
        http_response_code(404);
        header('Location: ../../index.php');
    }

?>
<?php
$condicion = condicionClinica();
ob_start();
$imgLogo = "http://" . $_SERVER['HTTP_HOST'] . "/secodeqr/views/assets/img/nosotros.jpg ";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php //include('../templates/header.php')
    ?>
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
            <img src="https://programacion3luis.000webhostapp.com/secode/views/assets/img/logo.png" alt="" style="
        width: 30px;height: 30px; object-fit: cover;float: right;">
        </h2>


    </div>
    <center>
        <hr width="15%" style="background:rgb(74, 69, 92); height: 5px; border-radius: 5px; ">
    </center>
    <div>
        <h2 style="text-align: center;">Datos:</h2>

        <?php foreach ($data as $key => $value) {  ?>

            <p style="padding:5px;background:#d0d3ec; color:black">
                <spam style="color:#5d2aaf;font-weight: bold;"> <?php if ($key == "arraycond") {
                                                                    echo '';
                                                                } else {
                                                                    echo $key;
                                                                } ?> </spam>
                <?php if ($key == "arraycond") {
                    foreach ($condicion as $keycond => $valuecond) {
                        $datarray = json_decode($value, true);
                        $arrayName = array();
                        foreach ($datarray as $keydat => $valuedat) {
                            $arrayName += array($keydat => $valuedat);
                        }
                        //var_dump($arrayName);
                        if (in_array($valuecond['CondicionClinica'], $arrayName)) {
                            $checked = 'checked';
                        } else {
                            $checked = '';
                        } ?>

            <div>
                <input type="checkbox" value="<?= $valuecond['IDCondicionClinica'] ?>" id="<?= $valuecond['CondicionClinica'] . $keycond ?>" name="<?= $key ?>" <?= $checked ?> required />
                <label for="<?= $valuecond['CondicionClinica'] . $keycond ?>" class="check"><span><?= $valuecond['CondicionClinica'] ?></span></label>
            </div>
    <?php }
                } ?>

    <?php if ($key == "arraycond") {
                echo '';
            } else {
                echo $value;
            } ?>
    </p>


<?php  } ?>

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
</body>

</html>


<?php

$html_doc = ob_get_clean();

require_once '../../vendor/autoload.php';

// reference the Dompdf namespace

use Dompdf\Dompdf;
// instantiate and use the dompdf class

$dompdf = new Dompdf();
$dompdf->loadHtml($html_doc);

$options = $dompdf->getOptions();;
$options->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options);

//$dompdf->setPaper('A4', 'landscape');
$dompdf->setPaper('A4');

// Render the HTML as PDF
$doc = $dompdf->render();


// Output the generated PDF to Browser
$dompdf->stream('archivo.pdf', array('Attachment' => false));





//$output = $dompdf->output();

?>