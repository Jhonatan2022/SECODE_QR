<?php
session_start();

/*
clase
*/

if (isset($_SESSION['Ndocumento'])) {
  header('Location: ./iniciar.php');
}

//importamos conexion base de datos
require '../models/database/database.php';

//si el usuario va a iniciar sesion
if (!empty($_POST['email']) && !empty($_POST['password'])) {

  $email_user = $_POST['email'];
  $password_user = $_POST['password'];

  if (filter_var($email_user, FILTER_VALIDATE_EMAIL)) {

    $consult = " SELECT Correo, Contrasena,Ndocumento FROM usuario WHERE Correo= :correo";
    $parametros = $connection->prepare($consult);
    $parametros->bindParam(':correo', $email_user);
    $parametros->execute();
    $results = $parametros->fetch(PDO::FETCH_ASSOC);

    try {
      if (count($results) > 0 && password_verify($password_user, $results['Contrasena'])) {
        $_SESSION['Ndocumento'] = $results['Ndocumento'];
        echo `<script>Swal.fire(
                    'Good job!',
                    'You clicked the button!',
                    'success'
                    )</script>`;
        header("Location: ./index.html");
      } else {
        echo '<script>alert("Datos ingresados erroneos")</script>';
      }
    } catch (Exception $e) {
      echo '<script>alert("Ocurrio un error.$e")</script>';;
    }
  } else {
    echo "<script>alert('Correo no valido. intente de nuevo.')</script>";
  }
} //si el usuario va a registrarse
elseif (!empty($_POST['num-doc']) && !empty($_POST['user-email']) && !empty($_POST['user-password']) && !empty($_POST['user-name'])) {

  //variables de datos ingresados
  $email_user = $_POST['user-email'];
  $numdoc = intval($_POST['num-doc']);
  $password_user = $_POST['user-password'];
  $name_user = $_POST['user-name'];

  if (filter_var($email_user, FILTER_VALIDATE_EMAIL)) {

    //consulta que verifica la existencia de el correo ingresado
    $consult = "SELECT Correo FROM usuario WHERE Correo= :useremail ";
    $params = $connection->prepare($consult);
    $params->bindParam(':useremail', $email_user);

    //consulta que verifica la existencia de el documeto ongresado ingresado
    $consult1 = "SELECT Ndocumento FROM usuario WHERE Ndocumento = :numdoc ";
    $params1 = $connection->prepare($consult1);
    $params1->bindParam(':numdoc', $numdoc);

    $ok = ($params->execute()) &&  ($params1->execute());

    if ($ok) { //ejecucion consulta

      $results1 = $params->fetch(PDO::FETCH_ASSOC);
      $results2 = $params1->fetch(PDO::FETCH_ASSOC);

      //si el resultado de la consulta es igual al del ingresado
      if (  strtolower($results1["Correo"]) == strtolower($email_user) ) {
        $message = 'Correo registrado, revise e intente de nuevo';
      } elseif ($results2["Ndocumento"] == $numdoc) {
        $message = 'Numero de documento registrado, revise e intente de nuevo';
      } else //si no, entonces se puede registrar al usuario.
      {
        $consult = "INSERT INTO usuario (Ndocumento, Nombre,direccion,Genero,Correo,Contrasena,FechaNacimineto,id,Img_perfil) VALUES (:ndoc, :username, null, null, :useremail, :userpassword, null, :ideps, null)";
        $params = $connection->prepare($consult);
        $params->bindParam(':useremail', $email_user);
        $password = password_hash($password_user, PASSWORD_BCRYPT);
        $params->bindParam(':userpassword', $password);
        $params->bindParam(':username', $name_user);
        $id_eps = 10;
        $params->bindParam(':ideps', $id_eps);
        $params->bindParam(':ndoc', $numdoc);
        //estabklecemos los parametros de la consulta

        if ($params->execute()) {
          echo ' <div class="alert" style="background:#2eb885;">
        <span class="closebtn" onclick="this.parentElement.style.display="none";">&times;</span>
        Realizado correctamente, usuario registrado, inicie sesión, para continuar...
        </div>
        ';
          //echo "<script> setTimeout(\"location.href='inicio-secion.php'\",10000);</script>";
        } else {
          $message = 'Perdon hubo un error al crear el usuario';
        }
      }
    } else {
      $message = 'Perdon hubo un error al crear el usuario';
    }
  } else {
    echo "<script>alert('Correo no valido. intente de nuevo.')</script>";
  }
}
?>





