<?php

include '../conexion.php';
session_start();

if (!isset($_SESSION['email']) || empty($_SESSION['email'])) { // Este if es para verificar si el usuario está logueado
    header('location:../Login.php'); // Si no está logueado lo redirige al login
    exit(); // Termina la ejecución del script
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) { // Este if es para verificar si se presionó el botón de cerrar sesión
    cerrarSesion(); // Se llama a la función cerrarSesion
}

function cerrarSesion() { // Esta función cierra la sesión del usuario
    session_start(); // Se inicia la sesión
    session_destroy(); // Se destruye la sesión
    header('location:../Login.php'); // Se redirige al login
    exit(); // Termina la ejecución del script
}

if($_SESSION['rol'] != "Administrador"){ // Este if es para verificar si el usuario es un administrador
    header('location:../Analista/inicio.php'); // Si no es un administrador lo redirige al inicio del analista
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
            <a href="?addItem=true" name="addItem" class="addItem">+</a>
            <table>
                <thead>
                    <tr>
                        <th>Imagen</th>
                        <th>Número de Item</th>
                        <th>Nombre del Item</th>
                        <th>Correo Registrado</th>
                        <th></th>
                        <th></th>
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
                            echo "<td>" . htmlspecialchars($row['CorreoRegistro'], ENT_QUOTES, 'UTF-8') . "</td>"; // Muestra el correo registrado
                            echo "<td><a href='?idItem=" . htmlspecialchars($row['Numero_Item'], ENT_QUOTES, 'UTF-8') . "'>Calcular</a></td>";
                            echo "<td><a href='?idEditedItem=" . htmlspecialchars($row['Numero_Item'], ENT_QUOTES, 'UTF-8') . "' class='editButton'>Editar</a></td>"; // Muestra el link para editar el item
                            echo "<td><a href='?idDeletedItem=" . htmlspecialchars($row['Numero_Item'], ENT_QUOTES, 'UTF-8') . "' class='deleteButton'>Eliminar</a></td>"; // Muestra el link para eliminar el item
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
        if(!empty($_GET['idEditedItem'])){ // Este if es para verificar si se seleccionó un item para editar
            include 'editar.php'; // Se incluye el archivo para editar el item
            showEdit(); // Se llama a la función para mostrar el formulario
        }
        if(!empty($_GET['idDeletedItem'])){ // Este if es para verificar si se seleccionó un item para eliminar
            include 'eliminar.php'; // Se incluye el archivo para eliminar el item
            deleteItem(); // Se llama a la función para eliminar el item
        }
        if(!empty($_GET['addItem'])){ // Este if es para verificar si se seleccionó agregar un item
            include 'agregar.php'; // Se incluye el archivo para agregar un item
            addItem(); // Se llama a la función para agregar el item
        }
    
    ?>
</body>
</html>