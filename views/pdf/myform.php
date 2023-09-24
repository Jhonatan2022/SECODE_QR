<?php
session_start();
require_once '../../models/database/database.php';
require_once '../../models/user.php';
if (isset($_GET['formulario'])) {
    $form = $_GET['formulario'];
    $data = $connection->prepare('SELECT * FROM codigo_qr WHERE nombre = :nombre');
    $data->execute([':nombre' => $form]);
    $dataQR = $data->fetch(PDO::FETCH_ASSOC);
    $numQr = $data->rowCount();
    if ($numQr < 1) {
        http_response_code(404);
        header('Location: ../index.php?codigoQR=1');
    }
    $id = $dataQR['id_codigo'];
    if ($dataQR['FormularioMedicamentos'] != null && $dataQR['FormularioMedicamentos'] != '') {
        $query = 'SELECT qr.Titulo, qr.Duracion , us.Nombre, tpd.TipoDocumento, us.Ndocumento, us.FechaNacimiento, eps.NombreEps, us.Telefono , us.Correo, gn.Genero ,est.Estrato, lc.Localidad, form.ArchivoFormulaMedica
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
            LEFT OUTER JOIN FormularioMedicamentos AS form
            ON us.Ndocumento = form.Ndocumento
            LEFT OUTER JOIN codigo_qr as qr
            ON form.IDFormularioMedicamentos = qr.FormularioMedicamentos
            WHERE qr.nombre = :nombre AND qr.id_codigo = :idcode';
        $params = $connection->prepare($query);
        $params->bindParam(':nombre', $form);
        $params->bindParam(':idcode', $id);
        $params->execute();
        $data = $params->fetch(PDO::FETCH_ASSOC);
        $Medico = true;
    } else {
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
        $Medico = false;
    }
} else {
    http_response_code(404);
    header('Location: ../../index.php');
}
?>
<?php
$condicion = condicionClinica();
ob_start();
$imgLogo = "http://" . $_SERVER['HTTP_HOST'] . "/secodeqr/views/assets/img/logo.png";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Formulario</title>
</head>
<body>
    <div style="max-width: 700px; margin:0 auto; ">
        <h2 style="padding: 10px; border-left: 10px solid rgb(255, 95, 95); background:rgb(222, 221, 228); font-family: Verdana, Geneva, Tahoma, sans-serif;
    font-family: 'Nunito', sans-serif;">
            <?php if ($Medico) : ?>
                Datos Formula Medica
            <?php else : ?>
                Datos Documento Clinico
            <?php endif; ?>
            <img src="<?= $imgLogo ?>" alt="" style="
        width: 30px;height: 30px; object-fit: cover;float: right;">
        </h2>
    </div>
        <hr width="15%" style="background:rgb(74, 69, 92); height: 5px; border-radius: 5px; ">
    <div>
        <h2 style="text-align: center;font-family: 'Nunito', sans-serif;">Datos:</h2>
        <?php foreach ($data as $key => $value) {  ?>
            <p style="padding:5px;background:#d0d3ec; color:black ;font-family: 'Nunito', sans-serif;">
                <spam style="color:#5d2aaf;font-weight: bold; font-family: 'Nunito', sans-serif;"> <?php if ($key == "arraycond") {
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
                } elseif ($key == 'ArchivoFormulaMedica') { ?>
        <img src="<?= 'http://' . $_SERVER['HTTP_HOST'] . '/secodeqr/models/img/' . $value ?>" alt="" style="width: 100%; height: auto; object-fit: cover;">
    <?php } ?>
    <?php if ($key == "arraycond" || $key == 'ArchivoFormulaMedica') {
                echo '';
            } else {
                echo $value;
            } ?>
    </p>
<?php  } ?>
<div ">
    <p>Declinacion de responsabilidades y consentimiento de tratamiento de datos personales</p>
    <p> <a href=" https://<?= $_SERVER['HTTP_HOST'] ?>/secodeqr/">Secode QR</a> <?= date('Y') ?> ©️ All rights reserved</p>
</div>
    </div>
    </div>
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
?>