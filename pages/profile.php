<?php
session_start();
require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../classes/User.php";

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {    
    header("Location: ../index.php");
    exit();
}
$userInfos = User::getUserInfos((int)$user_id);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BuyMatch - Mon Profil</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <!-- Header -->
    <header>
        <nav class="navbar">
            <div class="logo">⚽ BuyMatch</div>
            <ul class="nav-links">
                <li><a href="home.php">Accueil</a></li>
                <li><a href="matches.php">Matchs</a></li>
                <li><a href="profile.php">Mon Profil</a></li>
                <li><a href="../auth/logout.php" class="btn btn-danger">Déconnexion</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="container">
        <h2>Mon Profil</h2>

        <!-- Profile Info -->
        <div class="card mt-3">
            <div class="card-body">
                <h3 class="mb-2">Informations personnelles</h3>
                
                <form action="profile.php" method="POST">
                    <div class="form-group">
                        <label for="nom">Nom complet</label>
                        <input style="cursor: not-allowed;" type="text" id="nom" name="nom" class="form-control" value="<?= htmlspecialchars($userInfos[0]['nom']) ?>"  disabled>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input style="cursor: not-allowed;"  type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($userInfos[0]['email']) ?>" disabled>
                    </div>
                    
                </form>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2026 BuyMatch. Tous droits réservés.</p>
    </footer>

    <script src="../assets/js/main.js"></script>
    
</body>
</html>
