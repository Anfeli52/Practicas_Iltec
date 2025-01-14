<?php

if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
    header('location:../Login.php');
    exit();
}

if($_SESSION['rol'] != "Administrador"){
    header('location:../Analista/inicio.php');
}

function showEdit(){
    include '../conexion.php';

    $selectedItem = $_GET['idEditedItem'];
    $select = "SELECT * FROM `item` INNER JOIN `consumo` ON item.Numero_Item = consumo.id_Item WHERE item.Numero_Item = '$selectedItem'";
    $result = mysqli_query($connection, $select);
    $row = mysqli_fetch_assoc($result);

    if(isset($_POST['updateBtn'])){
        $itemName = $_POST['itemName'];
        $paintQuantity = $_POST['paintQuantity'];
        $timeWash = $_POST['timeWash'];
        $timePaint = $_POST['timePaint'];
        $timeFurnace = $_POST['timeFurnace'];

        if (empty($itemName) || empty($paintQuantity) || empty($timeWash) || empty($timePaint) || empty($timeFurnace)) {
            echo "<script> alert('Todos los campos son obligatorios'); </script>";
        } else {
            edit($selectedItem, $itemName, $paintQuantity, $timeWash, $timePaint, $timeFurnace);
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
        function cerrarFormulario() {
            const url = new URL(window.location.href);
            url.searchParams.delete('idEditedItem');
            window.location.href = url.toString();
        }
    </script>

<?php }

function edit($idItem, $itemName, $paintQuantity, $timeWash, $timePaint, $timeFurnace){
    include '../conexion.php';
    mysqli_begin_transaction($connection);

    try {
        $updateItemQuery = "UPDATE `item` SET `Nombre` = '$itemName' WHERE `Numero_Item` = '$idItem'";
        $result1 = mysqli_query($connection, $updateItemQuery);
        if (!$result1) {
            throw new Exception("Error en la actualización de item: " . mysqli_error($connection));
        }

        $updateConsumoQuery = "UPDATE `consumo` SET `Cantidad_Pintura` = '$paintQuantity', `Lavado` = '$timeWash', `Pintura` = '$timePaint', `Horneo` = '$timeFurnace' WHERE `id_Item` = '$idItem'";
        $result2 = mysqli_query($connection, $updateConsumoQuery);
        if (!$result2) {
            throw new Exception("Error en la actualización de consumo: " . mysqli_error($connection));
        }

        mysqli_commit($connection);
        echo "<script> alert('Item actualizado correctamente'); </script>";
        header('location:inicioAdmin.php');
    } catch (Exception $e) {
        mysqli_rollback($connection);
        echo "<script> alert('Error al actualizar el item: " . $e->getMessage() . "'); </script>";
    }

    mysqli_close($connection);
}

?>