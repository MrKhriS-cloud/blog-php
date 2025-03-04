<?php
require '../includes/config.php';
require '../vendor/autoload.php'; // Importer PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$message = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim(htmlspecialchars($_POST['email'])); // Sécurisation de l'email

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Adresse email invalide.";
    } else {
        // Vérifier si l'email existe dans la base de données
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Vérifier si un token valide existe déjà
            if (!empty($user['reset_token']) && strtotime($user['reset_token_expires']) > time()) {
                $token = $user['reset_token'];
                $expiration = $user['reset_token_expires'];
            } else {
                // Générer un token unique et définir son expiration à 5 minutes
                $token = bin2hex(random_bytes(50));
                $expiration = date("Y-m-d H:i:s", strtotime("+5 minutes"));

                // Stocker le token et son expiration en base de données
                $stmt = $pdo->prepare("UPDATE users SET reset_token = ?, reset_token_expires = ? WHERE email = ?");
                $stmt->execute([$token, $expiration, $email]);
            }

            // Créer un lien sécurisé pour la réinitialisation
            $reset_link = "http://localhost/blog-php/admin/reset_password.php?token=" . $token;
            $expiration_time = date("H:i", strtotime($expiration));

            // Configurer PHPMailer
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'a71257905@gmail.com'; // Adresse Gmail
                $mail->Password = 'kwtz hqth bzxd nhtm'; // Mot de passe d'application
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
                $mail->CharSet = 'UTF-8'; // Ajout UTF-8 pour les accents

                // Expéditeur et destinataire
                $mail->setFrom('a71257905@gmail.com', 'Admin Blog');
                $mail->addAddress($email);

                // Contenu de l'email
                $mail->isHTML(true);
                $mail->Subject = "🔑 Réinitialisation de votre mot de passe";
                $mail->Body = "
                    <p>Bonjour,</p>
                    <p>Cliquez sur ce lien pour réinitialiser votre mot de passe :</p>
                    <p><a href='$reset_link'>$reset_link</a></p>
                    <p><strong>⚠ Attention :</strong> Ce lien est valable jusqu'à <strong>$expiration_time</strong> (5 minutes).</p>
                    <p>Si vous n'êtes pas à l'origine de cette demande, ignorez cet email.</p>
                ";

                // Envoyer l'email
                $mail->send();
                $message = "Un email de réinitialisation a été envoyé. Vérifiez votre boîte mail.";
            } catch (Exception $e) {
                $error = "Erreur lors de l'envoi de l'email : " . $mail->ErrorInfo;
            }
        } else {
            $error = "Aucun compte trouvé avec cet email.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="../public/assets/images/logo_blog.png">
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="card shadow p-4" style="width: 350px;">
        <h4 class="text-center text-nowrap">🔑 Mot de passe oublié</h4>
        <p class="text-center text-muted">Entrez votre adresse email pour recevoir un lien de réinitialisation.</p>

        <?php if (!empty($message)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <label class="form-label">Adresse email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Envoyer</button>
        </form>
        
        <div class="text-center mt-3">
            <a href="login.php">⬅ Retour à la connexion</a>
        </div>
    </div>
</body>
</html>
