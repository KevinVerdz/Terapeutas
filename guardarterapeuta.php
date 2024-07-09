<?php
require 'db.php';

// Obtener datos del formulario
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$usuario = $_POST['usuario'];
$email = $_POST['email'];
$telefono = $_POST['telefono'];
$cedulaProfesional = $_POST['cedula_profesional'];
$especialidad = $_POST['especialidad'];
$contrasena = $_POST['contrasena'];

// Hashear la contraseña
$hashedPassword = password_hash($contrasena, PASSWORD_DEFAULT);

// Preparar la consulta SQL
$stmt = $conn->prepare("INSERT INTO terapeutas (nombre, apellido, usuario, contrasena, email, telefono, cedula_profesional, especialidad) 
                       VALUES (:nombre, :apellido, :usuario, :contrasena, :email, :telefono, :cedula_profesional, :especialidad)");

// Bind de los parámetros
$stmt->bindParam(':nombre', $nombre);
$stmt->bindParam(':apellido', $apellido);
$stmt->bindParam(':usuario', $usuario);
$stmt->bindParam(':contrasena', $hashedPassword);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':telefono', $telefono);
$stmt->bindParam(':cedula_profesional', $cedulaProfesional);
$stmt->bindParam(':especialidad', $especialidad);

// Ejecutar la consulta
try {
    $stmt->execute();
    echo "<script>alert('¡Registro exitoso!'); window.location.href = 'index.html';</script>";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
