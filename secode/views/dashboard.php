<?php
if(isset($_SESSION["Ndocumeto"])){

}else{
	header('Location: index.html');
}

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
			<?php
				include('./templates/navBar.php');
			?>
		
        </header>
        <main class="container">.,.,       
<!-- product section -->
<div class="product-section mt-150 mb-150 pt-4">
<div class="container pt-4 mb-5 center">
                <h1>
                    Mis codigos QR
                </h1>
            </div>
		<div class="container">
		

<?
foreach($codes as $code){

?>



			<div class="roww">
				<div class="col-lg-4 col-md-6 text-center">
					<div class="single-product-item">
						<div class="product-image">
							<a href="single-product.html"><img src="<?php //echo $code['url'] ?>" alt=""></a>
						</div>
						<h3><?php // echo $code['title'] ?></h3>
						<p class="product-price"><span><?php // echo $code['description'] ?></span> </p>
						<a href="cart.html" class="cart-btn"><i class="fas fa-pen"></i> opciones</a>
					</div>
				</div>
			</div>

<?   };?>   

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





?>