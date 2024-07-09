<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Comprobar si el email existe en la base de datos
    $stmt = $conn->prepare('SELECT * FROM usuarios WHERE email = :email');
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Generar un token único
        $token = bin2hex(random_bytes(50));
        
        // Guardar el token en la base de datos con una fecha de expiración
        $stmt = $conn->prepare('INSERT INTO password_resets (email, token, expires_at) VALUES (:email, :token, DATE_ADD(NOW(), INTERVAL 1 HOUR))');
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':token', $token);
        $stmt->execute();

        // Enviar el email con el enlace de recuperación
        $resetLink = "http://terapeutas.lovestoblog.com/cambiarContrasena.php?token=$token";
        $to = $email;
        $subject = "Recuperar contraseña";
        $message = "Para cambiar tu contraseña, haz clic en el siguiente enlace: $resetLink";
        $headers = 'From: no-reply@lovestoblog.com' . "\r\n" .
                   'Reply-To: no-reply@lovestoblog.com' . "\r\n" .
                   'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);
    }

    // Mostrar un mensaje indicando que se ha enviado el correo (aunque el email no exista, por seguridad)
    echo "Si el correo está registrado, recibirás un email con instrucciones para cambiar tu contraseña.";
}
?>
