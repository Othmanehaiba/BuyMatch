<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../classes/MatchRepository.php";
// Ensure only admin can access

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin'){
    header("Location: ../../pages/login.php");
    exit();
}
$mantchRepository = new MatchRepository();
$pendingMatches = $mantchRepository->getPendingMatches();

$users = $mantchRepository->getNbrUsers();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BuyMatch - Admin Dashboard</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <!-- Header -->
    <header>
        <nav class="navbar">
            <div class="logo">⚽ BuyMatch Admin</div>
            <ul class="nav-links">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="users.php">Utilisateurs</a></li>
                <li><a href="../../auth/logout.php" class="btn btn-danger">Déconnexion</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="container">
        <h2>Dashboard Administrateur</h2>

        <!-- Global Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value"><?php echo $users ?></div>
                <div class="stat-label">Utilisateurs totaux</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-value"><?php echo $mantchRepository->getNbrMatches(); ?></div>
                <div class="stat-label">Matchs publiés</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-value"><?php echo $mantchRepository->getNbrPendingMatches(); ?></div>
                <div class="stat-label">En attente validation</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-value">TA7TA SIYANA</div>
                <div class="stat-label">Billets vendus</div>
            </div>
        </div>

        <!-- Pending Matches -->
        <div class="card mt-3">
            <div class="card-body">
                <h3 class="mb-2">Matchs en attente de validation</h3>
                
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Match</th>
                                <th>Organisateur</th>
                                <th>Date</th>
                                <th>Lieu</th>
                                <th>Places</th>
                                <th>Date création</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($pendingMatches as $match): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($match['team1_name'] . " vs " . $match['team2_name']); ?></td>
                                <td><?php echo htmlspecialchars($match['name_orga']); ?></td>
                                <td><?php echo htmlspecialchars(date("d M Y H:i", strtotime($match['date_heure']))); ?></td>
                                <td><?php echo htmlspecialchars($match['stade_name']); ?></td>
                                <td><?php echo htmlspecialchars($match['capacite_total']); ?></td>
                                <td><?php echo htmlspecialchars(date("d M Y", strtotime($match['created_at']))); ?></td>
                                <td>
                                    <button class="btn btn-success"><a href="validate_match.php?approve=<?php echo $match['id']; ?>">Approuver</a></button>
                                    <button class="btn btn-danger"><a href="reject_match.php?reject=<?php echo $match['id']; ?>">Refuser</a></button>
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
        function toggleUserStatus(userId) {
            if (BuyMatch.confirmAction('Changer le statut de cet utilisateur ?')) {
                BuyMatch.showLoading();
                // Submit form or AJAX request
                setTimeout(function() {
                    BuyMatch.hideLoading();
                    BuyMatch.showAlert('Statut mis à jour', 'success');
                    // Reload or update UI
                }, 1000);
            }
        }

        function deleteComment(commentId) {
            if (BuyMatch.confirmAction('Supprimer ce commentaire ?')) {
                BuyMatch.showLoading();
                // Submit form or AJAX request
                setTimeout(function() {
                    BuyMatch.hideLoading();
                    BuyMatch.showAlert('Commentaire supprimé', 'success');
                    // Reload or update UI
                }, 1000);
            }
        }
    </script>
</body>
</html>
