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
                <li><a href="pages/matches.php">Matchs</a></li>
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
            <a href="pages/matches.php" class="btn btn-secondary">Voir les matchs</a>
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
            <!-- Match Card 1 -->
            <div class="card">
                <div class="card-image" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
                    ⚽ Match
                </div>
                <div class="card-body">
                    <h3 class="card-title">Raja vs Wydad</h3>
                    <p class="card-text">📍 Stade Mohammed V, Casablanca</p>
                    <p class="card-text">📅 15 Janvier 2026 - 20:00</p>
                    <div class="card-footer">
                        <span class="badge badge-success">Disponible</span>
                        <span style="font-weight: bold; color: var(--primary-color);">À partir de 150 MAD</span>
                    </div>
                    <a href="pages/match_details.php?id=1" class="btn btn-primary w-100 mt-2">Voir détails</a>
                </div>
            </div>

            <!-- Match Card 2 -->
            <div class="card">
                <div class="card-image" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
                    ⚽ Match
                </div>
                <div class="card-body">
                    <h3 class="card-title">AS FAR vs Renaissance</h3>
                    <p class="card-text">📍 Complexe Prince Moulay Abdellah, Rabat</p>
                    <p class="card-text">📅 18 Janvier 2026 - 18:00</p>
                    <div class="card-footer">
                        <span class="badge badge-warning">Peu de places</span>
                        <span style="font-weight: bold; color: var(--primary-color);">À partir de 100 MAD</span>
                    </div>
                    <a href="pages/match_details.php?id=2" class="btn btn-primary w-100 mt-2">Voir détails</a>
                </div>
            </div>

            <!-- Match Card 3 -->
            <div class="card">
                <div class="card-image" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
                    ⚽ Match
                </div>
                <div class="card-body">
                    <h3 class="card-title">Kawkab vs Hassania</h3>
                    <p class="card-text">📍 Stade Père Jégo, Casablanca</p>
                    <p class="card-text">📅 20 Janvier 2026 - 19:30</p>
                    <div class="card-footer">
                        <span class="badge badge-success">Disponible</span>
                        <span style="font-weight: bold; color: var(--primary-color);">À partir de 80 MAD</span>
                    </div>
                    <a href="pages/match_details.php?id=3" class="btn btn-primary w-100 mt-2">Voir détails</a>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2026 BuyMatch. Tous droits réservés.</p>
    </footer>

    <script src="assets/js/main.js"></script>
</body>
</html>
