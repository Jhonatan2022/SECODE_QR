<?php
session_start();
require_once '../models/database/database.php';
require_once '../models/user.php';
if (isset($_SESSION['user_id']) && getUser($_SESSION['user_id'])['Correo'] == '') {
    header('Location: views/tablero.php');
} else {
    http_response_code(404);
    header('Location: ../views/');
}
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/es.css">
    <link rel="stylesheet" href="../css/fontawesome.css">
    <script src="https://kit.fontawesome.com/9165abed33.js" crossorigin="anonymous"></script>
</head>
<body>
    <form action="funcion.php" method="POST">
        <div id="login">
            <div class="container">
                <div id="login-row" class="row justify-content-center align-items-center">
                    <div id="login-column" class="col-md-6">
                        <div id="login-box" class="col-md-12">
                            <h3 class="text-center">Iniciar Sesión</h3>
                            <div class="form-group">
                                <label for="correo">Documento:</label><br>
                                <input type="text" name="Ndocumento" id="Ndocumento" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña:</label><br>
                                <input type="password" name="Contrasena" id="Contrasena" class="form-control" required>
                                <input type="hidden" name="accion" value="acceso_user">
                            </div>
                            <div class="form-group">
                                    <input type="submit" class="btn btn-success" value="Ingresar">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </form>
</body>
</html>