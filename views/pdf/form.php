<?php


session_start();

require_once '../../models/database/database.php';
require_once '../../models/user.php';


    if (isset($_GET['formulario'])) {
        $form = $_GET['formulario'];

        $data=$connection->prepare('SELECT * FROM codigo_qr WHERE nombre = :nombre');
        $data->execute([':nombre' => $form]);
        $dataQR = $data->fetch(PDO::FETCH_ASSOC);
        $numQr = $data->rowCount();
        $qr = $data->fetch(PDO::FETCH_ASSOC);
        if($numQr < 1 ){
            http_response_code(404);
            header('Location: ../index.php?codigoQR=1');
        }

        $id = $dataQR['id_codigo'];

        if ($dataQR['FormularioMedicamentos'] != null && $dataQR['FormularioMedicamentos'] != '') {
            $query = 'SELECT qr.Titulo, qr.Duracion , us.Nombre, tpd.TipoDocumento, us.Ndocumento, us.FechaNacimiento, eps.NombreEps, us.Telefono , us.Correo, us.Genero ,us.Estrato, us.Localidad, form.ArchivoFormulaMedica
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
        $query = 'SELECT qr.Titulo, qr.Duracion , us.Nombre, tpd.TipoDocumento, us.Ndocumento, us.FechaNacimiento, eps.NombreEps, us.Telefono , us.Correo, us.Genero ,est.Estrato, us.Localidad,af.Afiliacion, dta.RH, dta.Tipo_de_sangre , dta.CondicionClinica, dta.arraycond, dta.AlergiaMedicamento
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
        WHERE qr.nombre = :nombre  AND id_codigo = :idcode  ;';
        $params = $connection->prepare($query);
        $params->bindParam(':nombre', $form);
        $params->bindParam(':idcode', $id); 
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
#$data = getClinicData($_SESSION['user_id'], false, $qr['id_codigo']);
$afiliacion = afiliacion();
$rh = rh();
$tipoSangre = tipoSangre();
$condicion = condicionClinica();
$alergia = alergia();
$estrato = estrato();
$localidad = localidad();
$eps = eps();
ob_start();
$imgLogo = "http://" . $_SERVER['HTTP_HOST'] . "/secodeqr/views/assets/img/logo.png";
$imgLogo2 = "http://" . $_SERVER['HTTP_HOST'] . "/secodeqr/views/assets/img/imgb.png";
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<!--     <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <!-- favicon -->
	<link rel="shortcut icon" type="image/png" href="<?= 'http://'. $_SERVER['HTTP_HOST']. '/secodeqr/views/assets/img/logo.png'?>">
	<link rel="stylesheet" href="<?= 'http://'. $_SERVER['HTTP_HOST']. '/secodeqr/views/assets/css/all.min.css'?>">
	<link rel="stylesheet" href="<?= 'http://'. $_SERVER['HTTP_HOST']. '/secodeqr/views/assets/bootstrap/css/bootstrap.min.css'?>">
	<link rel="stylesheet" href="<?= 'http://'. $_SERVER['HTTP_HOST']. '/secodeqr/views/assets/css/animate.css'?>">
	<link rel="stylesheet" href="<?= 'http://'. $_SERVER['HTTP_HOST']. '/secodeqr/views/assets/css/meanmenu.min.css'?>">
	<link rel="stylesheet" href="<?= 'http://'. $_SERVER['HTTP_HOST']. '/secodeqr/views/assets/css/main.css'?>">
	<link rel="stylesheet" href="<?= 'http://'. $_SERVER['HTTP_HOST']. '/secodeqr/views/assets/css/responsive.css'?>">
    <link rel="stylesheet" href="<?= 'http://'. $_SERVER['HTTP_HOST']. '/secodeqr/views/assets/css/formstyle.css'?>">
<script src="https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
    <title>Formulario</title>

</head>

<body>

<body >

  <!-- Formulario -->
  <div class="container_formd" style="margin: 2rem; border: 5px solid black; height:100%; max-height:98%">
  <br>
  <center>
<img src="<?= $imgLogo2?>" alt="">
<img src="<?= $imgLogo?>" alt="" width="100px" >
<!-- style="position:absolute; right:9.5em; top:6.7em;" -->
</center>
    <div class="screend">
      <div class="container" style="margin-left: 2rem;">
        <form action="" method="POST" class="form" style="margin:0 auto;">
            <?php foreach ($data as $key => $value) { ?>
              <?php
              switch ($key) {
                case 'Titulo': ?>
                  <div class="item">
                    <p>Titulo del formulario</p>
                    <br>
                    <input type="text" name="<?= $key ?>" value="<?php if ($value == null || ''){echo 'Sin Titulo';}else{echo $value;} ?>" />
                  </div>
                  <?php break; ?>
                <?php
                case 'NombreEps': ?>
                  <h5>1. Datos generales</h5>
                  <div class="item">
                    <p>EPS<span class="required">*</span></p>

                    <select class="form-control" name='<?= $key ?>'>
                      <?php if (true) { ?>
                        <?php foreach ($eps as $keyEps => $valueEPS) {  ?>

                          <?php if ($valueEPS['NombreEps'] == $value) { ?>
                            <option value="<?php echo $valueEPS['id'] ?>" selected><?php echo $valueEPS['NombreEps'] ?></option>
                          <?php } else {
                          ?>
                            <option value="<?php echo $valueEPS['id'] ?>"><?php echo $valueEPS['NombreEps'] ?></option>
                          <?php } ?>

                        <?php } ?>
                      <?php } else {  ?>
                        <option value="<?php echo $value ?>"><?php echo $value ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <?php break; ?>
                <?php
                case 'Genero': ?>
                  <div class="question">
                    <p>Genero<span></span></p>

                    <select class="form-control" id="<?= $key ?>" name="<?= $key ?>">
                      <option value="1" <?php if ($value === '1') {
                                          echo 'selected';
                                        } ?>>Masculino</option>
                      <option value="2" <?php if ($value === '2') {
                                          echo 'selected';
                                        } ?>>Femenino</option>
                    </select>

                  </div>
                  <?php break; ?>
                <?php
                case 'Estrato': ?>
                  <div class="item">
                    <p>Estrato<span></span></p>

                    <select class="form-control" id="<?= $key ?>" name="<?= $key ?>">
                      <?php foreach ($estrato as $keylocalidad => $valuelocalidad) { ?>
                        <option value="<?= $valuelocalidad['IDEstrato'] ?>" <?php if ($value === $valuelocalidad['IDEstrato']) {echo 'selected';} ?>>
                          <?= $valuelocalidad['Estrato'] ?></option>
                      <?php } ?>
                    </select>

                  </div>
                  <?php break; ?>
                  <?php
                case 'Localidad': ?>
                  <div class="item">
                    <p>Localidad<span></span></p>
                    <select class="form-control" id="<?= $key ?>" name="<?= $key ?>">
                      <?php foreach($localidad as $keylocalidad=> $valuelocalidad){?>
                              <option value="<?= $valuelocalidad['IDLocalidad']?>" 
                              <?php if ($value === $valuelocalidad['IDLocalidad']) {echo 'selected'; } ?>>
                              <?= $valuelocalidad['Localidad']?></option>
                      <?php }?>
                    </select>

                  </div>
                  <?php break; ?>
                <?php
                case 'TipoAfiliacion': ?>
                  <br>
                  <h5>2. Socio economico</h5>
                  <br>
                  <div class="question">
                    <p>Tipo de afiliacion con la EPS <span class="required">*</span></p>
                    <div class="question-answer">

                      <?php foreach ($afiliacion as $keyAf => $valueAf) { ?>
                        <?php if ($valueAf['IDAfiliacion'] == $value) { ?>
                          <input type="radio" value="<?= $valueAf['IDAfiliacion'] ?>" id="<?= $valueAf['IDAfiliacion'] ?>" name="<?= $key ?>" required checked />
                          <label for="<?= $valueAf['IDAfiliacion'] ?>" class="radio"><span><?= $valueAf['Afiliacion'] ?></span></label>
                        <?php } else { ?>
                          <input type="radio" value="<?= $valueAf['IDAfiliacion'] ?>" id="<?= $valueAf['IDAfiliacion'] ?>" name="<?= $key ?>" required />
                          <label for="<?= $valueAf['IDAfiliacion'] ?>" class="radio"><span><?= $valueAf['Afiliacion'] ?></span></label>
                        <?php } ?>

                      <?php } ?>
                    </div>
                  </div>
                  <?php break; ?>

                <?php
                case 'RH': ?>
                  <br>
                  <h5>1.Datos clinicos:</h5>
                  <div class="question">
                    <p>RH<span class="required"></span></p>
                    <div class="question-answer">


                      <?php foreach ($rh as $keyrh => $valuerh) { ?>
                        <?php if ($valuerh['IDRH'] == $value) { ?>
                          <input type="radio" value="<?= $valuerh['IDRH'] ?>" id="<?= $valuerh['IDRH'] . $keyrh ?>" name="<?= $key ?>" required checked />
                          <label for="<?= $valuerh['IDRH'] . $keyrh ?>" class="radio"><span><?= $valuerh['RH'] ?></span></label>
                        <?php } else { ?>
                          <input type="radio" value="<?= $valuerh['IDRH'] ?>" id="<?= $valuerh['IDRH'] . $keyrh ?>" name="<?= $key ?>" required />
                          <label for="<?= $valuerh['IDRH'] . $keyrh ?>" class="radio"><span><?= $valuerh['RH'] ?></span></label>
                        <?php } ?>

                      <?php } ?>
                    </div>
                  </div>
                  <?php break; ?>

                <?php
                case 'Tipo_de_sangre': ?>
                  <div class="question">
                    <p>Tipo de sangre<span class="required"></span></p>
                    <div class="question-answer">



                      <?php foreach ($tipoSangre as $keytps => $valuetps) { ?>
                        <?php if ($valuetps['IDTipoSangre'] == $value) { ?>
                          <input type="radio" value="<?= $valuetps['IDTipoSangre'] ?>" id="<?= $valuetps['TipoSangre'] . $keytps ?>" name="<?= $key ?>" required checked />
                          <label for="<?= $valuetps['TipoSangre'] . $keytps ?>" class="radio"><span><?= $valuetps['TipoSangre'] ?></span></label>
                        <?php } else { ?>
                          <input type="radio" value="<?= $valuetps['IDTipoSangre'] ?>" id="<?= $valuetps['TipoSangre'] . $keytps ?>" name="<?= $key ?>" required />
                          <label for="<?= $valuetps['TipoSangre'] . $keytps ?>" class="radio"><span><?= $valuetps['TipoSangre'] ?></span></label>
                        <?php } ?>

                      <?php } ?>
                    </div>
                  </div>
                  <?php break; ?>

                <?php
                case 'arraycond': ?>
                  <div class="question">
                    <p>¿Cuenta con alguna de las siguientes condiciones?:<span class="required">*</span></p>
                    <br>
                    <div class="question-answer checkbox-item">


                      <?php foreach ($condicion as $keycond => $valuecond) { ?>

                        <?php if ($value == null || $value == '') { ?>

                          <div>
                            <input type="checkbox" value="<?= $valuecond['IDCondicionClinica'] ?>" id="<?= $valuecond['CondicionClinica'] . $keycond ?>" name="<?= $key ?>" required />
                            <label for="<?= $valuecond['CondicionClinica'] . $keycond ?>" class="check"><span><?= $valuecond['CondicionClinica'] ?></span></label>
                          </div>

                        <?php } //falta guardar datso en array y luego pasarlos a la base de datos

                        else {
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
                          }
                        ?>
                          <div>
                            <input type="checkbox" value="<?= $valuecond['IDCondicionClinica'] ?>" id="<?= $valuecond['CondicionClinica'] . $keycond ?>" name="<?= $key ?>" <?= $checked ?> required />
                            <label for="<?= $valuecond['CondicionClinica'] . $keycond ?>" class="check"><span><?= $valuecond['CondicionClinica'] ?></span></label>
                          </div>
                      <?php }
                      } ?>

                    </div>
                  </div>
                  <?php break; ?>

                <?php
                case 'AlergiaMedicamento': ?>
                  <br>
                  <div class="question">
                    <p>¿Es alergico algun medicamento? ¿O tiene alguna afectacion?<span class="required"></span></p>
                    <br>
                    <div class="question-answer">

                      <?php foreach ($alergia as $keyal => $valueal) { ?>
                        <?php if ($valueal['IDAlergiaMedicamento'] == $value) { ?>
                          <input type="radio" value="<?= $valueal['IDAlergiaMedicamento'] ?>" id="<?= $valueal['AlergiaMedicamento'] . $keyal ?>" name="<?= $key ?>" required checked />
                          <label for="<?= $valueal['AlergiaMedicamento'] . $keyal ?>" class="radio"><span><?= $valueal['AlergiaMedicamento'] ?></span></label>
                        <?php } else { ?>
                          <input type="radio" value="<?= $valueal['IDAlergiaMedicamento'] ?>" id="<?= $valueal['AlergiaMedicamento'] . $keyal ?>" name="<?= $key ?>" required />
                          <label for="<?= $valueal['AlergiaMedicamento'] . $keyal ?>" class="radio"><span><?= $valueal['AlergiaMedicamento'] ?></span></label>
                        <?php } ?>
                      <?php } ?>
                    </div>
                  </div>
                  <br>
                  <?php break; ?>
                  <? case 'Duracion':?>
                  <p style="font-weight: bold;">Fecha de Creacion:</p>
                  <br>
                  <p style="padding:5px; border: 1px solid grey; min-width:12rem; width:min-content"><?=$value?></p>
                  <?php break; ?>
                  <?php break; ?>
                  <? case 'CondicionClinica':?>
                  <?php break; ?>
                  <?php case 'ArchivoFormulaMedica':?>
                    <p style="font-weight: bold;">Archivo FormulaMedica</p>
                    <p> Archivo adjunto el la siguiente hoja </p>
                    <br>
                    <div class="page_break" style="page-break-before: always;">
                    <img src="<?= 'http://' . $_SERVER['HTTP_HOST'] . '/secodeqr/models/img/' . $value ?>" alt="" style="position: absolute; left:3rem; top:4rem; width:auto; max-width: 700px; height:auto; max-height:70rem; object-fit:scale-down;"> 
                  </div>
                    
                  <?php break; ?>
                <?php
                default: ?>
                  <div class="item">
                    <p style="font-weight: bold;"><?= $key ?></p>
                    <br>
                    <p style="padding:5px; border: 1px solid grey; min-width:12rem; width:min-content"><?=$value?></p>
                  </div>
              <?php break;
              } ?>

            <?php  } ?>
        </form>
      </div>
    </div>
    <div style="margin-left:3rem;position: absolute; bottom:2rem;">
    <p>Declinacion de responsabilidades y consentimiento de tratamiento de datos personales</p>
    <p> <a href="https://<?= $_SERVER['HTTP_HOST'] ?>/secodeqr/" >Secode QR</a> <?= date('Y')?> ©️ All rights reserved</p>
    </div>
  </div>



<!-- end formulario -->

    <!-- jquery -->
	<script src="<?= 'http://'. $_SERVER['HTTP_HOST']. '/secodeqr/views/assets/js/jquery-1.11.3.min.js'?>"></script>
	<script src="<?= 'http://'. $_SERVER['HTTP_HOST']. '/secodeqr/views/assets/bootstrap/js/bootstrap.min.js'?>"></script>
	<script src="<?= 'http://'. $_SERVER['HTTP_HOST']. '/secodeqr/views/assets/js/jquery.isotope-3.0.6.min.js'?>"></script>
	<script src="<?= 'http://'. $_SERVER['HTTP_HOST']. '/secodeqr/views/assets/js/jquery.magnific-popup.min.js'?>"></script>
	<script src="<?= 'http://'. $_SERVER['HTTP_HOST']. '/secodeqr/views/assets/js/jquery.meanmenu.min.js'?>"></script>
	<script src="<?= 'http://'. $_SERVER['HTTP_HOST']. '/secodeqr/views/assets/js/sticker.js'?>"></script>
	<script src="<?= 'http://'. $_SERVER['HTTP_HOST']. '/secodeqr/views/assets/js/main.js'?>"></script>
    <script>
       function addScript(url) {
    var script = document.createElement('script');
    script.type = 'application/javascript';
    script.src = url;
    document.head.appendChild(script);
}
addScript('https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js');
var element = document.getElementsByTagName('body')[0];
var opt = {
  margin:       0,
  filename:     'myfile.pdf',
  image:        { type: 'jpeg', quality: 0.98 },
  html2canvas:  { scale: 2 },
  jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
};
/* var worker = html2pdf().set(opt).from(element).save();
html2pdf(element); */
    </script>
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
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$doc = $dompdf->render();


// Output the generated PDF to Browser
$dompdf->stream('archivo.pdf', array('Attachment' => false));
 
 



//$output = $dompdf->output();

?>