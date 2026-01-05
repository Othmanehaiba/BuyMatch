<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../classes/User.php";
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $pdo = Database::getConnection();
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if($user && password_verify($password, $user['password_hash'])){
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['nom'];
        $_SESSION['user_role'] = $user['role'];

        if($user['role'] === 'organisateur'){
            header("Location: ../organizer/dashboard.php");
        } else {
            header("Location: home.php");
        }
    } else {
        die("Email ou mot de passe incorrect");
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BuyMatch - Connexion</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <!-- Header -->
    <header>
        <nav class="navbar">
            <div class="logo">⚽ BuyMatch</div>
            <ul class="nav-links">
                <li><a href="../index.php">Accueil</a></li>
                <li><a href="../pages/matches.php">Matchs</a></li>
                <li><a href="register.php" class="btn btn-primary">S'inscrire</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="container">
        <div class="form-container">
            <h2 class="text-center mb-3">Connexion</h2>
            
            <!-- Alert Example (PHP would generate this) -->
            <!-- <div class="alert alert-error">Email ou mot de passe incorrect</div> -->
            
            <form action="login.php" method="POST" data-validate>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                
                <button type="submit" class="btn btn-primary w-100">Se connecter</button>
            </form>
            
            <p class="text-center mt-3">
                Pas encore de compte ? <a href="register.php" style="color: var(--primary-color);">S'inscrire</a>
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
