<?php
// Conexión a la base de datos
try {
    $conn = new PDO("sqlsrv:server = tcp:terapeutas.database.windows.net,1433; Database = Terapeutas", "KevinVerdz", "Pochino123");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    print("Error connecting to SQL Server.");
    die(print_r($e));
}

// Manejo del registro de usuario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario
    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellidos"];
    $usuario = $_POST["usu"];
    $contraseña = $_POST["cont"];
    $email = $_POST["contUsuario"];
    $telefono = $_POST["telUsuario"];

    // Realizar la inserción en la base de datos
    $query = "INSERT INTO Usuarios (nombre, apellidos, usuario, contraseña, email, telefono) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->execute([$nombre, $apellidos, $usuario, $contraseña, $email, $telefono]);

    // Verificar si la inserción fue exitosa
    if ($stmt->rowCount() > 0) {
        // Registro exitoso, redirigir a la página de inicio o mostrar un mensaje de éxito
        // Por ejemplo:
        // header("Location: inicio.php");
        // exit();
        echo "Registro exitoso!";
    } else {
        // Ocurrió un error durante el registro, mostrar un mensaje de error o redirigir al formulario de registro con un mensaje de error
        // Por ejemplo:
        // header("Location: registro.html?error=registro_fallido");
        // exit();
        echo "Error durante el registro.";
    }
}
?>
