<?php

include '../conexion.php';
session_start();

if (!isset($_SESSION['email']) || empty($_SESSION['email'])) { // Este if es para verificar si el usuario está logueado
    header('location:../Login.php'); // Si no está logueado lo redirige al login
    exit(); // Termina la ejecución del script
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) { // Este if es para verificar si se presionó el botón de cerrar sesión
    cerrarSesion();
}

function cerrarSesion() { // Esta función cierra la sesión del usuario
    session_start(); // Se inicia la sesión
    session_destroy(); // Se destruye la sesión
    header('location:../Login.php'); // Se redirige al login
    exit(); // Termina la ejecución del script
}

if($_SESSION['rol'] != "Analista"){ // Este if es para verificar si el usuario es un analista
    header('location:../Admministrador/inicioAdmin.php'); // Si no es un analista lo redirige al inicio del administrador
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/Inicio.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <section class="userSection">
            <img src="../../IMG/UserProfile.jpg" alt="">
            <h1><?php echo htmlspecialchars($_SESSION['Usuario'], ENT_QUOTES, 'UTF-8'); ?></h1>
            <form method="post">
                <button type="submit" name="logout">Cerrar Sesión</button>
            </form>
        </section>
        <section class="tableSection">
            <table>
                <thead>
                    <tr>
                        <th>Imagen</th>
                        <th>Número de Item</th>
                        <th>Nombre del Item</th>
                        <th>Correo Registrado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Se hace una consulta para obtener todos los items -->
                    <?php
                        $query = "SELECT * FROM item"; // Selecciona todos los items
                        $result = mysqli_query($connection, $query); // Ejecuta la consulta
                        while ($row = mysqli_fetch_assoc($result)) { // Muestra los items
                            echo "<tr>"; // Muestra los items
                            echo "<td><img src='../../IMG/UserProfile.jpg' alt='Imagen'></td>"; // Muestra la imagen
                            echo "<td>" . htmlspecialchars($row['Numero_Item'], ENT_QUOTES, 'UTF-8') . "</td>"; // Muestra el número del item
                            echo "<td>" . htmlspecialchars($row['Nombre'], ENT_QUOTES, 'UTF-8') . "</td>"; // Muestra el nombre del item
                            echo "<td>" . htmlspecialchars($row['CorreoRegistro'], ENT_QUOTES, 'UTF-8') . "</td>";
                            echo "<td><a href='?idItem=" . htmlspecialchars($row['Numero_Item'], ENT_QUOTES, 'UTF-8') . "&itemQuantity=1'>Calcular</a></td>"; // Muestra el link para calcular los tiempos
                            echo "</tr>";
                        }

                    ?>
                </tbody>
            </table>
        </section>
    </div>
    <?php 
    
        if(!empty($_GET['idItem'])){ // Este if es para verificar si se seleccionó un item
            include '../calcularItem.php'; // Se incluye el archivo para calcular los tiempos
            showCalcule(); // Se llama a la función para mostrar el formulario
        }
    
    ?>
</body>
</html>