<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Iniciar y registrar</title>
  <!-- fontawesome -->
  <link rel="stylesheet" href="assets/css/all.min.css">
  <!-- estilos -->
  <link rel="stylesheet" href="assets/css/styles.css" />
  <!-- favicon -->
  <link rel="shortcut icon" type="image/png" href="./assets/img/logo.png">
  <link rel="stylesheet" href="npm i bootstrap-icons">
  <!-- google font -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
  <!-- fontawesome -->

  <!-- jQuery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css"/>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>

  
</head>


  <style>
    button {
  background: none;
  color: rgb(0, 0, 0);
  border: 0;
  font-size: 18px;
  font-weight: 500;
  cursor: pointer;
}

.terminos {
        max-width: 90%;
        margin: auto;
        color: black;
        text-align: justify;
        font-size: 18px;
      }

      b {
        font-size: 30px;
        color: black;
        text-align: left;
      }
      
      button{
        font-size: 16px;
        margin-left: 5px;
      }

      u{
        margin-left: 10px
      }
  </style>

<body>

  <?php if (!empty($message)) : ?>

    <div class="alert">
      <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
      <?= $message ?>
    </div>

  <?php endif; ?>


  <!--PreLoader-->
  <div class="loader">
    <div class="inner"></div>
    <div class="inner"></div>
    <div class="inner"></div>
    <div class="inner"></div>
    <div class="inner"></div>
  </div>
  <!--PreLoader Ends-->
  <span class="fa fa-cloud-xmark"></span>
  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">

        <form action="./iniciar.php" method="POST" class="sign-in-form">
          <!-- logo -->
          <a href="index.html">
            <img src="assets/img/logo.png" alt=""> </a>
          <!-- logo -->
          <h2 class="title">Iniciar sesión</h2>
          <div class="input-field">
            <i class="fa fa-at"></i>
            <input type="email" name="email" placeholder="Correo" required />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" placeholder="Contraseña" required />
          </div>
          <input type="submit" value="Ingresar" class="btn solid" />
          <p class="social-text" onclick="resetPass();" style="cursor:pointer; padding:5px; outline:1px solid #a5f; ">Recuperar Contraseña.</p>
          <p class="social-text">Puedes iniciar con estas plataformas.</p>
          <div class="social-media">
            <a href="#" class="social-icon">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-google"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-linkedin-in"></i>
            </a>
          </div>
        </form>
        <form action="./iniciar.php" class="sign-up-form" method="POST">
          <!-- logo -->
          <a href="index.html">
            <img src="assets/img/logo.png" alt=""> </a>
          <!-- logo -->
          <h2 class="title">Registrarse</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Nombre completo" name="user-name" required />
          </div>
          <div class="input-field">
            <i class="fas fa-id-card"></i>
            <input type="text" placeholder="Numero Documento" name="num-doc" required />
          </div>
          <div class="input-field">
            <i class="fas fa-at"></i>
            <input type="email" placeholder="Email" name="user-email" required />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Password" name="user-password" required />
          </div>
          <input type="submit" class="btn" value="Registrar" />
          <button id="terminos"><input type="checkbox" required><u>Terminos y Condiciones</u></button>

          <p class="social-text">Puedes iniciar con estas plataformas.</p>
          <div class="social-media">
            <a href="#" class="social-icon">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-google"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-linkedin-in"></i>
            </a>
          </div>
        </form>
      </div>
    </div>

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h3>Eres nuevo ?</h3>
          <p>
            Oprime el botón para registrarte.
          </p>
          <button class="btn transparent" id="sign-up-btn">
            Registrarse
          </button>
        </div>
        <img src="./assets/img/log.svg" class="image" alt="" />
      </div>
      <div class="panel right-panel">
        <div class="content">
          <h3>Ya tienes cuenta ? </h3>
          <p>
            Oprime el botón para iniciar sesión.
          </p>
          <button class="btn transparent" id="sign-in-btn">
            Iniciar sesión
          </button>
        </div>
        <img src="./assets/img/register.svg" class="image" alt="" />
      </div>
    </div>
  </div>

  <script src="assets/js/app.js"></script>
  <!-- jquery -->
  <script src="assets/js/jquery-1.11.3.min.js"></script>
  <!-- main js -->
  <script src="assets/js/main.js"></script>
  <script>
    function getRandomInt(min, max) {
      return Math.floor(Math.random() * (max - min)) + min;
    }

    function resetPass() {
      setTimeout(`location.href=\'recupera\'`, 10000);
      /*let correo1 = prompt("Ingrese su correo: \n");
      const token = getRandomInt(333333, 5555555555555); 
      if (correo1 !== null && correo1 !== "" ){
        setTimeout(`location.href=\'recupera.php?user_correo=${correo1}&token=${token};\'`,1500);
      }else{
        alert("Correo No valido, ingrese nuevamente.")
      }
       */
    }

    $(document).on('click', '#terminos', function (e) {
	swal({
		html: `<p class="terminos"><br>
        Actualizado el 2022-08-24 <br /><br />

        <b>Términos generales</b> <br />
        <br />
        Al acceder y realizar un pedido con SECODE_QR, usted confirma que está
        de acuerdo y sujeto a los términos de servicio contenidos en los
        Términos y condiciones que se describen a continuación. Estos términos
        se aplican a todo el sitio web y a cualquier correo electrónico u otro
        tipo de comunicación entre usted y SECODE_QR. <br /><br />
        Bajo ninguna circunstancia el equipo de SECODE_QR será responsable de
        ningún daño directo, indirecto, especial, incidental o consecuente, que
        incluye, entre otros, la pérdida de datos o ganancias que surjan del uso
        o la incapacidad de usar, los materiales de este sitio, incluso si el
        equipo de SECODE_QR o un representante autorizado han sido informados de
        la posibilidad de tales daños. Si su uso de materiales de este sitio
        resulta en la necesidad de servicio, reparación o corrección de equipos
        o datos, usted asume los costos de los mismos. <br /><br />
        SECODE_QR no será responsable de ningún resultado que pueda ocurrir
        durante el curso del uso de nuestros recursos. Nos reservamos el derecho
        de cambiar los precios y revisar la política de uso de recursos en
        cualquier momento. <br /><br /><b> Licencia</b> <br /><br />
        SECODE_QR le otorga una licencia revocable, no exclusiva, intransferible
        y limitada para descargar, instalar y usar la website estrictamente de
        acuerdo con los términos de este Acuerdo. Estos Términos y condiciones
        son un contrato entre usted y SECODE_QR ("nosotros", "nuestro" o "nos")
        le otorga una licencia revocable, no exclusiva, intransferible y
        limitada para descargar, instalar y utilizar el sitio web estrictamente
        de acuerdo con los términos de este Acuerdo. <br /><br />

        <b>Definiciones y términos clave</b> <br /><br />
        Para ayudar a explicar las cosas de la manera más clara posible en estos
        Términos y Condiciones, cada vez que se hace referencia a cualquiera de
        estos términos, se definen estrictamente como: <br /><br />
        Cookie: pequeña cantidad de datos generados por un sitio web y guardados
        por su navegador web. Se utiliza para identificar su navegador,
        proporcionar análisis, recordar información sobre usted, como su
        preferencia de idioma o información de inicio de sesión. <br />
        Compañía: cuando estos Terminos mencionan "Compañía", "nosotros", "nos"
        o "nuestro", se refiere a SECODE_QR, Carrera 5 que es responsable de su
        información en virtud de estos Términos y Condiciones. <br />
        Plataforma: sitio web de Internet, aplicación web o aplicación digital
        de cara al público de SECODE_QR. <br />
        País: donde se encuentra SECODE_QR o los propietarios / fundadores de
        SECODE_QR en este caso es Colombia. <br />
        Dispositivo: cualquier dispositivo conectado a Internet, como un
        teléfono, tablet, computadora o cualquier otro dispositivo que se pueda
        usar para visitar SECODE_QR y usar los servicios. <br />
        Servicio: se refiere al servicio brindado por SECODE_QR como se describe
        en los términos relativos (si están disponibles) y en esta plataforma.
        <br />
        Terceros: se refiere a anunciantes, patrocinadores de concursos, socios
        promocionales y de marketing, y otros que brindan nuestro contenido o
        cuyos productos o servicios que creemos que pueden interesarle. <br />
        Sitio web: el sitio de SECODE_QR al que se puede acceder a través de
        esta URL: https://jhonatan2022.github.io/SECODE_QR/secode/views/. <br />
        Usted: una persona o entidad que está registrada con SECODE_QR para
        utilizar los Servicios. <br /><br />

        <b>Restricciones</b><br><br>
        Usted acepta no hacerlo y no permitirá que otros: <br /><br />
        Licenciar, vender, alquilar, arrendar, asignar, distribuir, transmitir,
        alojar, subcontratar, divulgar o explotar comercialmente la plataforma o
        poner la plataforma a disposición de terceros. <br />
        Modificar, realizar trabajos derivados, desensamblar, descifrar,
        realizar una compilación inversa o realizar ingeniería inversa de
        cualquier parte de la plataforma. <br />
        Eliminar, alterar u ocultar cualquier aviso de propiedad (incluido
        cualquier aviso de derechos de autor o marca registrada) de sus
        afiliados, socios, proveedores o licenciatarios de la plataforma.
        <br /><br />

        <b>Política de Devolución y Reembolso</b> <br /><br />
        Gracias por comprar en SECODE_QR. Apreciamos el hecho de que le guste
        comprar las cosas que construimos. También queremos asegurarnos de que
        tenga una experiencia gratificante mientras explora, evalúa y compra
        nuestros productos. Al igual que con cualquier experiencia de compra,
        existen términos y condiciones que se aplican a las transacciones en
        SECODE_QR. Seremos tan breves como lo permitan nuestros abogados. Lo
        principal que debe recordar es que al realizar un pedido o realizar una
        compra en SECODE_QR, acepta los términos junto con la Política de
        privacidad de SECODE_QR. Si por alguna razón no está completamente
        satisfecho con algún bien o servicio que le brindamos, no dude en
        contactarnos y discutiremos cualquiera de los problemas que esté
        atravesando con nuestro producto. <br /><br />

        <b>Tus sugerencias</b><br /><br />
        Cualquier, comentario, idea, mejora o sugerencia (colectivamente,
        "Sugerencias") que usted proporcione a SECODE_QR con respecto a la
        plataforma seguirá siendo propiedad única y exclusiva de SECODE_QR.
        SECODE_QR tendrá la libertad de usar, copiar, modificar, publicar o
        redistribuir las Sugerencias para cualquier propósito y de cualquier
        manera sin ningún crédito o compensación para usted. <br /><br />

        <b>Tu consentimiento</b> <br /><br />
        Hemos actualizado nuestros Términos y condiciones para brindarle total
        transparencia sobre lo que se establece cuando visita nuestro sitio y
        cómo se utiliza. Al utilizar nuestra plataforma, registrar una cuenta o
        realizar una compra, por la presente acepta nuestros Términos y
        condiciones. <br /><br />

        <b>Enlaces a otros Sitios Web</b><br /><br />
        Estos Términos y Condiciones se aplican solo a los Servicios. Los
        Servicios pueden contener enlaces a otros sitios web que SECODE_QR no
        opera ni controla. No somos responsables por el contenido, la precisión
        o las opiniones expresadas en dichos sitios web, y dichos sitios web no
        son investigados, monitoreados o verificados por nuestra precisión o
        integridad. Recuerde que cuando utiliza un enlace para ir de los
        Servicios a otro sitio web, nuestros Términos y condiciones dejan de
        estar vigentes. Su navegación e interacción en cualquier otro sitio web,
        incluidos aquellos que tienen un enlace en nuestra plataforma, están
        sujetos a las propias reglas y políticas de ese sitio web. Dichos
        terceros pueden utilizar sus propias cookies u otros métodos para
        recopilar información sobre usted. <br /><br />

        <b>Cambios en nuestros Términos y Condiciones</b><br /><br />
        Usted reconoce y acepta que SECODE_QR puede dejar de brindarle (de forma
        permanente o temporal) el Servicio (o cualquier función dentro del
        Servicio) a usted o a los usuarios en general, a discreción exclusiva de
        SECODE_QR, sin previo aviso. Puede dejar de utilizar el Servicio en
        cualquier momento. No es necesario que informe específicamente a
        SECODE_QR cuando deje de usar el Servicio. Usted reconoce y acepta que
        si SECODE_QR deshabilita el acceso a su cuenta, es posible que no pueda
        acceder al Servicio, los detalles de su cuenta o cualquier archivo u
        otro material contenido en su cuenta. Si decidimos cambiar nuestros
        Términos y condiciones, publicaremos esos cambios en esta página y / o
        actualizaremos la fecha de modificación de los Términos y condiciones a
        continuación. <br /><br />

        <b>Modificaciones a nuestra plataforma</b> <br /><br />
        SECODE_QR se reserva el derecho de modificar, suspender o interrumpir,
        temporal o permanentemente, la plataforma o cualquier servicio al que se
        conecte, con o sin previo aviso y sin responsabilidad ante usted.
        <br /><br />

        <b>Actualizaciones a nuestra plataforma</b><br /><br />
        SECODE_QR puede, de vez en cuando, proporcionar mejoras a las
        características / funcionalidad de la plataforma, que pueden incluir
        parches, corrección de errores, actualizaciones, mejoras y otras
        modificaciones ("Actualizaciones"). Las actualizaciones pueden modificar
        o eliminar ciertas características y / o funcionalidades de la
        plataforma. Usted acepta que SECODE_QR no tiene la obligación de (i)
        proporcionar Actualizaciones, o (ii) continuar proporcionándole o
        habilitando características y / o funcionalidades particulares de la
        plataforma. Además, acepta que todas las Actualizaciones (i) se
        considerarán una parte integral de la plataforma y (ii) estarán sujetas
        a los términos y condiciones de este Acuerdo. <br /><br />

        <b>Servicios de Terceros</b><br><br>
        Podemos mostrar, incluir o poner a disposición contenido de terceros
        (incluidos datos, información, aplicaciones y otros servicios de
        productos) o proporcionar enlaces a sitios web o servicios de terceros
        ("Servicios de terceros"). Usted reconoce y acepta que SECODE_QR no será
        responsable de ningún Servicio de terceros, incluida su precisión,
        integridad, puntualidad, validez, cumplimiento de los derechos de autor,
        legalidad, decencia, calidad o cualquier otro aspecto de los mismos.
        SECODE_QR no asume ni tendrá ninguna obligación o responsabilidad ante
        usted o cualquier otra persona o entidad por los Servicios de terceros.
        Los Servicios de terceros y los enlaces a los mismos se brindan
        únicamente para su conveniencia y usted accede a ellos y los usa
        completamente bajo su propio riesgo y sujeto a los términos y
        condiciones de dichos terceros. <br /><br />

        <b>Duración y Terminación</b> <br /><br />
        Este Acuerdo permanecerá en vigor hasta que usted o SECODE_QR lo
        rescindan. SECODE_QR puede, a su entera discreción, en cualquier momento
        y por cualquier motivo o sin él, suspender o rescindir este Acuerdo con
        o sin previo aviso. Este Acuerdo terminará inmediatamente, sin previo
        aviso de SECODE_QR, en caso de que no cumpla con alguna de las
        disposiciones de este Acuerdo. También puede rescindir este Acuerdo
        eliminando la plataforma y todas las copias del mismo de su computadora.
        Tras la rescisión de este Acuerdo, deberá dejar de utilizar la
        plataforma y eliminar todas las copias de la plataforma de su
        computadora. La rescisión de este Acuerdo no limitará ninguno de los
        derechos o recursos de SECODE_QR por ley o en equidad en caso de
        incumplimiento por su parte (durante la vigencia de este Acuerdo) de
        cualquiera de sus obligaciones en virtud del presente Acuerdo.
      </p>`,
		imageUrl: "./assets/img/logo.png",
		position: "top",
		width: 1000,
		title: "Términos y Condiciones",
		text: "You will be redirected to https://utopian.io",
		confirmButton: true,
		confirmButtonText: "CONTINUE &rarr;",
		confirmButtonColor: "#4ba7cf",
		showCancelButton: true,
		cancelButtonText: 'Cerrar',
		cancelButtonColor: "#4a0081"
	})
		.then((result) => {
			if (result.value) {
				swal({
					html: `<p class="terminos">
					<br />
					<b>Aviso de infracción de Derechos de Autor</b> <br /><br />
					Si usted es propietario de los derechos de autor o el agente de dicho
					propietario y cree que cualquier material de nuestra plataforma
					constituye una infracción de sus derechos de autor, comuníquese con
					nosotros y proporcione la siguiente información: (a) una firma física o
					electrónica del propietario de los derechos de autor o una persona
					autorizada para actuar en su nombre; (b) identificación del material que
					se alega infringe; (c) su información de contacto, incluida su
					dirección, número de teléfono y un correo electrónico; (d) una
					declaración suya de que cree de buena fe que el uso del material no está
					autorizado por los propietarios de los derechos de autor; y (e) la
					declaración de que la información en la notificación es precisa y, bajo
					pena de perjurio, usted está autorizado a actuar en nombre del
					propietario. <br /><br />
			
					<b>Indemnización</b> <br /><br />
					Usted acepta indemnizar y eximir de responsabilidad a SECODE_QR y a sus
					empresas matrices, subsidiarias, afiliadas, funcionarios, empleados,
					agentes, socios y otorgantes de licencias (si corresponde) de cualquier
					reclamo o demanda, incluidos los honorarios razonables de abogados,
					debido a que surja de su: (a) uso de la plataforma; (b) violación de
					este Acuerdo o cualquier ley o reglamento; o (c) violación de cualquier
					derecho de un tercero. <br /><br />
			
					<b>Sin garantías</b> <br /><br />
					La plataforma se le proporciona "TAL CUAL" y "SEGÚN DISPONIBILIDAD" y
					con todas las fallas y defectos sin garantía de ningún tipo. En la
					medida máxima permitida por la ley aplicable, SECODE_QR, en su propio
					nombre y en nombre de sus afiliados y sus respectivos licenciantes y
					proveedores de servicios, renuncia expresamente a todas las garantías,
					ya sean expresas, implícitas, legales o de otro tipo, con con respecto a
					la plataforma, incluidas todas las garantías implícitas de
					comerciabilidad, idoneidad para un propósito particular, título y no
					infracción, y garantías que puedan surgir del curso del trato, el curso
					del desempeño, el uso o la práctica comercial. Sin limitación a lo
					anterior, SECODE_QR no ofrece garantía ni compromiso, y no hace ninguna
					representación de ningún tipo de que la plataforma cumplirá con sus
					requisitos, logrará los resultados previstos, será compatible o
					funcionará con cualquier otro software, sitios web, sistemas o
					servicios, operen sin interrupciones, cumplan con los estándares de
					rendimiento o confiabilidad o que no tengan errores o que cualquier
					error o defecto puede o será corregido. <br /><br />
			
					<b>Enmiendas a este Acuerdo</b> <br /><br />
					SECODE_QR se reserva el derecho, a su entera discreción, de modificar o
					reemplazar este Acuerdo en cualquier momento. Si una revisión es
					importante, proporcionaremos un aviso de al menos 30 días antes de que
					entren en vigencia los nuevos términos. Lo que constituye un cambio
					material se determinará a nuestro exclusivo criterio. Si continúa
					accediendo o utilizando nuestra plataforma después de que las revisiones
					entren en vigencia, usted acepta estar sujeto a los términos revisados.
					Si no está de acuerdo con los nuevos términos, ya no está autorizado
					para usar SECODE_QR. <br /><br />
			
					<b>Acuerdo completo</b> <br /><br />
					El Acuerdo constituye el acuerdo completo entre usted y SECODE_QR con
					respecto a su uso de la plataforma y reemplaza todos los acuerdos
					escritos u orales anteriores y contemporáneos entre usted y SECODE_QR.
					Es posible que esté sujeto a términos y condiciones adicionales que se
					aplican cuando usa o compra otros servicios de SECODE_QR, que SECODE_QR
					le proporcionará en el momento de dicho uso o compra. <br /><br />
			
					<b>Actualizaciones de nuestros Términos</b> <br /><br />
					Podemos cambiar nuestro Servicio y nuestras políticas, y es posible que
					debamos realizar cambios en estos Términos para que reflejen con
					precisión nuestro Servicio y nuestras políticas. A menos que la ley
					exija lo contrario, le notificaremos (por ejemplo, a través de nuestro
					Servicio) antes de realizar cambios en estos Términos y le daremos la
					oportunidad de revisarlos antes de que entren en vigencia. Luego, si
					continúa utilizando el Servicio, estará sujeto a los Términos
					actualizados. Si no desea aceptar estos o alguno de los Términos
					actualizados, puede eliminar su cuenta. <br /><br />
			
					<b>Propiedad intelectual</b> <br /><br />
					La plataforma y todo su contenido, características y funcionalidad (que
					incluyen, entre otros, toda la información, software, texto, pantallas,
					imágenes, video y audio, y el diseño, selección y disposición de los
					mismos), son propiedad de SECODE_QR, sus licenciantes u otros
					proveedores de dicho material y están protegidos por Colombia y leyes
					internacionales de derechos de autor, marcas registradas, patentes,
					secretos comerciales y otras leyes de propiedad intelectual o derechos
					de propiedad. El material no puede ser copiado, modificado, reproducido,
					descargado o distribuido de ninguna manera, en su totalidad o en parte,
					sin el permiso previo expreso por escrito de SECODE_QR, a menos que y
					excepto que se indique expresamente en estos Términos y Condiciones. Se
					prohíbe cualquier uso no autorizado del material. <br /><br />
			
					<b>Acuerdo de Arbitraje</b> <br /><br />
					Esta sección se aplica a cualquier disputa, EXCEPTO QUE NO INCLUYE UNA
					DISPUTA RELACIONADA CON RECLAMOS POR RECURSOS INJUNTIVOS O EQUITATIVOS
					CON RESPECTO A LA EJECUCIÓN O VALIDEZ DE SUS DERECHOS DE PROPIEDAD
					INTELECTUAL O DE SECODE_QR. El término "disputa" significa cualquier
					disputa, acción u otra controversia entre usted y SECODE_QR en relación
					con los Servicios o este acuerdo, ya sea en contrato, garantía, agravio,
					estatuto, regulación, ordenanza o cualquier otra base legal o
					equitativa. "Disputa" tendrá el significado más amplio posible permitido
					por la ley. <br /><br />
			
					<b>Aviso de Disputa</b> <br /><br />
					En el caso de una disputa, usted o SECODE_QR deben darle al otro un
					Aviso de Disputa, que es una declaración escrita que establece el
					nombre, la dirección y la información de contacto de la parte que la
					proporcionó, los hechos que dieron lugar a la disputa y la reparación
					solicitada. Debe enviar cualquier Aviso de disputa por correo
					electrónico a: . SECODE_QR le enviará cualquier Aviso de disputa por
					correo a su dirección si la tenemos, o de otra manera a su dirección de
					correo electrónico. Usted y SECODE_QR intentarán resolver cualquier
					disputa mediante una negociación informal dentro de los sesenta (60)
					días a partir de la fecha en que se envíe la Notificación de disputa.
					Después de sesenta (60) días, usted o SECODE_QR pueden comenzar el
					arbitraje. <br /><br />
			
					<b>Arbitraje Obligatorio</b> <br /><br />
					Si usted y SECODE_QR no resuelven ninguna disputa mediante una
					negociación informal, cualquier otro esfuerzo para resolver la disputa
					se llevará a cabo exclusivamente mediante arbitraje vinculante como se
					describe en esta sección. Está renunciando al derecho de litigar (o
					participar como parte o miembro de la clase) todas las disputas en la
					corte ante un juez o jurado. La disputa se resolverá mediante arbitraje
					vinculante de acuerdo con las reglas de arbitraje comercial de la
					Asociación Americana de Arbitraje. Cualquiera de las partes puede buscar
					medidas cautelares provisionales o preliminares de cualquier tribunal de
					jurisdicción competente, según sea necesario para proteger los derechos
					o la propiedad de las partes en espera de la finalización del arbitraje.
					Todos y cada uno de los costos, honorarios y gastos legales, contables y
					de otro tipo en los que incurra la parte ganadora correrán a cargo de la
					parte no ganadora. <br /><br />
			
					<b>Envíos y Privacidad</b> <br /><br />
					En el caso de que envíe o publique ideas, sugerencias creativas,
					diseños, fotografías, información, anuncios, datos o propuestas,
					incluidas ideas para productos, servicios, funciones, tecnologías o
					promociones nuevos o mejorados, acepta expresamente que dichos envíos se
					realizarán automáticamente. será tratado como no confidencial y no
					propietario y se convertirá en propiedad exclusiva de SECODE_QR sin
					ningún tipo de compensación o crédito para usted. SECODE_QR y sus
					afiliados no tendrán obligaciones con respecto a dichos envíos o
					publicaciones y pueden usar las ideas contenidas en dichos envíos o
					publicaciones para cualquier propósito en cualquier medio a perpetuidad,
					incluyendo, pero no limitado a desarrollo, fabricación, y comercializar
					productos y servicios utilizando tales ideas. <br /><br />
			
					<b>Promociones</b> <br /><br />
					SECODE_QR puede, de vez en cuando, incluir concursos, promociones,
					sorteos u otras actividades ("Promociones") que requieren que envíe
					material o información sobre usted. Tenga en cuenta que todas las
					promociones pueden regirse por reglas independientes que pueden contener
					ciertos requisitos de elegibilidad, como restricciones de edad y
					ubicación geográfica. Usted es responsable de leer todas las reglas de
					Promociones para determinar si es elegible para participar o no. Si
					participa en alguna Promoción, acepta cumplir con todas las Reglas de
					promociones. Es posible que se apliquen términos y condiciones
					adicionales a las compras de bienes o servicios a través de los
					Servicios, cuyos términos y condiciones forman parte de este Acuerdo
					mediante esta referencia. <br /><br />
			
					<b>Errores Tipográficos</b> <br /><br />
					En el caso de que un producto y / o servicio se enumere a un precio
					incorrecto o con información incorrecta debido a un error tipográfico,
					tendremos el derecho de rechazar o cancelar cualquier pedido realizado
					para el producto y / o servicio enumerado al precio incorrecto.
					Tendremos derecho a rechazar o cancelar cualquier pedido, ya sea que se
					haya confirmado o no y se haya cargado a su tarjeta de crédito. Si su
					tarjeta de crédito ya ha sido cargada por la compra y su pedido es
					cancelado, emitiremos inmediatamente un crédito a su cuenta de tarjeta
					de crédito u otra cuenta de pago por el monto del cargo. <br /><br />
			
					<b> Diverso</b> <br /><br />
					Si por alguna razón un tribunal de jurisdicción competente determina que
					alguna disposición o parte de estos Términos y condiciones no se puede
					hacer cumplir, el resto de estos Términos y condiciones continuará en
					pleno vigor y efecto. Cualquier renuncia a cualquier disposición de
					estos Términos y condiciones será efectiva solo si está por escrito y
					firmada por un representante autorizado de SECODE_QR. SECODE_QR tendrá
					derecho a una medida cautelar u otra compensación equitativa (sin la
					obligación de depositar ninguna fianza o garantía) en caso de
					incumplimiento anticipado por su parte. SECODE_QR opera y controla el
					Servicio SECODE_QR desde sus oficinas en Colombia. El Servicio no está
					destinado a ser distribuido ni utilizado por ninguna persona o entidad
					en ninguna jurisdicción o país donde dicha distribución o uso sea
					contrario a la ley o regulación. En consecuencia, las personas que
					eligen acceder al Servicio SECODE_QR desde otras ubicaciones lo hacen
					por iniciativa propia y son las únicas responsables del cumplimiento de
					las leyes locales, en la medida en que las leyes locales sean
					aplicables. Estos Términos y condiciones (que incluyen e incorporan la
					Política de privacidad de SECODE_QR) contienen el entendimiento completo
					y reemplazan todos los entendimientos previos entre usted y SECODE_QR
					con respecto a su tema, y usted no puede cambiarlos ni modificarlos. .
					Los títulos de las secciones que se utilizan en este Acuerdo son solo
					por conveniencia y no se les dará ninguna importancia legal.
					<br /><br />
			
					<b>Descargo de Responsabilidad</b> <br /><br />
					SECODE_QR no es responsable de ningún contenido, código o cualquier otra
					imprecisión. SECODE_QR no ofrece garantías. En ningún caso será
					responsable de ningún daño especial, directo, indirecto, consecuente o
					incidental o de cualquier daño, ya sea en una acción contractual,
					negligencia u otro agravio, que surja de o en conexión con el uso del
					Servicio o el contenido del Servicio. se reserva el derecho de realizar
					adiciones, eliminaciones o modificaciones al contenido del Servicio en
					cualquier momento sin previo aviso. <br /><br />
					El Servicio y su contenido se proporcionan "tal cual" y "según esté
					disponible" sin ninguna garantía o representación de ningún tipo, ya sea
					expresa o implícita. es un distribuidor y no un editor del contenido
					proporcionado por terceros; como tal, no ejerce ningún control editorial
					sobre dicho contenido y no ofrece ninguna garantía o representación en
					cuanto a la precisión, confiabilidad o vigencia de cualquier
					información, contenido, servicio o mercancía proporcionada o accesible a
					través del Servicio . Sin limitar lo anterior, renuncia específicamente
					a todas las garantías y representaciones en cualquier contenido
					transmitido en conexión con el Servicio o en sitios que pueden aparecer
					como enlaces en el Servicio , o en los productos proporcionados como
					parte o en relación con el Servicio , incluidas, entre otras, las
					garantías de comerciabilidad, idoneidad para un propósito particular o
					no infracción de derechos de terceros. Ningún consejo oral o información
					escrita proporcionada por o cualquiera de sus afiliados, empleados,
					funcionarios, directores, agentes o similares creará una garantía. La
					información sobre precios y disponibilidad está sujeta a cambios sin
					previo aviso. Sin limitar lo anterior, no garantiza que el Servicio de
					sea ininterrumpido, sin corrupción, oportuno o sin errores.
				  </p>`,
					imageUrl: "./assets/img/logo.png",
					position: "top",
					width: 1000,
					confirmButton: true,
					confirmButtonText: "CONTINUE &rarr;",
					confirmButtonColor: "#4ba7cf",
					showCancelButton: true,
					cancelButtonText: 'Cerrar',
					cancelButtonColor: "#4a0081"

				}).then((result) => {
					if (result.value) {
						swal({
              imageUrl: "./assets/img/logo.png",
							width: 800,
							title: 'Confirmación de aceptación',
							input: 'checkbox',
							inputPlaceholder: 'Chequea el recuadro para confirmar que aceptas los términos y condiciones',
							confirmButtonText: "Aceptar Todo ",
							confirmButtonColor: "#4ab7cf",
							inputValidator: (result) => {
								return !result && 'Es necesario que acepte los términos y condiciones para hacer uso del producto'
							}
						}).then(function (result) {
							if (result.value === 1) {
								swal({
									type: 'success',
									text: 'Muy bien, ya puedes formar parte de nuestra página.',
									confirmButtonText: "Terminar",
									confirmButtonColor: "#4b0081"
								});
							}
						});
					} else if (result.dismiss === 'cancel') {
						swal({
							type: 'error',
							title: "Advertencia",
							text: 'Si no aceptas los términos y condiciones no podras registrarte.',
							confirmButtonText: "Cerrar",
							confirmButtonColor: "red"
						})
					}
				})
			} else if (result.dismiss === 'cancel') {
				swal({
					type: 'error',
					title: "Advertencia",
					titleColor: 'red',
					text: 'Si no aceptas los términos y condiciones no podras registrarte.',
					confirmButtonText: "Cerrar",
					confirmButtonColor: "red"
				})
			}
		})
});
  </script>
</body>

</html>