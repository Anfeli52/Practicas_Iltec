<?php


if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
    header('location:../Login.php');
    exit();
}

function calcule() { 
    include '../conexion.php';

    $selectedItem = $_GET['idItem'];
    $select = "SELECT * FROM item WHERE Numero_Item = $selectedItem";
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
                        <input type="number" class="itemQuantity">
                    </p>
                </div>
                <div class="infoSection">
                    <p>
                        <label> Cantidad de Pintura (Kg): </label>
                        <input type="number" class="paintQuantity">
                    </p>
                    <p>
                        <label> Lavado (min): </label>
                        <input type="number" class="timeWash">
                    </p>
                    <p>
                        <label> Pintura (min): </label>
                        <input type="number" class="timePaint">
                    </p>
                    <p>
                        <label> Horno (min): </label>
                        <input type="number" class="timeFurnace">
                    </p>
                    
                </div>
                
                <div class="buttonSection">
                    <button class="calculateButton"> Calcular </button>
                    <button class="cancelButton"> Cancelar </button>
                </div>
            </form>
        </section>
    </body>
    </html>

<?php } 


function editElementByItem(){

}

function deleteElementByItem(){

}

function addItem(){

}



?>