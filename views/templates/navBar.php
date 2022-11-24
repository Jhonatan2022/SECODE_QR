<!-- header -->
    <div class="top-header-area" id="sticker">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-sm-12 text-center">
					<div class="main-menu-wrap">
						<!-- logo -->
						<div class="site-logo">
                            <a href="index.html">
                                <img src="assets/img/logo.png" alt="">
                            </a>
                        </div>
						<!-- logo -->

						<!-- menu start -->
						<nav class="main-menu ">

							<ul>
								<li class="current-list-item"><a href="index.php">Inicio</a></li>
								<li><a href="nosotros.html">Quienes Somos</a></li>	
								<li><a href="contact.html">Contáctanos</a></li>
								<li><a href="#">Solicitar Código</a>
								<ul class="sub-menu">
									<li><a href="clinico.php">Datos Clinicos</a>
									</li>
								</ul>
								<?php if (isset($_SESSION['user_id'])){ ?>
										<li id='button-exit'><a href="../controller/exit/">salir</a>
								<?php } ?>
								<li class="login-box"><a href="../servicios.html">
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