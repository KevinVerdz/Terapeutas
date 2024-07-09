<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contenido = $_POST['contenido'];
    $usuario_id = $_SESSION['user_id']; // Suponiendo que guardas el ID del usuario en la sesión

    // Preparar la consulta SQL para insertar la nueva publicación
    $stmt = $conn->prepare("INSERT INTO publicaciones (contenido, usuario_id, fecha_publicacion) VALUES (:contenido, :usuario_id, NOW())");
    $stmt->bindParam(':contenido', $contenido);
    $stmt->bindParam(':usuario_id', $usuario_id);

    try {
        $stmt->execute();
        header("Location: inicio.php"); // Redirigir a la página principal después de insertar
        exit();
    } catch (PDOException $e) {
        echo "Error al insertar la publicación: " . $e->getMessage();
    }
}
?>
