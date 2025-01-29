<?php

if (!isset($_SESSION['email']) || empty($_SESSION['email'])) { // Este if es para verificar si el usuario está logueado
    header('location:../Login.php'); // Si no está logueado lo redirige al login
    exit(); // Termina la ejecución del script
}

if($_SESSION['rol'] != "Administrador"){ // Este if es para verificar si el usuario es un administrador
    header('location:../Analista/inicio.php'); // Si no es un administrador lo redirige al inicio del analista
}

function showEdit(){ // Esta función muestra el formulario para editar un item
    include '../conexion.php'; // Se incluye el archivo de conexión

    $selectedItem = $_GET['idEditedItem']; // Se obtiene el id del item a editar
    $select = "SELECT * FROM `item` INNER JOIN `consumo` ON item.Numero_Item = consumo.id_Item WHERE item.Numero_Item = '$selectedItem'"; // Selecciona el item a editar
    $result = mysqli_query($connection, $select); // Ejecuta la consulta
    $row = mysqli_fetch_assoc($result); // Obtiene el resultado de la consulta

    if(isset($_POST['updateBtn'])){ // Este if es para verificar si se presionó el botón de actualizar
        $itemName = $_POST['itemName']; // Se obtiene el nombre del item
        $paintQuantity = $_POST['paintQuantity']; // Se obtiene la cantidad de pintura
        $timeWash = $_POST['timeWash']; // Se obtiene el tiempo de lavado
        $timePaint = $_POST['timePaint']; // Se obtiene el tiempo de pintura
        $timeFurnace = $_POST['timeFurnace']; // Se obtiene el tiempo de horno

        if (empty($itemName) || empty($paintQuantity) || empty($timeWash) || empty($timePaint) || empty($timeFurnace)) { // Este if es para verificar si todos los campos están llenos
            echo "<script> alert('Todos los campos son obligatorios'); </script>"; // Si no están llenos muestra un mensaje de alerta
        } else { // Si todos los campos están llenos
            edit($selectedItem, $itemName, $paintQuantity, $timeWash, $timePaint, $timeFurnace); // Se llama a la función edit
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
                        echo "<strong> ITEM: ". $row['Numero_Item']. "</strong>"; 
                        echo "<input type='text' class='itemName' name='itemName' value='". $row['Nombre']. "'>";
                    ?>
                </div>
                <div class="infoSection">
                    <p>
                        <label> Cantidad de Pintura (Kg): </label>
                        <input type="number" name="paintQuantity" class="paintQuantity" value="<?php echo $row['Cantidad_Pintura'] ?>">
                    </p>
                    <p>
                        <label> Lavado (min): </label>
                        <input type="number" name="timeWash" class="timeWash" value="<?php echo $row['Lavado'] ?>">
                    </p>
                    <p>
                        <label> Pintura (min): </label>
                        <input type="number" name="timePaint" class="timePaint" value="<?php echo $row['Pintura'] ?>">
                    </p>
                    <p>
                        <label> Horno (min): </label>
                        <input type="number" name="timeFurnace" class="timeFurnace" value="<?php echo $row['Horneo'] ?>">
                    </p>
                </div>
                
                <div class="buttonSection">
                    <button type="submit" name="updateBtn" class="calculateButton"> Actualizar </button>
                    <button type="button" class="cancelButton" onclick="cerrarFormulario()"> Cancelar </button>
                </div>
            </form>
        </section>
    </body>
    </html>

    <script>
        function cerrarFormulario() { // Esta función cierra el formulario
            const url = new URL(window.location.href); // Se obtiene la url actual
            url.searchParams.delete('idEditedItem'); // Se elimina el parámetro idEditedItem
            window.location.href = url.toString(); // Se redirige a la url sin el parámetro idEditedItem
        }
    </script>

<?php }

function edit($idItem, $itemName, $paintQuantity, $timeWash, $timePaint, $timeFurnace){ // Esta función actualiza un item
    include '../conexion.php'; // Se incluye el archivo de conexión
    mysqli_begin_transaction($connection); // Inicia una transacción en la base de datos

    try { // Este try es para manejar una excepción en caso de que ocurra un error en la actualización
        $updateItemQuery = "UPDATE `item` SET `Nombre` = '$itemName' WHERE `Numero_Item` = '$idItem'"; // Actualiza el item
        $result1 = mysqli_query($connection, $updateItemQuery); // Ejecuta la consulta
        if (!$result1) { // Este if es para verificar si la consulta se ejecutó correctamente
            throw new Exception("Error en la actualización de item: " . mysqli_error($connection)); // Si no se ejecutó correctamente muestra un mensaje de error   
        }

        $updateConsumoQuery = "UPDATE `consumo` SET `Cantidad_Pintura` = '$paintQuantity', `Lavado` = '$timeWash', `Pintura` = '$timePaint', `Horneo` = '$timeFurnace' WHERE `id_Item` = '$idItem'"; // Actualiza el consumo
        $result2 = mysqli_query($connection, $updateConsumoQuery); // Ejecuta la consulta
        if (!$result2) { // Este if es para verificar si la consulta se ejecutó correctamente
            throw new Exception("Error en la actualización de consumo: " . mysqli_error($connection)); // Si no se ejecutó correctamente muestra un mensaje de error
        }

        mysqli_commit($connection); // Confirma la transacción
        echo "<script> alert('Item actualizado correctamente'); </script>"; // Muestra un mensaje de alerta
        header('location:inicioAdmin.php'); // Redirige al inicio del administrador
    } catch (Exception $e) { // Este catch es para manejar la excepción
        mysqli_rollback($connection); // Revierte la transacción
        echo "<script> alert('Error al actualizar el item: " . $e->getMessage() . "'); </script>"; // Muestra un mensaje de alerta con el error
    }

    mysqli_close($connection); // Cierra la conexión
}

?>