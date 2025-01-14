<?php

if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
    header('location:../Login.php');
    exit();
}

if($_SESSION['rol'] != "Administrador"){
    header('location:../Analista/inicio.php');
}

function deleteItem(){ 
    include '../conexion.php';

    if(isset($_POST['deleteBtn'])){
        $selectedItem = $_GET['idDeletedItem'];
        $delete = "DELETE FROM `item` WHERE Numero_Item = '$selectedItem'";
        $result = mysqli_query($connection, $delete);

        if($result){
            echo "<script> alert('Item eliminado correctamente'); </script>";
            header('location:inicioAdmin.php');
        } else {
            echo "<script> alert('Error al eliminar el item'); </script>";
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
                    <h1>¿Estás seguro de que deseas eliminar este item?</h1>
                </div>
                <div class="buttonSection">
                    <button type="submit" name="deleteBtn" class="calculateButton"> Si </button>
                    <button type="button" class="cancelButton" onclick="cerrarFormulario()"> No </button>
                </div>
            </form>
        </section>
    </body>
    </html>
    
    <script>
        function cerrarFormulario() {
            const url = new URL(window.location.href);
            url.searchParams.delete('idDeletedItem');
            window.location.href = url.toString();
        }
    </script>

<?php } 


?>