<?php


if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
    header('location:../Login.php');
    exit();
}

function showCalcule() { 
    include '../conexion.php';

    $selectedItem = $_GET['idItem'];
    $itemQuantity = $_GET['itemQuantity'];
    $select = "SELECT * FROM `item` INNER JOIN `consumo` ON item.Numero_Item = consumo.id_Item WHERE item.Numero_Item = '$selectedItem'";
    $result = mysqli_query($connection, $select);
    $row = mysqli_fetch_assoc($result);

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
            <form action="" class="popUpForm">
                <div class="itemInfo">
                    <?php 
                        echo "<strong> ITEM: ". $row['Numero_Item']. "</strong>"; 
                        echo "<strong>". $row['Nombre']. "</strong>";
                    ?>
                </div>
                <div class="itemQuantityDiv">
                    <p>
                        <label> Cantidad de Piezas</label> 
                        <input type="number" class="itemQuantity" value="1">
                    </p>
                </div>
                <div class="infoSection">
                    <p>
                        <label> Cantidad de Pintura (Kg): </label>
                        <input type="number" class="paintQuantity" value="<?php echo ($itemQuantity>1)?calculate($idItem, $itemQuantity)[3] : $row['Cantidad_Pintura'] ?>">
                    </p>
                    <p>
                        <label> Lavado (min): </label>
                        <input type="number" class="timeWash" value="<?php echo ($itemQuantity>1)?calculate($idItem, $itemQuantity)[0] : $row['Lavado'] ?>">
                    </p>
                    <p>
                        <label> Pintura (min): </label>
                        <input type="number" class="timePaint" value="<?php echo ($itemQuantity>1)?calculate($idItem, $itemQuantity)[1] : $row['Pintura'] ?>">
                    </p>
                    <p>
                        <label> Horno (min): </label>
                        <input type="number" class="timeFurnace" value="<?php echo ($itemQuantity>1)?calculate($idItem, $itemQuantity)[2] : $row['Horneo'] ?>">
                    </p>
                    
                </div>
                
                <div class="buttonSection">
                    <a href="?idItem=<?php echo htmlspecialchars($row['Numero_Item'], ENT_QUOTES, 'UTF-8') ?>&itemQuantity=<?php echo htmlspecialchars($itemQuantity, ENT_QUOTES, 'UTF-8') ?>" class="calculateButton"> Calcular </a>
                    <button class="cancelButton"> Cancelar </button>
                </div>
            </form>
        </section>
    </body>
    </html>

<?php } 


function calculate($idItem, $quantity){
    include 'conexion.php';
    
    $select = "SELECT * FROM item WHERE Numero_Item = $idItem";
    $result = mysqli_query($connection, $select);
    $row = mysqli_fetch_assoc($result);
    $timeWash = $row['Lavado'] * $quantity;
    $timePaint = $row['Pintura'] * $quantity;
    $timeFurnace = $row['Horneo'] * $quantity;
    $paintQuantity = $row['Cantidad_Pintura'] * $quantity;

    $array = [$timeWash, $timePaint, $timeFurnace, $paintQuantity];

    echo '<script> alert("'.$array[0].'") </script>';

    mysqli_close($connection);
    return $array;
    
}





function showEditElementByItem(){

}

function showDeleteElementByItem(){

}

function showAddItem(){

}



?>