<?php

require_once 'classes/MatchRepository.php';
$matchRepo = new MatchRepository();
$matches = $matchRepo->getAllValidateMatches();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BuyMatch - Accueil</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Header -->
    <header>
        <nav class="navbar">
            <div class="logo">⚽ BuyMatch</div>
            <ul class="nav-links">
                <li><a href="index.php">Accueil</a></li>
                <!-- <li><a href="pages/matches.php">Matchs</a></li > -->
                <li><a href="pages/login.php" class="btn btn-outline">Connexion</a></li>
                <li><a href="pages/register.php" class="btn btn-primary">S'inscrire</a></li>
            </ul>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Réservez vos places pour les meilleurs matchs</h1>
            <p>Découvrez et achetez vos billets pour les événements sportifs en quelques clics</p>
            <a href="pages/login.php" class="btn btn-secondary">Voir les matchs</a>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container">
        <h2>Prochains matchs</h2>
        
        <!-- Filter Bar -->
        <div class="filter-bar">
            <input type="text" class="form-control" placeholder="Rechercher un match...">
            <select class="form-control">
                <option value="">Tous les lieux</option>
                <option value="casablanca">Casablanca</option>
                <option value="rabat">Rabat</option>
                <option value="marrakech">Marrakech</option>
            </select>
            <select class="form-control">
                <option value="">Toutes les dates</option>
                <option value="today">Aujourd'hui</option>
                <option value="week">Cette semaine</option>
                <option value="month">Ce mois</option>
            </select>
        </div>

        <!-- Matches Grid -->
        <div class="cards-grid">
            <?php foreach ($matches as $match): ?>
            <div class="card">
                <div class="card-image" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
                    ⚽ Match
                </div>
                <div class="card-body">
                    <h3 class="card-title"><?php echo htmlspecialchars($match['team1_name']);?> VS <?php echo htmlspecialchars($match['team2_name']); ?></h3>
                    <p class="card-text">📍 <?php echo htmlspecialchars($match['location']); ?></p>
                    <p class="card-text">📅 <?php echo htmlspecialchars($match['date_heure']); ?></p>
                    <div class="card-footer">
                        <span class="badge badge-success">Disponible</span>
                        <span style="font-weight: bold; color: var(--primary-color);">À partir de 100 MAD</span>
                    </div>
                    <a href="pages/login.php" class="btn btn-primary w-100 mt-2">Voir détails</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2026 BuyMatch. Tous droits réservés.</p>
    </footer>

    <script src="assets/js/main.js"></script>
</body>
</html>
