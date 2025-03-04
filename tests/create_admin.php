<?php
require 'includes/config.php';

$username = "admin";
$email = "a71257905@gmail.com";
$password = password_hash("@admin12345", PASSWORD_DEFAULT); // Hash du mot de passe

try {
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$username, $email, $password]);
    echo "Admin ajouté avec succès !";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
