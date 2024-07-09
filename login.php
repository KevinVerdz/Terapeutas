<?php
// Iniciar la sesión
session_start();

// Incluir archivo de conexión a la base de datos
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Preparar la consulta SQL para evitar inyecciones SQL
    $stmt = $conn->prepare('SELECT * FROM usuarios WHERE username = :username');
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar la contraseña
    if ($user && password_verify($password, $user['password'])) {
        // Guardar información del usuario en la sesión
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // Redirigir a la página principal
        header('Location: principal.html');
        exit;
    } else {
        // Mostrar mensaje de error
        $error = 'Usuario o contraseña incorrectos';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <section>
        <div class="form-box">
            <div class="form-value">
                <form method="POST" action="login.php" autocomplete="off">
                    <h2>Iniciar Sesión</h2>
                    <?php if (!empty($error)): ?>
                        <p style="color: red;"><?php echo $error; ?></p>
                    <?php endif; ?>
                    <div class="inputbox">
                        <ion-icon name="person-outline"></ion-icon>
                        <input type="text" name="username" required>
                        <label for="username">Usuario</label>
                    </div>
                    <div class="inputbox">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <input type="password" name="password" required>
                        <label for="password">Contraseña</label>
                    </div>
                    <div class="forget">
                        <label><input type="checkbox">Recuérdame</label>
                        <a href="#">¿Olvidaste tu contraseña?</a>
                    </div>
                    <button type="submit" class="button">Iniciar Sesión</button>
                    <div class="register">
                        <p>No tienes cuenta? <a href="register.html">Registrarse</a></p>
                        <p>¿Eres terapeuta? <a href="registerTerapeuta.html">Regístrate aquí</a></p>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>
