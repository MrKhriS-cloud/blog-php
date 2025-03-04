### Blog PHP - Espace Administrateur  

Un mini-système de blog en PHP natif permettant à un administrateur de gérer des articles. Ce projet respecte les bonnes pratiques de développement et inclut des fonctionnalités essentielles pour l’administration d’un blog.  

📌 **Fonctionnalités**  

🔐 **Gestion de l’authentification**  
✅ Connexion sécurisée pour l’administrateur  
✅ Déconnexion sécurisée  
✅ Protection des pages admin (accès restreint aux utilisateurs non connectés)  

🔑 **Gestion du mot de passe oublié**  
✅ Formulaire pour demander un lien de réinitialisation  
✅ Envoi d’un e-mail avec un lien temporaire valable 5 minutes  
✅ Formulaire sécurisé pour réinitialiser le mot de passe  

📝 **Gestion des articles**  
✅ Ajout d’un article avec :  
- Titre  
- Contenu (éditeur de texte simple)  
- Image associée (upload et stockage sécurisé)  
- Date de publication (générée automatiquement)  

✅ Modification d’un article existant  
✅ Suppression d’un article avec confirmation (popup Bootstrap)  
✅ Affichage et gestion des articles sous forme de tableau avec pagination  
✅ Aperçu détaillé d'un article avec son image et sa date de publication  

📊 **Pagination et ergonomie**  
✅ Affichage paginé des articles (5 par page)  
✅ Interface claire et responsive avec Bootstrap 5  
✅ Icônes intuitives (Bootstrap Icons)  

📧 **Envoi d’e-mails sécurisé avec PHPMailer**  
✅ Utilisation de PHPMailer pour l’envoi du lien de réinitialisation du mot de passe  
✅ Configuration SMTP avec Gmail (support TLS)  

🚀 **Installation et lancement**  

1️⃣ **Prérequis**  
- PHP 7.4 ou plus  
- MySQL  
- Composer  
- Un serveur local comme XAMPP ou WAMP  

2️⃣ **Cloner le projet**  
```
git clone https://github.com/MrKhriS-cloud/blog-php.git  
cd blog-php  
```  

3️⃣ **Installer les dépendances avec Composer**  
```
composer install  
```  

4️⃣ **Importer la base de données**  
- Ouvrir **phpMyAdmin**  
- Créer une base de données nommée **blog**  
- Importer le fichier **database/blog.sql**  

5️⃣ **Configurer la base de données**  
Dans le fichier **includes/config.php**, modifier les paramètres avec vos identifiants MySQL :  
```php
$host = 'localhost';  
$dbname = 'blog';  
$username = 'root';  
$password = '';  
```  

6️⃣ **Lancer le projet**  
- Démarrer Apache et MySQL dans XAMPP ou WAMP  
- Accéder à l’administration via l’adresse suivante :  
  👉 **http://localhost/blog-php/admin/login.php**  

🔑 **Identifiants Admin**  

**Email** : a71257905@gmail.com  
**Mot de passe** : @admin12345  

📧 **Configuration de l’envoi d’e-mails (PHPMailer)**  

🔹 **Cas 1 : Utilisation de Gmail**  
- Activer l'accès aux applications moins sécurisées dans votre compte Google  
- Générer un mot de passe d’application sur Google Security  
- Modifier les paramètres dans **admin/forgot_password.php**  

```php
$mail->isSMTP();  
$mail->Host = 'smtp.gmail.com';  
$mail->SMTPAuth = true;  
$mail->Username = 'VOTRE_EMAIL@gmail.com';  
$mail->Password = 'VOTRE_MOT_DE_PASSE_D_APP';  
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  
$mail->Port = 587;  
```  

🔹 **Cas 2 : Autre service SMTP (Outlook, Zoho, Mailtrap, etc.)**  
Adapter les paramètres selon votre fournisseur SMTP.  

📄 **Licence**  
Ce projet est développé pour un test de compétences PHP et peut être librement utilisé et amélioré.  

**Tout est prêt ! 🚀**
