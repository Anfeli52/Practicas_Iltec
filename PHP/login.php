<?php

include 'conexion.php'; // Incluimos el archivo de conexión a la base de datos

function login($email, $password, $connection){ // Función para iniciar sesión
    $query = "SELECT * FROM registro WHERE Correo = ? AND Contraseña = ?"; // Consulta para seleccionar el usuario y contraseña
    $stmt = mysqli_prepare($connection, $query); // Preparamos la consulta
    mysqli_stmt_bind_param($stmt, "ss", $email, $password); // Asignamos los valores a la consulta
    mysqli_stmt_execute($stmt); // Ejecutamos la consulta
    $result = mysqli_stmt_get_result($stmt); // Obtenemos el resultado de la consulta
    if (mysqli_num_rows($result) > 0) { // Si el resultado es mayor a 0, es decir, si existe el usuario
        session_start(); // Iniciamos la sesión
        $user = mysqli_fetch_assoc($result); // Obtenemos los datos del usuario
        $_SESSION['email'] = $email; // Asignamos el email a la sesión
        $_SESSION['Usuario'] = $user['Usuario']; // Asignamos el usuario a la sesión
        $_SESSION['rol'] = $user['Rol']; // Asignamos el rol a la sesión

        if($_SESSION['rol'] == 'Administrador') { // Si el rol es administrador
            header('location: Administrador/inicioAdmin.php'); // Redireccionamos al inicio del administrador
            exit; // Salimos
        } else { // Si no
            header('location: Analista/Inicio.php'); // Redireccion
            exit; // Salimos
        }

    } else { // Si no
        echo '<span class="incorrectError"> Usuario o Contraseña Incorrectos </span>'; // Mostramos un mensaje de error
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
                if (isset($_POST['email']) && isset($_POST['password'])) { // Si se envió el formulario
                    login($_POST['email'], $_POST['password'], $connection); // Llamamos a la función de iniciar sesión
                }
            ?>
        </form>
    </section>
</body>
</html>