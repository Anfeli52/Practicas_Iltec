<?php


if (!isset($_SESSION['email']) || empty($_SESSION['email'])) { // Este if es para verificar si el usuario está logueado
    header('location:../Login.php'); // Si no está logueado lo redirige al login
    exit(); // Termina la ejecución del script
}

function showCalcule() { // Esta función muestra el formulario para calcular los tiempos de un item
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
            <form action="?idItem=<?php echo htmlspecialchars($row['Numero_Item'], ENT_QUOTES, 'UTF-8') ?>" class="popUpForm" method="post"> <!-- Se manda el id del item en el action -->
                <div class="itemInfo">
                    <?php 
                        echo "<strong> ITEM: ". $row['Numero_Item']. "</strong>"; // Se muestra el número del item
                        echo "<strong>". $row['Nombre']. "</strong>"; // Se muestra el nombre del item
                    ?>
                </div>
                <div class="itemQuantityDiv">
                    <p>
                        <label> Cantidad de Piezas</label> 
                        <input type="number" class="itemQuantity" name="itemQuantity" value="<?php echo htmlspecialchars($itemQuantity, ENT_QUOTES, 'UTF-8'); ?>"> <!-- Se muestra la cantidad de piezas -->
                    </p>
                </div>
                <div class="infoSection">
                    <p>
                        <label> Cantidad de Pintura (Kg): </label>
                        <input type="number" class="paintQuantity" value="<?php echo ($itemQuantity > 1) ? $calculatedValues[3] : $row['Cantidad_Pintura']; ?>"> <!-- Se muestra la cantidad de pintura -->
                    </p>
                    <p>
                        <label> Lavado (min): </label>
                        <input type="number" class="timeWash" value="<?php echo ($itemQuantity > 1) ? $calculatedValues[0] : $row['Lavado']; ?>"> <!-- Se muestra el tiempo de lavado -->
                    </p>
                    <p>
                        <label> Pintura (min): </label>
                        <input type="number" class="timePaint" value="<?php echo ($itemQuantity > 1) ? $calculatedValues[1] : $row['Pintura']; ?>"> <!-- Se muestra el tiempo de pintura -->
                    </p>
                    <p>
                        <label> Horno (min): </label>
                        <input type="number" class="timeFurnace" value="<?php echo ($itemQuantity > 1) ? $calculatedValues[2] : $row['Horneo']; ?>"> <!-- Se muestra el tiempo de horno -->
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
        function cerrarFormulario() { // Esta función cierra el formulario
            const url = new URL(window.location.href); // Se obtiene la url actual
            url.searchParams.delete('idItem'); // Se elimina el parámetro idItem
            window.location.href = url.toString(); // Se redirige a la url sin el parámetro idItem
        }
    </script>

<?php }


function calculate($idItem, $quantity){ // Esta función calcula los tiempos de un item
    include 'conexion.php'; // Se incluye el archivo de conexión

    $select = "SELECT * FROM consumo WHERE id_Item = $idItem"; // Se seleccionan los datos del item
    $result = mysqli_query($connection, $select); // Se ejecuta la consulta
    $row = mysqli_fetch_assoc($result); // Se obtienen los datos
    $timeWash = $row['Lavado'] * $quantity; // Se calcula el tiempo de lavado
    $timePaint = $row['Pintura'] * $quantity; // Se calcula el tiempo de pintura
    $timeFurnace = $row['Horneo'] * $quantity; // Se calcula el tiempo de horno
    $paintQuantity = $row['Cantidad_Pintura'] * $quantity; // Se calcula la cantidad de pintura

    $array = [$timeWash, $timePaint, $timeFurnace, $paintQuantity]; // Se crea un array con los valores calculados

    mysqli_close($connection); // Se cierra la conexión
    return $array; // Se retorna el array
}

?>