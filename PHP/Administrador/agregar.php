<?php

if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
    header('location:../Login.php');
    exit();
}

if($_SESSION['rol'] != "Administrador"){
    header('location:../Analista/inicio.php');
}

function addItem(){
    include '../conexion.php';

    if(isset($_POST['updateBtn'])){
        $itemId = $_POST['itemId'];
        $itemName = $_POST['itemName'];
        $paintQuantity = $_POST['paintQuantity'];
        $timeWash = $_POST['timeWash'];
        $timePaint = $_POST['timePaint'];
        $timeFurnace = $_POST['timeFurnace'];
    
        if (empty($itemId) || empty($itemName) || empty($paintQuantity) || empty($timeWash) || empty($timePaint) || empty($timeFurnace)) {
            echo "<script> alert('Todos los campos son obligatorios'); </script>";
        } else {
            $checkQuery = "SELECT * FROM `item` WHERE `Numero_Item` = '$itemId'";
            $checkResult = mysqli_query($connection, $checkQuery);
    
            if (mysqli_num_rows($checkResult) > 0) {
                echo "<script> alert('El código del ítem ya existe'); </script>";
            } else {
                $insert = "INSERT INTO `item`(`Numero_Item`, `Nombre`, `CorreoRegistro`) VALUES ('$itemId', '$itemName', '".$_SESSION['email']."')";
                $result = mysqli_query($connection, $insert);
    
                if($result){
                    $insertConsumo = "INSERT INTO `consumo`(`id_Item`, `Cantidad_Pintura`, `Lavado`, `Pintura`, `Horneo`) VALUES ('$itemId', '$paintQuantity', '$timeWash', '$timePaint', '$timeFurnace')";
                    $resultConsumo = mysqli_query($connection, $insertConsumo);
    
                    if($resultConsumo){
                        echo "<script> alert('Item agregado correctamente'); </script>";
                        header('location:inicioAdmin.php');
                        exit();
                    } else {
                        echo "<script> alert('Error al agregar el item en consumo'); </script>";
                    }
                } else {
                    echo "<script> alert('Error al agregar el item'); </script>";
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
        function cerrarFormulario() {
            const url = new URL(window.location.href);
            url.searchParams.delete('addItem');
            window.location.href = url.toString();
        }
    </script>


<?php } ?>  