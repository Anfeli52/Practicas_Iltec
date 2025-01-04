<?php

include '../conexion.php';
session_start();

if(isset($_SESSION['email'])) {
    echo "Bienvenido " . $_SESSION['Usuario'];
} else {
    header('location: ../Login.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <section>
        <button onclick="<?php session_destroy(); ?>"> Cerrar Sesión </button>
    </section>
</body>
</html>