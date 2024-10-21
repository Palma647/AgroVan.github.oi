<?php
// Datos de conexión
$servidor = "localhost"; // Servidor de Wamp
$usuario = "root"; // Usuario por defecto en Wamp
$clave = ""; // Contraseña por defecto es vacía en Wamp
$base_datos = "agrocomercial"; // Nombre de tu base de datos

// Crear la conexión
$conn = new mysqli($servidor, $usuario, $clave, $base_datos);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
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
        }
        section {
            padding: 20px;
            background: white;
            margin: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
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
        .success {
            color: green;
            font-weight: bold;
        }
        .error {
            color: red;
            font-weight: bold;
        }
    </style>
    <title>Resultado del Envío de Contacto</title>
</head>
<body>

<header>
    <h1><center>Datos Enviados Correctamente</center></h1>
    <nav>
        
        &nbsp;<a href="contacto.html">Atras</a>
    </nav>
</header>

<section>
    <h2><center>Resultado del Envío</center></h2>

    <?php
    // Verificar si se enviaron los datos del formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = $conn->real_escape_string($_POST['nombre']);
        $apellido = $conn->real_escape_string($_POST['apellido']);
        $email = $conn->real_escape_string($_POST['email']);
        $mensaje = $conn->real_escape_string($_POST['mensaje']);

        // Preparar la consulta SQL para insertar los datos
        $sql = "INSERT INTO contactos (nombre, apellido, email, mensaje) VALUES ('$nombre', '$apellido', '$email', '$mensaje')";

        // Ejecutar la consulta y comprobar si se insertó correctamente
        if ($conn->query($sql) === TRUE) {
            echo "<center><p class='success'>Nos pondremos en contacto contigo pronto.</p></center>";
        } else {
            echo "<p class='error'>Error: " . $sql . "<br>" . $conn->error . "</p>";
        }
    }

    // Cerrar la conexión
    $conn->close();
    ?>
</section>

<footer>
    <p>&copy; 2024 Agrocomercial Vangromi´S.</p>
</footer>

</body>
</html>
