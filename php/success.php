<?php
include("conexion.php");


if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['email'])) {
    
    $email = $_GET['email'];


    $conn = connect();
    $stmt = $conn->prepare("SELECT token FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

   
    if ($stmt->num_rows > 0) {
      
        $stmt->bind_result($token);
        $stmt->fetch();
    } else {

        header("Location: ../php/rec_cont.php");
        exit();
    }
} else {
    header("Location: ../php/rec_cont.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperación de contraseña - Token</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="col-md-6">
            <h1 class="mb-4">Recuperacion de contraseña</h1>
            <p>Se ha generado un token del user:</p>
            <p class="font-weight-bold">El token es: <?php echo $token; ?></p>
            <p>Copia el token y pegalo en el formulario que sigue.</p>
            <a href="recovery_token.php" class="btn btn-primary">Continuar</a>
        </div>
    </div>
</body>

</html>
