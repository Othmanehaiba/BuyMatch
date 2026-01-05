<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../classes/User.php";
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])){
    $name = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];

    if($password !== $confirm_password){
        die("Les mots de passe ne correspondent pas.");
    }

    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    $userRepo = new User($name, $email, $password_hash, $role);
    $user_id = $userRepo->create_user($role);

    if($user_id){
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_name'] = $name;
        $_SESSION['user_role'] = $role;
        header("Location: login.php");
        exit();
    } else {
        die("Erreur lors de l'inscription. Veuillez réessayer.");
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BuyMatch - Inscription</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <!-- Header -->
    <header>
        <nav class="navbar">
            <div class="logo">⚽ BuyMatch</div>
            <ul class="nav-links">
                <li><a href="../index.php">Accueil</a></li>
                <li><a href="../pages/matchs.php">Matchs</a></li>
                <li><a href="login.php" class="btn btn-outline">Connexion</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="container">
        <div class="form-container">
            <h2 class="text-center mb-3">Inscription</h2>
            
            <form action="register.php" method="POST" data-validate>
                <div class="form-group">
                    <label for="nom">Nom complet</label>
                    <input type="text" id="nom" name="nom" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Confirmer le mot de passe</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="role">Type de compte</label>
                    <select id="role" name="role" class="form-control" required>
                        <option value="acheteur">Acheteur (Utilisateur)</option>
                        <option value="organisateur">Organisateur</option>
                    </select>
                </div>
                
                <button type="submit" name="submit" class="btn btn-primary w-100">S'inscrire</button>
            </form>
            
            <p class="text-center mt-3">
                Déjà inscrit ? <a href="login.php" style="color: var(--primary-color);">Se connecter</a>
            </p>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2026 BuyMatch. Tous droits réservés.</p>
    </footer>

    <script src="../assets/js/main.js"></script>
</body>
</html>
