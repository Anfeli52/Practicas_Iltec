<?php

include '../conexion.php';
session_start();

if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
    header('location:../Login.php');
    exit();
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
    <title>Document</title>
</head>
<body>
    <div class="container">
        <section class="userSection">
            <img src="../../IMG/UserProfile.jpg" alt="">
            <h1><?php echo htmlspecialchars($_SESSION['Usuario'], ENT_QUOTES, 'UTF-8'); ?></h1>
            <button onclick="cerrarSesion()">Cerrar Sesión</button>
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
                            echo "<td> <img src='../../IMG/UserProfile.jpg'> </td>";
                            echo "<td>" . $row['Numero_Item'] . "</td>";
                            echo "<td>" . $row['Nombre'] . "</td>";
                            echo "<td>" . $row['CorreoRegistro'] . "</td>";
                            echo "<td><a href='calcularItem.php?id=" . $row['Numero_Item'] . "'>Calcular</a></td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </section>
    </div>
</body>
</html>