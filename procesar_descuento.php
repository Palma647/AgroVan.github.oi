<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Procesar Descuento</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
            text-align: center;
        }
        .message {
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            font-size: 16px;
        }
        .success {
            background-color: #dff0d8;
            color: #3c763d;
            border: 1px solid #d6e9c6;
        }
        .error {
            background-color: #f2dede;
            color: #a94442;
            border: 1px solid #ebccd1;
        }
        h2 {
            color: #3b8122;
        }
        .back-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
        }
        .back-button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Resultado del Registro de Compra</h2>
        <form id="discountForm" action="procesar_descuento.php" method="POST">

        <?php
        // Configuración de la base de datos
        $servidor = "localhost";
        $usuario = "root";
        $contrasena = "";
        $nombreBD = "agrocomercial";

        // Crear conexión
        $conn = new mysqli($servidor, $usuario, $contrasena, $nombreBD);

        // Verificar la conexión
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Verificar que la solicitud sea POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Obtener los datos del formulario
            $nombreComprador = $_POST['buyerName'];
            $producto = $_POST['product'];
            $cantidad = (int) $_POST['quantity'];
            $precioTotal = $_POST['total'];
            $descuento = $_POST['discount'];
            $totalConDescuento = $_POST['totalWithDiscount'];
            $metodoPago = $_POST['paymentMethod'];

            // Opcionales según el método de pago
            $idTarjeta = !empty($_POST['cardID']) ? $_POST['cardID'] : null;
            $numeroTarjeta = !empty($_POST['cardNumber']) ? $_POST['cardNumber'] : null;
            $emailPaypal = !empty($_POST['paypalEmail']) ? $_POST['paypalEmail'] : null;
            $appTransferencia = !empty($_POST['transferApp']) ? $_POST['transferApp'] : null;
            $numeroTarjetaTransferencia = !empty($_POST['transferCardNumber']) ? $_POST['transferCardNumber'] : null;

            // Preparar la consulta SQL para insertar en la tabla descuento
            $sql = "INSERT INTO descuento 
                (nombre_comprador, producto, cantidad, precio_total, descuento, total_con_descuento, metodo_pago, id_tarjeta, numero_tarjeta, email_paypal, app_transferencia, numero_tarjeta_transferencia) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            // Preparar la declaración
            $stmt = $conn->prepare($sql);
            $stmt->bind_param(
                'ssissssissss', 
                $nombreComprador, 
                $producto, 
                $cantidad, 
                $precioTotal, 
                $descuento, 
                $totalConDescuento, 
                $metodoPago, 
                $idTarjeta, 
                $numeroTarjeta, 
                $emailPaypal, 
                $appTransferencia, 
                $numeroTarjetaTransferencia
            );

            // Ejecutar la consulta
            if ($stmt->execute()) {
                echo '<div class="message success">Compra con descuento registrada correctamente.</div>';
            } else {
                echo '<div class="message error">Error al registrar la compra: ' . $stmt->error . '</div>';
            }

            // Cerrar la declaración y la conexión
            $stmt->close();
        }

        $conn->close();
        ?>

        <!-- Botón para regresar a los productos con descuento -->
        <a href="productosdescuento.html" class="back-button">Volver a productos con descuento</a>
    </div>
</body>
</html>
