<?php
//if(isset($_SESSION[""]))

ob_start();


//apis de generacion del qr
'http://api.qrserver.com/v1/create-qr-code/?data=HelloWorld!&size=100x100&charset-source=UTF-8&color=0-0-255&bgcolor=00ff00&margen=10';
'https://quickchart.io/qr?text=jkdhkfjhdskfjhsdkfjhsdkjfhsdlkfjhsdkfjhsdklfjhsdkjfhsdkfjhsd%27s%20my%20text&centerImageUrl=https://raw.githubusercontent.com/luis-fer993/Pineapple-editor/master/img-pineappple.png&dark=a06800&light=f52fff&size=300&ecLevel=H&centerImageWidth=30&centerImageHeight=30';


?>




<!DOCTYPE html>
<html lang="en">

<head>
<?php
include('./templates/header.php');
?>
<body>

	<!--PreLoader-->
    <div class="loader">
		<div class="inner"></div>
		<div class="inner"></div>
		<div class="inner"></div>
		<div class="inner"></div>
		<div class="inner"></div>
	</div>
    <!--PreLoader Ends--> 
    <div class=container">

        <header>
            	<!-- header -->
	<div class="top-header-area" id="sticker">
		<div class="container bg-primary">
			<div class="row">
				<div class="col-lg-12 col-sm-12 text-center">
					<div class="main-menu-wrap">

						<!-- menu start -->
						<nav class="main-menu ">
							<ul>
								<li class="current-list-item"><a href="index.html">Inicio</a></li>
								<li><a href="nosotros.html">Quienes Somos</a></li>	
								<li><a href="#">Noticias</a>
									<ul class="sub-menu">
										<li><a href="noticias.html">Noticias</a></li>
										<li><a href="noticia.html">Noticia Del día</a></li>
									</ul>
								</li>
								<li><a href="contact.html">Contáctanos</a></li>
								<li><a href="#">Solicitar Código</a>
								<ul class="sub-menu">
									<li><a href="clinico.html">Datos Clinicos</a>
									</li>
								</ul>
								<li class="login-box"><a href="#">
									<span></span>
									<span></span>
									<span></span>
									<span></span> SECODE_QR PLUS </a></li>
							</ul>
						</nav>	
						<div class="mobile-menu"></div>
						<!-- menu end -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end header -->
        </header>

        <main class="container">

            
<!-- product section -->
<div class="product-section mt-150 mb-150 pt-4">
		<div class="container">
		<div class="container pt-4">
                <h1>
                    Mis codigos QR
                </h1>
            </div>
			<div class="roww">
				<div class="col-lg-4 col-md-6 text-center">
					<div class="single-product-item">
						<div class="product-image">
							<a href="single-product.html"><img src="<?php echo $dir.basename($filename) ?>" alt=""></a>
						</div>
						<h3>name qr</h3>
						<p class="product-price"><span>QR Para solicitar datos básicos <br> de la persona</span> </p>
						<a href="cart.html" class="cart-btn"><i class="fas fa-pen"></i> opciones</a>
					</div>
				</div>
			</div>

           

		</div>
	</div>
	<!-- end product section -->

        </main>

<?php

include('./templates/footerWebUser.php')
?>
        
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