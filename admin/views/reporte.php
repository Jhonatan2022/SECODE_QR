<?php
session_start();
require_once('../../vendor/autoload.php');
require_once('../../models/database/database.php');
require_once('../../models/user.php');

//SQL para consultas Empleados
$fechaInit = date("Y-m-d", strtotime($_POST['fechaCreacion']));
$fechaFin  = date("Y-m-d", strtotime($_POST['fechaCreacion']));


$alluser='SELECT 
us.Ndocumento,tipdoc.TipoDocumento,us.Nombre,us.Apellidos,us.Correo,tipsus.TipoSuscripcion, sus.FechaExpiracion ,us.Direccion,lc.Localidad, gn.Genero, estr.Estrato, eps.NombreEps, rl.rol, us.FechaNacimiento,us.Telefono, us.Img_perfil, us.token_reset, us.TipoImg
FROM usuario AS us
LEFT OUTER JOIN tipodocumento AS tipdoc
ON us.TipoDoc = tipdoc.IDTipoDoc
LEFT OUTER JOIN genero AS gn
ON us.Genero = gn.IDGenero
LEFT OUTER JOIN estrato AS est 
ON us.Estrato = est.IDEstrato
LEFT OUTER JOIN rol AS rl
ON us.rol = rl.id
LEFT OUTER JOIN localidad AS lc
ON us.Localidad = lc.IDLocalidad

LEFT OUTER JOIN Suscripcion as sus
ON sus.Ndocumento = us.Ndocumento
LEFT OUTER JOIN TipoSuscripcion AS tipsus
ON sus.TipoSuscripcion = tipsus.IDTipoSuscripcion

LEFT OUTER JOIN eps 
ON us.id = eps.id
LEFT OUTER JOIN estrato AS estr 
ON us.Estrato = estr.IDEstrato';
$alluser=$connection->prepare($alluser);
$alluser->execute();
$alluser=$alluser->fetchAll(PDO::FETCH_ASSOC);
$query = $connection->prepare('SELECT us.Ndocumento,us.Nombre,us.Correo,us.fechaCreacion ,tipsus.TipoSuscripcion 
FROM usuario AS us LEFT OUTER JOIN Suscripcion as sus
ON sus.Ndocumento = us.Ndocumento LEFT OUTER JOIN 
TipoSuscripcion AS tipsus ON sus.TipoSuscripcion = tipsus.IDTipoSuscripcion 
WHERE (fechaCreacion>=:fechaIni) ORDER BY fechaCreacion ASC');
$query->bindParam(':fechaIni', $fechaInit);
$query->execute();
$usuario = $query->fetchAll(PDO::FETCH_ASSOC);
$alluserA =[];
?>
<?php ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>Reporte</title>
</head>
<body>
    <h1>Reporte de usuario</h1>
    <?foreach($usuario as  $usu){ ?>
    <table border='2px' style="max-width: 90vw;">
        
        <tr>
            <?foreach($usu as  $us => $value){ ?>
                <th><?php echo $us ?></th>
            <?php }?>
        </tr>
        <tr>
        <tr>
            <?foreach($usu as  $us => $value){ ?>
                <td><?php echo $value ?></td>
                <?php } ?>
        </tr>
        <tr>
            
    </table>
                <br>
                <br>
                <br>
<?php }?>
        

            <style>
                table{
                    background-color: green;
                }
            </style>


    <h2>usuarios</h2>

    <?foreach($alluserA as  $allus){ ?>
                <table border='2px' style="max-width: 90vw;">
                    <tr>
                        <?foreach($allus as  $user => $values){ ?>
                            <th><?php echo $user ?></th>
                        <?php }?>
                    </tr>
                    <tr>
                    <tr>
                        <?foreach($allus as  $user => $values){ ?>
                            <td><?php echo $values ?></td>
                            <?php } ?>
                    </tr>
                    <tr>
                </table>
                <br>
                <br>
            <?php }?>

<style>
    table{
        border: 1px solid black;
        width: 100%;
    }
    th,td{
        border: 1px solid black;
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
</style>
    
</body>
</html>
<?php
$html_doc=ob_get_clean();

// reference the Dompdf namespace
use Dompdf\Dompdf;
// instantiate and use the dompdf class


$dompdf = new Dompdf();
$dompdf->loadHtml($html_doc);

$options=$dompdf->getOptions();;
$options->set(array('isRemoteEnabled'=>true));
$dompdf->setOptions($options);

$dompdf->setPaper('legal', 'landscape');
//$dompdf->setPaper('A4','portrait');

// Render the HTML as PDF
$doc=$dompdf->render();

$output = $dompdf->output();
//file_put_contents('reporte.pdf', $output);

// Output the generated PDF to Browser
$dompdf->stream("reporte.pdf",array("Attachment"=>0));


?>