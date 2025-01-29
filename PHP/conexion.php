<?php

try { //La sentencia try se utiliza en caso tal de que la conexión falle, para que no se muestre un error en la página
    $hostname = "localhost"; //Se define el host al que se va a conectar
    $database = "produccion_iltec"; //Se define la base de datos a la que se va a conectar
    $user = "root"; //Se define el usuario con el que se va a conectar
    $password = ""; //Se define la contraseña con la que se va a conectar (por defecto, XAMPP no tiene contraseña)

    $connection = mysqli_connect($hostname, $user, $password, $database); //Se crea la conexión con la base de datos
} catch (Exception $e) {
    echo "Ocurrió un error con la base de datos: " . $e->getMessage(); //En caso de que la conexión falle, se mostrará un mensaje de error
}

?>