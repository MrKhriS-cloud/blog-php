<?php
session_start();
require '../includes/config.php';

// Vérifier si l'admin est connecté
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// Nombre d'articles par page
$articles_par_page = 5;

// Déterminer la page actuelle
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

// Calculer l'offset
$offset = ($page - 1) * $articles_par_page;

// Compter le nombre total d'articles
$total_articles = $pdo->query("SELECT COUNT(*) FROM articles")->fetchColumn();
$total_pages = ceil($total_articles / $articles_par_page);

// Récupérer les articles triés par date de création (plus récents en premier)
$stmt = $pdo->prepare("SELECT * FROM articles ORDER BY id DESC LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $articles_par_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Articles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/assets/css/styles.css">
    <link rel="icon" type="image/png" href="../public/assets/images/logo_blog.png">
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow p-4">
            <h2 class="text-center mb-4">📖 Gestion des Articles</h2>

            <div class="d-flex justify-content-between mb-3">
                <a href="dashboard.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Retour</a>
                <a href="article_add.php" class="btn btn-success"><i class="bi bi-plus-lg"></i> Ajouter un Article</a>
            </div>

            <!-- Tableau des articles -->
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Titre</th>
                            <th class="content-col">Contenu</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($articles as $article): ?>
                            <tr>
                                <td><?= htmlspecialchars($article['title']) ?></td>
                                <td class="content-col"><?= htmlspecialchars(substr($article['content'], 0, 50)) ?>...</td>
                                <td><?= htmlspecialchars($article['created_at']) ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="article_edit.php?id=<?= $article['id'] ?>" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i> Modifier
                                        </a>
                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" 
                                                data-id="<?= $article['id'] ?>" data-title="<?= htmlspecialchars($article['title']) ?>">
                                            <i class="bi bi-trash"></i> Supprimer
                                        </button>
                                        <a href="article_view.php?id=<?= $article['id'] ?>" class="btn btn-info btn-sm">
                                            <i class="bi bi-eye"></i> Voir
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <nav>
                <ul class="pagination justify-content-center">
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $page - 1 ?>"><i class="bi bi-chevron-left"></i> Précédent</a>
                        </li>
                    <?php endif; ?>

                    <li class="page-item disabled">
                        <span class="page-link">Page <?= $page ?> sur <?= $total_pages ?></span>
                    </li>

                    <?php if ($page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $page + 1 ?>">Suivant <i class="bi bi-chevron-right"></i></a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>

    <!-- MODAL DE SUPPRESSION -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">⚠ Confirmation de suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir supprimer l'article <strong id="articleTitle"></strong> ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <a href="#" id="confirmDelete" class="btn btn-danger">Oui, supprimer</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Import du fichier JS externe -->
    <script src="../public/assets/js/scripts.js"></script>
</body>
</html>
