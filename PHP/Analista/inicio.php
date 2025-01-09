<?php

include '../conexion.php';
session_start();

if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
    header('location:../Login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    cerrarSesion();
}

function cerrarSesion() {
    session_start();
    session_destroy();
    header('location:../Login.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/Analista/Inicio.css">
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
                    <?php
                        $query = "SELECT * FROM item";
                        $result = mysqli_query($connection, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td><img src='../../IMG/UserProfile.jpg' alt='Imagen'></td>";
                            echo "<td>" . htmlspecialchars($row['Numero_Item'], ENT_QUOTES, 'UTF-8') . "</td>";
                            echo "<td>" . htmlspecialchars($row['Nombre'], ENT_QUOTES, 'UTF-8') . "</td>";
                            echo "<td>" . htmlspecialchars($row['CorreoRegistro'], ENT_QUOTES, 'UTF-8') . "</td>";
                            echo "<td><a href='?idItem=" . htmlspecialchars($row['Numero_Item'], ENT_QUOTES, 'UTF-8') . "&itemQuantity=1'>Calcular</a></td>";
                            echo "</tr>";
                        }

                    ?>
                </tbody>
            </table>
        </section>
    </div>
    <?php 
    
        if(!empty($_GET['idItem'])){
            include '../calcularItem.php';
            showCalcule();
        }
    
    ?>
</body>
</html>