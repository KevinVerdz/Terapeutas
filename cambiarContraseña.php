<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $password = $_POST['password'];

    // Buscar el token en la base de datos
    $stmt = $conn->prepare('SELECT * FROM password_resets WHERE token = :token AND expires_at > NOW()');
    $stmt->bindParam(':token', $token);
    $stmt->execute();
    $reset = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($reset) {
        // Actualizar la contraseña del usuario
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare('UPDATE usuarios SET password = :password WHERE email = :email');
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':email', $reset['email']);
        $stmt->execute();

        // Eliminar el token de la base de datos
        $stmt = $conn->prepare('DELETE FROM password_resets WHERE token = :token');
        $stmt->bindParam(':token', $token);
        $stmt->execute();

        echo "Tu contraseña ha sido cambiada con éxito.";
    } else {
        echo "El enlace de recuperación ha expirado o no es válido.";
    }
} else {
    $token = $_GET['token'];
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cambiar Contraseña</title>
        <link rel="stylesheet" href="css/index.css">
    </head>
    <body>
        <section>
            <div class="form-box">
                <div class="form-value">
                    <form action="cambiarContrasena.php" method="post" autocomplete="off">
                        <h2>Cambiar Contraseña</h2>
                        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                        <div class="inputbox">
                            <ion-icon name="lock-closed-outline"></ion-icon>
                            <input type="password" name="password" id="password" required>
                            <label for="password">Nueva Contraseña</label>
                        </div>
                        <button type="submit" class="button">Cambiar Contraseña</button>
                    </form>
                </div>
            </div>
        </section>
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    </body>
    </html>
    <?php
}
?>
