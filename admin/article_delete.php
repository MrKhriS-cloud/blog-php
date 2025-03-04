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

// Récupérer l'article avant suppression
$stmt = $pdo->prepare("SELECT image FROM articles WHERE id = ?");
$stmt->execute([$id]);
$article = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$article) {
    header("Location: articles.php");
    exit;
}

// Supprimer l'image associée si elle existe
$image_path = "../" . $article['image'];
if (!empty($article['image']) && file_exists($image_path)) {
    unlink($image_path);
}

// Supprimer l'article
$stmt = $pdo->prepare("DELETE FROM articles WHERE id = ?");
$stmt->execute([$id]);

// Redirection vers la liste des articles
header("Location: articles.php");
exit;
?>
