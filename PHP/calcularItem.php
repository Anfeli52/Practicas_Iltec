<?php


if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
    header('location:../Login.php');
    exit();
}

function showCalcule() { 
    include '../conexion.php';

    $selectedItem = $_GET['idItem'];
    $itemQuantity = isset($_POST['itemQuantity']) ? $_POST['itemQuantity'] : 1;
    $select = "SELECT * FROM `item` INNER JOIN `consumo` ON item.Numero_Item = consumo.id_Item WHERE item.Numero_Item = '$selectedItem'";
    $result = mysqli_query($connection, $select);
    $row = mysqli_fetch_assoc($result);
    
    $calculatedValues = ($itemQuantity > 1) ? calculate($selectedItem, $itemQuantity) : null;
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
            <form action="?idItem=<?php echo htmlspecialchars($row['Numero_Item'], ENT_QUOTES, 'UTF-8') ?>" class="popUpForm" method="post">
                <div class="itemInfo">
                    <?php 
                        echo "<strong> ITEM: ". $row['Numero_Item']. "</strong>"; 
                        echo "<strong>". $row['Nombre']. "</strong>";
                    ?>
                </div>
                <div class="itemQuantityDiv">
                    <p>
                        <label> Cantidad de Piezas</label> 
                        <input type="number" class="itemQuantity" name="itemQuantity" value="<?php echo htmlspecialchars($itemQuantity, ENT_QUOTES, 'UTF-8'); ?>">
                    </p>
                </div>
                <div class="infoSection">
                    <p>
                        <label> Cantidad de Pintura (Kg): </label>
                        <input type="number" class="paintQuantity" value="<?php echo ($itemQuantity > 1) ? $calculatedValues[3] : $row['Cantidad_Pintura']; ?>">
                    </p>
                    <p>
                        <label> Lavado (min): </label>
                        <input type="number" class="timeWash" value="<?php echo ($itemQuantity > 1) ? $calculatedValues[0] : $row['Lavado']; ?>">
                    </p>
                    <p>
                        <label> Pintura (min): </label>
                        <input type="number" class="timePaint" value="<?php echo ($itemQuantity > 1) ? $calculatedValues[1] : $row['Pintura']; ?>">
                    </p>
                    <p>
                        <label> Horno (min): </label>
                        <input type="number" class="timeFurnace" value="<?php echo ($itemQuantity > 1) ? $calculatedValues[2] : $row['Horneo']; ?>">
                    </p>
                </div>
                
                <div class="buttonSection">
                    <button type="submit" class="calculateButton"> Calcular </button>
                    <button type="button" class="cancelButton" onclick="cerrarFormulario()"> Cancelar </button>
                </div>
            </form>
        </section>
    </body>
    </html>

    <script>
        function cerrarFormulario() {
            const url = new URL(window.location.href);
            url.searchParams.delete('idItem');
            window.location.href = url.toString();
        }
    </script>

<?php }


function calculate($idItem, $quantity){
    include 'conexion.php';

    $select = "SELECT * FROM consumo WHERE id_Item = $idItem";
    $result = mysqli_query($connection, $select);
    $row = mysqli_fetch_assoc($result);
    $timeWash = $row['Lavado'] * $quantity;
    $timePaint = $row['Pintura'] * $quantity;
    $timeFurnace = $row['Horneo'] * $quantity;
    $paintQuantity = $row['Cantidad_Pintura'] * $quantity;

    $array = [$timeWash, $timePaint, $timeFurnace, $paintQuantity];

    mysqli_close($connection);
    return $array;
}

?>