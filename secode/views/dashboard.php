<?php
//if(isset($_SESSION[""]))

require '../controller/phpqrcode/qrlib.php';
//require '../controller/phpqrcode/bindings/tcpdf/qrcode.php';

$dir = '../controller/temp/';

if(!file_exists($dir)) 
	mkdir($dir);

$filename = $dir.'test.png';

//Parametros de Configuración
	
$tamaño = 10; //Tamaño de Pixel
$level = 'H'; //Precisión Baja
$framSize = 3; //Tamaño en blanco
$contenido = "como es"; //Texto

	//Enviamos los parametros a la Función para generar código QR 
QRcode::png($contenido, $filename, $level, $tamaño, $framSize); 

	//Mostramos la imagen generada
//echo '<img src="'.$dir.basename($filename).'" /><hr/>';  


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

include('./templates/footer.php')
?>
        
    </div>
</body>

</html>