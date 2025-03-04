<?php
session_start();
require '../includes/config.php';

// Vérifier si l'admin est connecté
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$message = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $image = null;

    // Vérifier si une image a été téléchargée
    if (!empty($_FILES['image']['name'])) {
        $image_path = 'uploads/' . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], "../public/" . $image_path)) { 
            $image = $image_path;
        } else {
            $error = "Erreur lors de l'upload de l'image.";
        }
    }

    // Insérer l'article en base de données
    if (!$error) {
        $stmt = $pdo->prepare("INSERT INTO articles (title, content, image) VALUES (?, ?, ?)");
        if ($stmt->execute([$title, $content, $image])) {
            $message = "🎉 Article ajouté avec succès !";
        } else {
            $error = "Erreur lors de l'ajout.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Article</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="../public/assets/images/logo_blog.png">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow p-4">
            <h2 class="text-center mb-4">📝 Ajouter un Article</h2>

            <div class="mb-3 text-end">
                <a href="articles.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Retour</a>
            </div>

            <?php if (!empty($message)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Titre :</label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Contenu :</label>
                    <textarea name="content" rows="5" class="form-control" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Image :</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-plus-lg"></i> Ajouter</button>
            </form>
        </div>
    </div>
</body>

</html>
