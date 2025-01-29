<?php

if (!isset($_SESSION['email']) || empty($_SESSION['email'])) { // Este if es para verificar si el usuario está logueado
    header('location:../Login.php'); // Si no está logueado lo redirige al login
    exit(); // Termina la ejecución del script
}

if($_SESSION['rol'] != "Administrador"){ // Este if es para verificar si el usuario es un administrador
    header('location:../Analista/inicio.php'); // Si no es un administrador lo redirige al inicio del analista
}

function addItem(){ // Esta función muestra el formulario para agregar un item
    include '../conexion.php'; // Se incluye el archivo de conexión

    if(isset($_POST['updateBtn'])){ // Este if es para verificar si se presionó el botón de agregar item
        $itemId = $_POST['itemId']; // Se obtiene el número del item
        $itemName = $_POST['itemName']; // Se obtiene el nombre del item
        $paintQuantity = $_POST['paintQuantity']; // Se obtiene la cantidad de pintura
        $timeWash = $_POST['timeWash']; // Se obtiene el tiempo de lavado
        $timePaint = $_POST['timePaint']; // Se obtiene el tiempo de pintura
        $timeFurnace = $_POST['timeFurnace']; // Se obtiene el tiempo de horno
    
        if (empty($itemId) || empty($itemName) || empty($paintQuantity) || empty($timeWash) || empty($timePaint) || empty($timeFurnace)) { // Este if es para verificar si todos los campos están llenos
            echo "<script> alert('Todos los campos son obligatorios'); </script>"; // Si no están llenos muestra un mensaje de alerta
        } else { // Si todos los campos están llenos
            $checkQuery = "SELECT * FROM `item` WHERE `Numero_Item` = '$itemId'"; // Selecciona el item con el número ingresado
            $checkResult = mysqli_query($connection, $checkQuery); // Ejecuta la consulta
    
            if (mysqli_num_rows($checkResult) > 0) { // Este if es para verificar si el item ya existe
                echo "<script> alert('El código del ítem ya existe'); </script>"; // Si el item ya existe muestra un mensaje de alerta
            } else { // Si el item no existe
                $insert = "INSERT INTO `item`(`Numero_Item`, `Nombre`, `CorreoRegistro`) VALUES ('$itemId', '$itemName', '".$_SESSION['email']."')"; // Inserta el item en la base de datos
                $result = mysqli_query($connection, $insert); // Ejecuta la consulta
    
                if($result){ // Este if es para verificar si se insertó el item correctamente
                    $insertConsumo = "INSERT INTO `consumo`(`id_Item`, `Cantidad_Pintura`, `Lavado`, `Pintura`, `Horneo`) VALUES ('$itemId', '$paintQuantity', '$timeWash', '$timePaint', '$timeFurnace')"; // Inserta el consumo del item en la base de datos
                    $resultConsumo = mysqli_query($connection, $insertConsumo); // Ejecuta la consulta
    
                    if($resultConsumo){ // Este if es para verificar si se insertó el consumo del item correctamente
                        echo "<script> alert('Item agregado correctamente'); </script>"; // Si se insertó correctamente muestra un mensaje de alerta
                        header('location:inicioAdmin.php'); // Redirige al inicio del administrador
                        exit(); // Termina la ejecución del script
                    } else { // Si no se insertó correctamente el consumo del item
                        echo "<script> alert('Error al agregar el item en consumo'); </script>"; // Muestra un mensaje de alerta
                    }
                } else { // Si no se insertó correctamente el item
                    echo "<script> alert('Error al agregar el item'); </script>"; // Muestra un mensaje de alerta
                }
            }
        }
    }

    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../CSS/calcularItem.css">
        <title>Document</title>
    </head>
    <body>
        <section class="containerPopUp">
            <form action="" class="popUpForm" method="post">
                <div class="itemInfo">
                    <?php 
                        echo "<input type='number' class='itemId' name='itemId' placeholder='Número de Item'>"; 
                        echo "<input type='text' class='itemName' name='itemName' placeholder='Nombre del Item'>";
                    ?>
                </div>
                <div class="infoSection">
                    <p>
                        <label> Cantidad de Pintura (Kg): </label>
                        <input type="number" name="paintQuantity" class="paintQuantity" placeholder="Cantidad de Pintura" step="0.001">
                    </p>
                    <p>
                        <label> Lavado (min): </label>
                        <input type="number" name="timeWash" class="timeWash" placeholder="Tiempo de Lavado" step="0.001">
                    </p>
                    <p>
                        <label> Pintura (min): </label>
                        <input type="number" name="timePaint" class="timePaint" placeholder="Tiempo de Pintura" step="0.001">
                    </p>
                    <p>
                        <label> Horno (min): </label>
                        <input type="number" name="timeFurnace" class="timeFurnace" placeholder="Tiempo de Horno" step="0.001">
                    </p>
                </div>
                
                <div class="buttonSection">
                    <button type="submit" name="updateBtn" class="calculateButton"> Agregar Item </button>
                    <button type="button" class="cancelButton" onclick="cerrarFormulario()"> Cancelar </button>
                </div>
            </form>
        </section>
    </body>
    </html>

    <script>
        function cerrarFormulario() { // Esta función cierra el formulario
            const url = new URL(window.location.href); // Se obtiene la url actual
            url.searchParams.delete('addItem'); // Se elimina el parámetro addItem
            window.location.href = url.toString(); // Se redirige a la url sin el parámetro addItem
        }
    </script>


<?php } ?>  