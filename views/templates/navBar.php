<!-- header -->
<div class="top-header-area" id="sticker">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-sm-12 text-center">
				<div class="main-menu-wrap">
					<!-- logo -->
					<div class="site-logo">
						<a href="index.php">
							<img src="assets/img/logo.png" alt="">
						</a>
					</div>
					<!-- logo -->
					<!--boton de inicio-->
					<div class="site-logo">
						<a class="button--secondary" href="index.php">
							<span class="text">INICIO</span>
							<span class="icon-arrow"></span>
						</a>
					</div>
					<!--boton de inicion end-->
					<!-- menu start -->
					<nav class="main-menu ">

						<ul>

							<li><a href="nosotros.html">Quienes Somos</a></li>
							<li><a href="contact.html">Contáctanos</a></li>
							<li><a href="#">Solicitar Código</a>
								<ul class="sub-menu">
									<li><a href="clinico.php">Datos Clinicos</a>
									</li>
								</ul>
							</li>
							<?php if (isset($_SESSION['user_id'])) { ?>
								<li id='button-exit' class="user">
									<img src="<?= $user['Img_perfil'] ?>" alt="">
									<code> <?= $user['Nombre'] ?></code>
									<ul class="sub-menu">
										<li><a href="perfil.php">Mi perfil</a></li>
										<li><a href="dashboard.php">Mis documentos</a></li>
										<li><a href="../controller/exit/">salir</a></li>
									</ul>
								</li>

							<?php } ?>

							<li class="login-box"><a href="servicios.php">
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

<style>
	.user img {
		width: 40px;
		height: 40px;
		border-radius: 50%;
		object-fit: cover;
		border: 2px solid #fff;
	}

	.user code {
		color: #fff;
		font-size: 1.2rem;
		margin: 0;
		display: inline-block;
	}

	@media screen and (max-width: 990px) {
		.user img {
			display: none;
		}
	}
</style>