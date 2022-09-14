<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/es.css">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Eliminar Usuario</title>
</head>
<body>
<div class="container mt-5">
    <div class="row">
    <div class="col-sm-6 offset-sm-3">
    <div class="alert alert-danger text-center">
    <p>¿Desea confirmar la eliminacion del registro?</p>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <form action="../includes/funcion.php" method="POST">
                <input type="hidden" name="accion" value="eliminar_registro">
                <input type="hidden" name="Ndocumento" value="<?php echo $_GET['id'];?>">
                <input type="submit" name="" value="Eliminar" class= "btn btn-danger">
                <a href="tablero.php" class="btn btn-success">Cancelar</a>

                               
        </div>
    </div>

    
</body>
</html>