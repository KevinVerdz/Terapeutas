<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user_id = $_SESSION['user_id'];

    // Consulta SQL para actualizar el perfil
    if (!empty($password)) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare('UPDATE usuarios SET nombre = :nombre, usuario = :usuario, email = :email, contrasena = :password WHERE id = :id');
        $stmt->bindParam(':password', $passwordHash);
    } else {
        $stmt = $conn->prepare('UPDATE usuarios SET nombre = :nombre, usuario = :usuario, email = :email WHERE id = :id');
    }
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':usuario', $usuario);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':id', $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('Perfil actualizado exitosamente.'); window.location.href = 'perfil.php';</script>";
    } else {
        echo "<script>alert('Error al actualizar el perfil.'); window.location.href = 'perfil.php';</script>";
    }
} else {
    header('Location: perfil.php');
    exit();
}
?>
