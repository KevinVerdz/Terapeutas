<?php
session_start();

// Verificación de sesión
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Aquí puedes incluir tu archivo de conexión a la base de datos
require 'db.php';

// Ejemplo de consulta para obtener las publicaciones
$stmt = $conn->query('SELECT * FROM publicaciones ORDER BY fecha_publicacion DESC');
$publicaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal - Similar a Facebook</title>
    <link rel="stylesheet" href="css/index.css">
    <style>
        /* Estilos CSS adicionales */
        /* Define estilos para el diseño de la página */
    </style>
</head>
<body>
    <!-- Encabezado con botones de navegación -->
    <header>
        <nav>
            <ul>
                <li><a href="#">Inicio</a></li>
                <li><a href="#">Publicaciones</a></li>
                <li><a href="#">Mensajes</a></li>
                <li><a href="#">Perfil</a></li>
                <li><a href="logout.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <!-- Sección central para mostrar publicaciones -->
        <section class="publicaciones">
            <!-- Formulario para hacer una nueva publicación -->
            <form action="nuevaPublicacion.php" m
