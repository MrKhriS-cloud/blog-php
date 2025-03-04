<?php
session_start();
require '../includes/config.php';

// Vérifier si l'admin est connecté
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// Vérifier si un ID est fourni
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("<div class='alert alert-danger text-center'>⛔ Article introuvable.<br><br>
    <a href='articles.php' class='btn btn-primary'>⬅ Retour aux articles</a></div>");
}

// Récupérer l'article depuis la base de données
$id = (int) $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM articles WHERE id = ?");
$stmt->execute([$id]);
$article = $stmt->fetch(PDO::FETCH_ASSOC);

// Vérifier si l'article existe
if (!$article) {
    die("<div class='alert alert-danger text-center'>⛔ Article introuvable.<br><br>
    <a href='articles.php' class='btn btn-primary'>⬅ Retour aux articles</a></div>");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($article['title']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="../public/assets/images/logo_blog.png">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow p-4">
            <h2 class="text-center mb-3"><?= htmlspecialchars($article['title']) ?></h2>
            <p class="text-muted text-center"><strong>📅 Publié le :</strong> <?= htmlspecialchars($article['created_at']) ?></p>

            <?php if (!empty($article['image'])): ?>
                <div class="text-center">
                    <img src="../public/uploads/<?= basename($article['image']) ?>" class="img-fluid img-thumbnail mb-4" style="max-width: 400px;">
                </div>
            <?php endif; ?>

            <p class="fs-5"><?= nl2br(htmlspecialchars($article['content'])) ?></p>

            <div class="text-center mt-4">
                <a href="articles.php" class="btn btn-primary"><i class="bi bi-arrow-left"></i> Retour aux articles</a>
            </div>
        </div>
    </div>
</body>
</html>
