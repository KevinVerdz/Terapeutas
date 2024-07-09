<?php
require 'db.php';

// Obtener datos del formulario
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$usuario = $_POST['usuario'];
$email = $_POST['email'];
$telefono = $_POST['telefono'];
$contrasena = $_POST['contrasena'];

// Hashear la contraseña
$hashedPassword = password_hash($contrasena, PASSWORD_DEFAULT);

// Preparar la consulta SQL
$stmt = $conn->prepare("INSERT INTO usuarios (nombre, apellido, usuario, contrasena, email, telefono) 
                       VALUES (:nombre, :apellido, :usuario, :contrasena, :email, :telefono)");

// Bind de los parámetros
$stmt->bindParam(':nombre', $nombre);
$stmt->bindParam(':apellido', $apellido);
$stmt->bindParam(':usuario', $usuario);
$stmt->bindParam(':contrasena', $hashedPassword);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':telefono', $telefono);

// Ejecutar la consulta
try {
    $stmt->execute();
    echo "<script>alert('¡Registro exitoso!'); window.location.href = 'index.html';</script>";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
