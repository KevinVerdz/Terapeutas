<?php
// Conexión a la base de datos
try {
    $conn = new PDO("sqlsrv:server = tcp:terapeutas.database.windows.net,1433; Database = Terapeutas", "KevinVerdz", "Pochino123");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    print("Error connecting to SQL Server.");
    die(print_r($e));
}

// Manejo del inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario
    $usuario = $_POST["usu"];
    $contraseña = $_POST["cont"];

    // Realizar la consulta SQL para verificar las credenciales
    $query = "SELECT * FROM Usuarios WHERE usuario = ? AND contraseña = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$usuario, $contraseña]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si se encontró un usuario con las credenciales proporcionadas
    if ($row) {
        // Usuario autenticado, redirigir a la página de inicio o mostrar un mensaje de éxito
        // Por ejemplo:
        // header("Location: inicio.php");
        // exit();
        echo "Inicio de sesión exitoso!";
    } else {
        // Credenciales incorrectas, mostrar un mensaje de error o redirigir al formulario de inicio de sesión con un mensaje de error
        // Por ejemplo:
        // header("Location: login.html?error=credenciales_invalidas");
        // exit();
        echo "Usuario o contraseña incorrectos";
    }
}
?>
