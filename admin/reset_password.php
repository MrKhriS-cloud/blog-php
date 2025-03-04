<?php
session_start();
require '../includes/config.php';

$message = "";
$error = "";
$token = $_GET['token'] ?? '';

if (!$token) {
    die("<div class='alert alert-danger text-center'>⛔ Token invalide.<br><br>
    <a href='forgot_password.php' class='btn btn-primary'>🔄 Demander un nouveau lien</a></div>");
}

// Vérifier si le token est valide et non expiré
$stmt = $pdo->prepare("SELECT * FROM users WHERE reset_token = ? AND reset_token_expires > NOW()");
$stmt->execute([$token]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("<div class='alert alert-danger text-center'>⏳ Lien de réinitialisation invalide ou expiré.<br><br>
    <a href='forgot_password.php' class='btn btn-primary'>🔄 Demander un nouveau lien</a></div>");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = trim($_POST['password'] ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');

    if (empty($new_password) || empty($confirm_password)) {
        $error = "Veuillez remplir tous les champs.";
    } elseif ($new_password !== $confirm_password) {
        $error = "❌ Les mots de passe ne correspondent pas.";
    } elseif (strlen($new_password) < 8) {
        $error = "🔑 Le mot de passe doit contenir au moins 8 caractères.";
    } else {
        // Hachage du mot de passe
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Mettre à jour le mot de passe et supprimer le token
        $stmt = $pdo->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_token_expires = NULL WHERE reset_token = ?");
        if ($stmt->execute([$hashed_password, $token])) {
            header("Location: login.php?reset=success");
            exit;
        } else {
            sleep(1); // Protection contre les attaques Brute Force
            $error = "Erreur lors de la mise à jour du mot de passe.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="../public/assets/images/logo_blog.png">
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="card shadow p-4" style="width: 450px;">
        <h4 class="text-center text-nowrap">🔒 Réinitialisation du mot de passe</h4>
        <p class="text-center text-muted">Entrez un nouveau mot de passe sécurisé (minimum 8 caractères).</p>

        <?php if (!empty($message)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <label class="form-label">Nouveau mot de passe</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Confirmer le mot de passe</label>
                <input type="password" name="confirm_password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Mettre à jour</button>
        </form>
        
        <div class="text-center mt-3">
            <a href="login.php">⬅ Retour à la connexion</a>
        </div>
    </div>
</body>
</html>
