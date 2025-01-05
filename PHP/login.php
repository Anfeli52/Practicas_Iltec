<?php

include 'conexion.php';

function login($email, $password, $connection){
    $query = "SELECT * FROM registro WHERE Correo = ? AND Contraseña = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "ss", $email, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) > 0) {
        session_start();
        $user = mysqli_fetch_assoc($result);
        $_SESSION['email'] = $email;
        $_SESSION['Usuario'] = $user['Usuario'];
        $_SESSION['rol'] = $user['Rol'];

        if($_SESSION['rol'] == 'Administrador') {
            header('location: Administrador/inicioAdmin.php');
            exit;
        } else {
            header('location: Analista/Inicio.php');
            exit;
        }

    } else {
        echo '<span class="incorrectError"> Usuario o Contraseña Incorrectos </span>';
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/Login.css">
    <title>Document</title>
</head>
<body>
    <section class="container">
        <form method="post" class="loginForm">
            <label>
                <input type="email" placeholder="Email" name="email">
            </label>
            <label>
                <input type="password" placeholder="Password" name="password">
            </label>
            <button type="submit" name="btnSubmit">Iniciar Sesión</button>

            <?php  
                if (isset($_POST['email']) && isset($_POST['password'])) {
                    login($_POST['email'], $_POST['password'], $connection);
                }
            ?>
        </form>
    </section>
</body>
</html>