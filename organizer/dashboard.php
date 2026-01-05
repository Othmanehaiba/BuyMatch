<?php
session_start();
require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../classes/MatchRepository.php";
$matchRepo = new MatchRepository();
$matches = $matchRepo->all();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BuyMatch - Dashboard Organisateur</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <!-- Header -->
    <header>
        <nav class="navbar">
            <div class="logo">⚽ BuyMatch</div>
            <ul class="nav-links">
                <li><a href="stats.php">Stats</a></li>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="create_match.php" class="btn btn-secondary">Créer un match</a></li>
                <li><a href="../../auth/logout.php" class="btn btn-danger">Déconnexion</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="container">
        <h2>Dashboard Organisateur</h2>

        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value">12</div>
                <div class="stat-label">Matchs créés</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-value">3</div>
                <div class="stat-label">En attente</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-value">1,245</div>
                <div class="stat-label">Billets vendus</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-value">186,750 MAD</div>
                <div class="stat-label">Chiffre d'affaires</div>
            </div>
        </div>

        <!-- My Matches -->
        <div class="card mt-3">
            <div class="card-body">
                <h3 class="mb-2">Mes matchs</h3>
                
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Match</th>
                                <th>Date</th>
                                <th>Lieu</th>
                                <th>Places</th>
                                <th>Vendus</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Raja vs Wydad</td>
                                <td>15 Jan 2026</td>
                                <td>Casablanca</td>
                                <td>2000</td>
                                <td>1456</td>
                                <td><span class="badge badge-success">Validé</span></td>
                                <td>
                                    <button class="btn btn-primary" onclick="viewStats(1)">📊 Stats</button>
                                </td>
                            </tr>
                            <tr>
                                <td>AS FAR vs Renaissance</td>
                                <td>18 Jan 2026</td>
                                <td>Rabat</td>
                                <td>1500</td>
                                <td>890</td>
                                <td><span class="badge badge-success">Validé</span></td>
                                <td>
                                    <button class="btn btn-primary" onclick="viewStats(2)">📊 Stats</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Kawkab vs Hassania</td>
                                <td>20 Jan 2026</td>
                                <td>Casablanca</td>
                                <td>1200</td>
                                <td>0</td>
                                <td><span class="badge badge-warning">En attente</span></td>
                                <td>
                                    <button class="btn btn-outline" disabled>En attente</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2026 BuyMatch. Tous droits réservés.</p>
    </footer>

    <script src="../../assets/js/main.js"></script>
    <script>
        function viewStats(matchId) {
            window.location.href = 'stats.php?match_id=' + matchId;
        }
    </script>
</body>
</html>
