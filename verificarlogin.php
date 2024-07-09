<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usu = $_POST['usu'];
    $cont = $_POST['cont'];

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario = :usu");
    $stmt->bindParam(':usu', $usu);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($cont, $user['contrasena'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['nombre'];
        header("Location: inicio.php");
        exit();
    } else {
        echo "<script>alert('Usuario o contraseña incorrectos.'); window.location.href = 'index.html';</script>";
    }
} else {
    header("Location: index.html");
    exit();
}
?>
