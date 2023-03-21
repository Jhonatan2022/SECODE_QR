<?php
sleep(1);
include('configuracion.php');



$fechaInit = date("Y-m-d", strtotime($_POST['f_ingreso']));
$fechaFin  = date("Y-m-d", strtotime($_POST['f_fin']));

$sqlfinalsecode = ("SELECT * FROM usuario WHERE  `fechaCreacion` BETWEEN '$fechaInit' AND '$fechaFin' ORDER BY fechaCreacion ASC");
$query = mysqli_query($con, $sqlfinalsecode);
$total   = mysqli_num_rows($query);
echo '<center><h4 style="color:#4b0081; margin-top:1%;">Busquedas encontradas:</h4></center><center"><h5 style="margin-left:50%; margin-top:2%;">('. $total .')</h5></center>';
?>
<br>
<div class="col-10" style="margin-left:15%; margin-top:-3%;">
<table class="table">
    <thead>
        <tr>
            <th scope="col">N°Documento</th>
            <th scope="col">Nombre</th>
            <th scope="col">Direccion</th>
            <th scope="col">Genero</th>
            <th scope="col">Correo</th>
            <th scope="col">Fecha creación</th>
            <th scope="col">Telefono</th>
            <th scope="col">Acciones</th>

        </tr>
    </thead>
    <?php
    $i = 1;
    while ($dataRow = mysqli_fetch_array($query)){?>
    
                     <tbody>
                         <tr>
                            <td> <?php echo $dataRow['Ndocumento']; ?> </td>
                            <td> <?php echo $dataRow['Nombre']; ?> </td>
                            <td> <?php echo $dataRow['Direccion']; ?> </td>
                            <td> <?php echo $dataRow['Genero']; ?></td>
                            <td> <?php echo $dataRow['Correo']; ?> </td>
                            <td> <?php echo $dataRow['fechaCreacion']; ?></td>
                            <td> <?php echo $dataRow['Telefono']; ?></td>
                            <td>
                                <a class="btn btn-warning mb-10" href="editar.php?id=<?= $usuario['Ndocumento'] ?> ">
                                <i class="fas fa-user-edit"></i>

                                <a class="btn btn-danger" href="eliminar.php?id=<?= $usuario['Ndocumento'] ?>">
                                    <i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    </tbody>
    <?php } ?>
</table>
</div>