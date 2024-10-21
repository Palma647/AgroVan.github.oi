<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado del Alquiler - Agrocomercial</title>
    <link rel="stylesheet" href="styles.css"> <!-- Aquí enlazas tu CSS existente -->
    <style>
        /* Incluye el mismo estilo en línea si no se está usando un archivo CSS */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        header {
            background: #3b8122;
            color: white;
            padding: 10px 0;
            text-align:;
        }
        nav a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
            padding: 10px;
            border-radius: 50px;
            transition: background-color 0.3s;
        }
        section {
            padding: 20px;
            background: white;
            margin: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        footer {
            text-align: center;
            padding: 10px 0;
            background: #3b8122;
            color: white;
            position: relative;
            bottom: 0;
            width: 100%;
        }
        .mensaje {
            font-size: 18px;
            color: #3b8122;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>

<header>
    <h1><center>Resultado del Alquiler</center></h1>
    <nav>
        
        <a href="maquinaria.html">Volver a Maquinaria</a>
        
    </nav>
</header>

<section>
    <h2><center>Resultado de tu solicitud</center></h2>
    <p class="mensaje">
        <?php
        // Configuración de conexión a la base de datos
        $host = 'localhost'; // Cambia si es necesario
        $dbname = 'agrocomercial';
        $username = 'root'; // Cambia si tienes otro usuario
        $password = ''; // Cambia si tienes contraseña

        try {
            // Crear una conexión a la base de datos
            $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Obtener los datos del formulario
            $producto = $_POST['producto'];
            $nombre = $_POST['nombre'];
            $telefono = $_POST['telefono'];
            $correo = $_POST['correo'];
            $direccion = $_POST['direccion'];
            $fecha = $_POST['fecha'];

            // Preparar la consulta SQL
            $sql = "INSERT INTO alquileres (producto, nombre, telefono, correo, direccion, fecha) 
                    VALUES (:producto, :nombre, :telefono, :correo, :direccion, :fecha)";

            $stmt = $conn->prepare($sql);
            
            // Asignar valores a los parámetros
            $stmt->bindParam(':producto', $producto);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':telefono', $telefono);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':direccion', $direccion);
            $stmt->bindParam(':fecha', $fecha);
            
            // Ejecutar la consulta
            $stmt->execute();

            echo "Solicitud de alquiler enviada exitosamente.";
            
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        // Cerrar la conexión
        $conn = null;
        ?>

</section>

<footer>
    <p>&copy; 2024 Agrocomercial Vangromi´S.</p>
</footer>

</body>
</html>
