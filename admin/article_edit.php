<?php
session_start();
require '../includes/config.php';

// Vérifier si l'admin est connecté
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// Vérifier si un ID d'article est fourni
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: articles.php");
    exit;
}

$id = $_GET['id'];

// Récupérer les informations de l'article
$stmt = $pdo->prepare("SELECT * FROM articles WHERE id = ?");
$stmt->execute([$id]);
$article = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$article) {
    header("Location: articles.php");
    exit;
}

$message = "";
$error = "";

// Mettre à jour l'article
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $image = $article['image']; // Garder l'ancienne image par défaut

    // Vérifier si une nouvelle image a été uploadée
    if (!empty($_FILES['image']['name'])) {
        // Supprimer l'ancienne image si elle existe
        if (!empty($article['image']) && file_exists("../" . $article['image'])) {
            unlink("../" . $article['image']);
        }

        $uploads_dir = "../public/uploads/";
        $image_path = $uploads_dir . basename($_FILES['image']['name']);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
            $image = "public/uploads/" . basename($_FILES['image']['name']); // Stocker le chemin relatif
        } else {
            $error = "Erreur lors de l'upload de l'image.";
        }
    }

    // Mettre à jour l'article dans la base de données
    if (!$error) {
        $stmt = $pdo->prepare("UPDATE articles SET title = ?, content = ?, image = ? WHERE id = ?");
        if ($stmt->execute([$title, $content, $image, $id])) {
            $message = "✅ Article mis à jour avec succès !";
            // Rafraîchir les données
            $article['title'] = $title;
            $article['content'] = $content;
            $article['image'] = $image;
        } else {
            $error = "Erreur lors de la mise à jour.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Article</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="../public/assets/images/logo_blog.png">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow p-4">
            <h2 class="text-center mb-4">✏ Modifier un Article</h2>

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
                    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($article['title']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Contenu :</label>
                    <textarea name="content" rows="5" class="form-control" required><?= htmlspecialchars($article['content']) ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Image actuelle :</label><br>
                    <?php if ($article['image']): ?>
                        <img src="../public/<?= $article['image'] ?>" class="img-thumbnail" width="200"><br><br>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label class="form-label">Changer l'image :</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-save"></i> Enregistrer les modifications</button>
            </form>
        </div>
    </div>
</body>
</html>
