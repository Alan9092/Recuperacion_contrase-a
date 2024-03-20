<?php
include("conexion.php");


$token_verified = false;
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
   
    $entered_token = $_POST['token'];

    $conn = connect();
    $stmt = $conn->prepare("SELECT email FROM users WHERE token = ?");
    $stmt->bind_param("s", $entered_token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $token_verified = true;
        $stmt->bind_result($email);
        $stmt->fetch();
        header("Location: ../php/cambiar_contra.php?email=" . urlencode($email));
        exit();
    } else {
        $error_message = "El token ingresado no es válido. Por favor, intenta nuevamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Token</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .verification-container {
            max-width: 400px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="verification-container">
        <h1 class="text-center mb-4">Verificar Token</h1>
        <?php if (!$token_verified) { ?>
            <form action="" method="post">
                <div class="form-group">
                    <label for="token">Token generado:</label>
                    <input type="text" class="form-control" id="token" name="token" required>
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Verificar Token</button>
                <?php if (!empty($error_message)) {
                    echo "<p class='text-danger mt-2'>$error_message</p>";
                } ?>
            </form>
        <?php } ?>
    </div>
</body>

</html>
