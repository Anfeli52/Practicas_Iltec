<?php

try {
    $hostname = "localhost";
    $database = "produccion_iltec";
    $user = "root";
    $password = "";

    $connection = mysqli_connect($hostname, $user, $password, $database);
} catch (Exception $e) {
    echo "Ocurrió un error con la base de datos: " . $e->getMessage();
}

?>