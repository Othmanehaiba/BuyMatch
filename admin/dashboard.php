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
                <li><a href="validate_match.php">Valider matchs</a></li>
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
                <div class="stat-value">245</div>
                <div class="stat-label">Utilisateurs totaux</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-value">48</div>
                <div class="stat-label">Matchs publiés</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-value">5</div>
                <div class="stat-label">En attente validation</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-value">8,456</div>
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
                            <tr>
                                <td>Kawkab vs Hassania</td>
                                <td>Ahmed Bennani</td>
                                <td>20 Jan 2026</td>
                                <td>Casablanca</td>
                                <td>1200</td>
                                <td>02 Jan 2026</td>
                                <td>
                                    <button class="btn btn-secondary" onclick="approveMatch(1)">✓ Approuver</button>
                                    <button class="btn btn-danger" onclick="rejectMatch(1)">✗ Refuser</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Olympique vs Union</td>
                                <td>Sara Idrissi</td>
                                <td>22 Jan 2026</td>
                                <td>Agadir</td>
                                <td>800</td>
                                <td>01 Jan 2026</td>
                                <td>
                                    <button class="btn btn-secondary" onclick="approveMatch(2)">✓ Approuver</button>
                                    <button class="btn btn-danger" onclick="rejectMatch(2)">✗ Refuser</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Users Management -->
        <div class="card mt-3">
            <div class="card-body">
                <h3 class="mb-2">Gestion des utilisateurs</h3>
                
                <div class="filter-bar mb-2">
                    <input type="text" class="form-control" placeholder="Rechercher un utilisateur...">
                    <select class="form-control">
                        <option value="">Tous les rôles</option>
                        <option value="acheteur">Acheteur</option>
                        <option value="organisateur">Organisateur</option>
                        <option value="admin">Admin</option>
                    </select>
                    <select class="form-control">
                        <option value="">Tous les statuts</option>
                        <option value="active">Actif</option>
                        <option value="inactive">Inactif</option>
                    </select>
                </div>
                
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Rôle</th>
                                <th>Date inscription</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Mohamed Alami</td>
                                <td>mohamed.alami@email.com</td>
                                <td><span class="badge badge-info">Acheteur</span></td>
                                <td>15 Déc 2025</td>
                                <td><span class="badge badge-success">Actif</span></td>
                                <td>
                                    <button class="btn btn-danger" onclick="toggleUserStatus(1)">Désactiver</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Ahmed Bennani</td>
                                <td>ahmed.bennani@email.com</td>
                                <td><span class="badge badge-warning">Organisateur</span></td>
                                <td>10 Déc 2025</td>
                                <td><span class="badge badge-success">Actif</span></td>
                                <td>
                                    <button class="btn btn-danger" onclick="toggleUserStatus(2)">Désactiver</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Fatima Zahra</td>
                                <td>fatima.z@email.com</td>
                                <td><span class="badge badge-info">Acheteur</span></td>
                                <td>05 Déc 2025</td>
                                <td><span class="badge badge-danger">Inactif</span></td>
                                <td>
                                    <button class="btn btn-secondary" onclick="toggleUserStatus(3)">Activer</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- All Comments -->
        <div class="card mt-3">
            <div class="card-body">
                <h3 class="mb-2">Tous les commentaires</h3>
                
                <div style="border-bottom: 1px solid var(--light-gray); padding: 1rem 0;">
                    <div class="d-flex justify-between align-center mb-1">
                        <strong>Mohamed A. - Raja vs Wydad</strong>
                        <span style="color: var(--gray-color); font-size: 0.875rem;">Il y a 2 jours</span>
                    </div>
                    <p>Excellent match ! Ambiance incroyable au stade.</p>
                    <div>⭐⭐⭐⭐⭐ 5/5</div>
                    <button class="btn btn-danger mt-1" onclick="deleteComment(1)">Supprimer</button>
                </div>
                
                <div style="border-bottom: 1px solid var(--light-gray); padding: 1rem 0;">
                    <div class="d-flex justify-between align-center mb-1">
                        <strong>Fatima Z. - AS FAR vs Renaissance</strong>
                        <span style="color: var(--gray-color); font-size: 0.875rem;">Il y a 5 jours</span>
                    </div>
                    <p>Organisation parfaite, places confortables.</p>
                    <div>⭐⭐⭐⭐ 4/5</div>
                    <button class="btn btn-danger mt-1" onclick="deleteComment(2)">Supprimer</button>
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
        function approveMatch(matchId) {
            if (BuyMatch.confirmAction('Approuver ce match ?')) {
                BuyMatch.showLoading();
                // Submit form or AJAX request
                setTimeout(function() {
                    BuyMatch.hideLoading();
                    BuyMatch.showAlert('Match approuvé avec succès', 'success');
                    // Reload or update UI
                }, 1000);
            }
        }

        function rejectMatch(matchId) {
            if (BuyMatch.confirmAction('Refuser ce match ?')) {
                BuyMatch.showLoading();
                // Submit form or AJAX request
                setTimeout(function() {
                    BuyMatch.hideLoading();
                    BuyMatch.showAlert('Match refusé', 'info');
                    // Reload or update UI
                }, 1000);
            }
        }

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
