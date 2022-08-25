
<?php
session_start();
require_once '../../models/php/usuario.php';


if (isset($_SESSION['Ndocumento'])) {
    header('Location: ../iniciar.php');
  }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="../assets/bootstrap/js/bootstrap.min.js">
</script>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">

          <!-- librerias de sweet alerts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="sweetalert2.all.min.js"></script>

<!-- librerias de sweet alerts css -->
<script src="sweetalert2.min.js"></script>
<link rel="stylesheet" href="sweetalert2.min.css">


    <title>Iniciar</title>
</head>
<body>
    <?php
    if ($results_user['Ndocumento']<7) { ?>


 <form action="./user.php" method="post" class="form " style="margin: 200px">
  <div class="form-group">
    <label for="exampleInputEmail1">Ndocumento</label>
    <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Ingrese su Numero de documento" maxlength="12">
    <small id="emailHelp" class="form-text text-muted">Nunca compartas tus datos con nadie</small>
  </div>
  <button type="submit" class="btn btn-primary">Enviar</button>
</form>
      
      <?php   } ?>
   




</body>
</html>