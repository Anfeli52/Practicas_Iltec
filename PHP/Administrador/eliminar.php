<?php

if (!isset($_SESSION['email']) || empty($_SESSION['email'])) { // Este if es para verificar si el usuario está logueado
    header('location:../Login.php'); // Si no está logueado lo redirige al login
    exit(); // Termina la ejecución del script
}

if($_SESSION['rol'] != "Administrador"){ // Este if es para verificar si el usuario es un administrador
    header('location:../Analista/inicio.php'); // Si no es un administrador lo red
}

function deleteItem(){  // Esta función muestra el formulario para eliminar un item
    include '../conexion.php'; // Se incluye el archivo de conexión

    if(isset($_POST['deleteBtn'])){ // Este if es para verificar si se presionó el botón de eliminar
        $selectedItem = $_GET['idDeletedItem']; // Se obtiene el id del item a eliminar
        $delete = "DELETE FROM `item` WHERE Numero_Item = '$selectedItem'"; // Se elimina el item de la base de datos
        $result = mysqli_query($connection, $delete); // Ejecuta la consulta

        if($result){ // Este if es para verificar si se eliminó el item correctamente
            echo "<script> alert('Item eliminado correctamente'); </script>"; // Si se eliminó correctamente muestra un mensaje de alerta
            header('location:inicioAdmin.php'); // Redirige al inicio del administrador
            exit(); // Termina la ejecución del script
        } else { // Si no se eliminó correctamente el item
            echo "<script> alert('Error al eliminar el item'); </script>"; // Muestra un mensaje de alerta
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
        function cerrarFormulario() { // Esta función cierra el formulario
            const url = new URL(window.location.href); // Se obtiene la url actual
            url.searchParams.delete('idDeletedItem'); // Se elimina el id del item
            window.location.href = url.toString(); // Se redirige a la url sin el id del item
        }
    </script>

<?php } 


?>