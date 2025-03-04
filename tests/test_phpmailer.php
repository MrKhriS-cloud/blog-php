<?php
require 'vendor/autoload.php'; // Charger PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);
try {
    echo "PHPMailer est bien installé et fonctionne !";
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
