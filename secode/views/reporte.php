<?php
ob_start();
    $imgLogo= "http://".$_SERVER['HTTP_HOST']."/SECODE_QR/secode/views/assets/img/nosotros.jpg ";
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
</head>
<body>
    <h1 style="color: rgb(0, 183, 255) ;">Formulario usuario <?php ?></h1>

    <div style="border: 1px solid rgb(197, 5, 255);">
        <p>loremlfsdpofjdoighdfghdfuighjkdfhgjkdf</p>
        <p>loremlfsdpofjdoighdfghdfuighjkdfhgjkdf</p>
            <img src="<?php echo $imgLogo ?>">
    </div>

   
</body>
</html>


<?php

$html_doc=ob_get_clean();


require_once '../controller/dompdf/autoload.inc.php';

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
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream('archivo.pdf',array('Attachment'=>false));


?>