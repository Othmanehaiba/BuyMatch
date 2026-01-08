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
                        <input type="text" id="nom" name="nom" class="form-control" value="<?= htmlspecialchars($userInfos[0]['nom']) ?>" disabled>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($userInfos[0]['email']) ?>" disabled>
                    </div>
                    
                </form>
            </div>
        </div>

        <!-- Tickets History -->
        <div class="card mt-3">
            <div class="card-body">
                <h3 class="mb-2">Historique de mes billets</h3>
                
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Match</th>
                                <th>Date</th>
                                <th>Places</th>
                                <th>Catégorie</th>
                                <th>Prix</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Raja vs Wydad</td>
                                <td>15 Jan 2026</td>
                                <td>A1, A2</td>
                                <td>VIP</td>
                                <td>700 MAD</td>
                                <td><span class="badge badge-success">Confirmé</span></td>
                                <td>
                                    <button class="btn btn-primary" onclick="downloadTicket(1)">📥 PDF</button>
                                </td>
                            </tr>
                            <tr>
                                <td>AS FAR vs Renaissance</td>
                                <td>10 Jan 2026</td>
                                <td>B5</td>
                                <td>Standard</td>
                                <td>100 MAD</td>
                                <td><span class="badge badge-info">Utilisé</span></td>
                                <td>
                                    <button class="btn btn-outline" onclick="downloadTicket(2)">📥 PDF</button>
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

    <script src="../assets/js/main.js"></script>
    <script>
        function downloadTicket(ticketId) {
            BuyMatch.showLoading();
            // Simulate PDF download
            setTimeout(function() {
                BuyMatch.hideLoading();
                BuyMatch.showAlert('Téléchargement du billet en cours...', 'success');
                // window.location.href = 'download_ticket.php?id=' + ticketId;
            }, 1000);
        }
    </script>
</body>
</html>
