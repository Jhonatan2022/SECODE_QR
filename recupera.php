<?php
use LDAP\Result;

session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: ./iniciar.html');
}

//importamos conexion base de datos
require './assets/php/database.php';

//$token = $_GET['token'];

if (!empty($_POST['email-user'])) {
    $email_rec =$_POST['email-user'];
    if (filter_var($email_rec, FILTER_VALIDATE_EMAIL)) {
        
        $consult= "SELECT Correo FROM usuarios WHERE Correo = :email ";
        $params = $connection->prepare($consult);
        $params -> bindParam(":email",$email_rec);
        $params->execute();
        $results1 = $params->fetch();
        try{
            if(count($results1["Correo"]) >0){
           
                //envio de datos al correo.
                $token = rand(12354,876431);
                

            }else{
                $msg = "No se ha encontrado el correo solicitado";
            }
        }catch (Exception $error){

        }
        
      
    }
    else {
        echo "<script>
        alert('Correo No valido, ingrese nuevamente.');
        setTimeout(\" location.href=\'iniciar.php\' \",0);
        </script>;
        ";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <title>Recupera Passwod</title>
</head>
<body>
    


<script>
   // alert()
</script>
<main class="container">
    <div class="row justify-content-md-center" style="margin-top: 60.5%;">

    <form action="./recupera.php" class="form col-4">

<label for="email" class="form-label">Email</label>
<input type="email" name="email-user" id="email" class="form-control">

<br>
<button type="submit" class="btn btn-primary">Submit</button>
</form>

    </div>
    
</main>

<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>


<!-- librerias de sweet alerts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="sweetalert2.all.min.js"></script>

<!-- librerias de sweet alerts css -->
<script src="sweetalert2.min.js"></script>
<link rel="stylesheet" href="sweetalert2.min.css">

<?php
$msg= "como es";
if (!empty($msg)){
    echo`
    <script>
 Swal.fire({
        title: 'Aviso',
        text: '$msg',
        icon: 'warning',
        confirmButtonText: 'ok'
      })
</script>

   `;
}
?>
</body>
</html>