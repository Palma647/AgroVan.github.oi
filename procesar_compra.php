<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";  // Cambia este campo según tu configuración
$dbname = "agrocomercial";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $nombreComprador = $_POST['buyerName'];
    $producto = $_POST['productName'];
    $cantidad = $_POST['quantity'];
    
    // Quitar el símbolo de moneda (L) del precio total
    $precioTotal = str_replace('L ', '', $_POST['totalPrice']);
    
    $metodoPago = $_POST['paymentMethod'];
    $tipoTarjeta = isset($_POST['cardType']) ? $_POST['cardType'] : null;
    $idTarjeta = isset($_POST['cardId']) ? $_POST['cardId'] : null;
    $correoPaypal = isset($_POST['paypalEmail']) ? $_POST['paypalEmail'] : null;
    $appTransferencia = isset($_POST['transferApp']) ? $_POST['transferApp'] : null;
    $fechaCompra = date("Y-m-d");

    // Inserción en la base de datos
    $sql = "INSERT INTO compras (nombre_comprador, producto, cantidad, precio_total, metodo_pago, tipo_tarjeta, id_tarjeta, correo_paypal, app_transferencia, fecha_compra) 
            VALUES ('$nombreComprador', '$producto', '$cantidad', '$precioTotal', '$metodoPago', '$tipoTarjeta', '$idTarjeta', '$correoPaypal', '$appTransferencia', '$fechaCompra')";

    if ($conn->query($sql) === TRUE) {
        // Mostrar mensaje de agradecimiento
        echo '
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Gracias por su compra</title>
            <style>
                body {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh; /* Ocupa toda la altura de la ventana */
                    margin: 0;
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4; /* Color de fondo */
                }

                .mensaje-agradecimiento {
                    text-align: center;
                    background-color: white;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                }

                h1 {
                    color: #28a745; /* Color verde para el título */
                }

                p {
                    color: #555; /* Color gris para el texto */
                }

                .boton-regresar {
                    display: inline-block;
                    margin-top: 20px;
                    padding: 10px 20px;
                    font-size: 16px;
                    color: white;
                    background-color: #28a745; /* Color verde para el botón */
                    border: none;
                    border-radius: 5px;
                    text-decoration: none;
                }

                .boton-regresar:hover {
                    background-color: #218838; /* Color verde más oscuro en hover */
                }
            </style>
        </head>
        <body>
            <div class="mensaje-agradecimiento">
                <h1>¡Gracias por su compra!</h1>
                <p>Su compra ha sido registrada con éxito.</p>
                <a href="productos.html" class="boton-regresar">Regresar a Productos</a>
            </div>
        </body>
        </html>';
        exit(); // Asegúrate de salir después de mostrar el mensaje
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
