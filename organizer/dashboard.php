<?php
session_start();
require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../classes/MatchRepository.php";
$matchRepo = new MatchRepository();
$stmt = $matchRepo->pdo->prepare("SELECT COUNT(*) FROM matches WHERE organisateur_id = ?");
$stmt->execute([(int)$_SESSION['user_id']]);
$total_matches = (int)$stmt->fetchColumn();

///match en attente ////
$stmt = $matchRepo->pdo->prepare("SELECT COUNT(*) FROM matches WHERE organisateur_id = ? AND statut = 'en_attente'");
$stmt->execute([(int)$_SESSION['user_id']]);
$matches_enAttente = (int)$stmt->fetchColumn();
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
                <div class="stat-value"><?php echo $total_matches; ?></div>
                <div class="stat-label">Matchs créés</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-value"><?php echo $matches_enAttente; ?></div>
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
                            <?php
                            $matches = $matchRepo->getMatchesByOrganisateur((int)$_SESSION['user_id']);
                            foreach ($matches as $m):
                                // $seats_sold = $matchRepo->get_sold_seats_count($m['id']);
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($m['team1_name'] . " vs " . $m['team2_name']); ?></td>
                                <td><?php echo htmlspecialchars($m['date_match'] . " " . $m['time_match']); ?></td>
                                <td><?php echo htmlspecialchars($m['stade_name'] . ", " . $m['stade_ville']); ?></td>
                                <td><?php echo htmlspecialchars($m['total_seats']); ?></td>
                                <!-- <td><?php echo htmlspecialchars($seats_sold); ?></td> -->
                                <td><?php echo htmlspecialchars(ucfirst(str_replace('_', ' ', $m['statut']))); ?></td>
                                <td>
                                    <button class="btn btn-primary" onclick="viewStats(<?php echo (int)$m['id']; ?>)">Voir stats</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
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
