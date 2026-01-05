<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BuyMatch - Détails du Match</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <!-- Header -->
    <header>
        <nav class="navbar">
            <div class="logo">⚽ BuyMatch</div>
            <ul class="nav-links">
                <li><a href="../index.php">Accueil</a></li>
                <li><a href="matches.php">Matchs</a></li>
                <li><a href="profile.php">Mon Profil</a></li>
                <li><a href="../auth/logout.php" class="btn btn-danger">Déconnexion</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="container">
        <!-- Match Header -->
        <div class="match-header">
            <div class="teams-container">
                <div class="team">
                    <div class="team-logo" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem;">
                        R
                    </div>
                    <h3>Raja Casablanca</h3>
                </div>
                
                <div class="vs-text">VS</div>
                
                <div class="team">
                    <div class="team-logo" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem;">
                        W
                    </div>
                    <h3>Wydad Casablanca</h3>
                </div>
            </div>
            
            <div class="text-center mt-3">
                <p>📍 <strong>Stade Mohammed V, Casablanca</strong></p>
                <p>📅 <strong>15 Janvier 2026 - 20:00</strong></p>
                <p>⏱️ <strong>Durée: 90 minutes</strong></p>
            </div>
        </div>

        <!-- Categories and Prices -->
        <div class="card">
            <div class="card-body">
                <h3 class="mb-2">Choisissez votre catégorie</h3>
                
                <div class="stats-grid">
                    <div class="stat-card" style="cursor: pointer; border: 2px solid transparent;" onclick="selectCategory('vip')">
                        <h4>VIP</h4>
                        <div class="stat-value">350 MAD</div>
                        <p class="stat-label">120 places disponibles</p>
                    </div>
                    
                    <div class="stat-card" style="cursor: pointer; border: 2px solid transparent;" onclick="selectCategory('premium')">
                        <h4>Premium</h4>
                        <div class="stat-value">200 MAD</div>
                        <p class="stat-label">350 places disponibles</p>
                    </div>
                    
                    <div class="stat-card" style="cursor: pointer; border: 2px solid transparent;" onclick="selectCategory('standard')">
                        <h4>Standard</h4>
                        <div class="stat-value">150 MAD</div>
                        <p class="stat-label">800 places disponibles</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Seat Selection -->
        <div class="card mt-3" id="seat-section" style="display: none;">
            <div class="card-body">
                <h3 class="mb-2">Sélectionnez vos places (Max 4)</h3>
                <p class="text-center mb-2">
                    <span class="badge badge-info">Places sélectionnées: <span id="selected-seats-count">0</span>/4</span>
                </p>
                
                <!-- Seat Grid Example -->
                <div class="seat-grid">
                    <!-- Row 1 -->
                    <div class="seat" data-seat-id="A1">A1</div>
                    <div class="seat" data-seat-id="A2">A2</div>
                    <div class="seat occupied" data-seat-id="A3">A3</div>
                    <div class="seat" data-seat-id="A4">A4</div>
                    <div class="seat" data-seat-id="A5">A5</div>
                    <div class="seat" data-seat-id="A6">A6</div>
                    <div class="seat occupied" data-seat-id="A7">A7</div>
                    <div class="seat" data-seat-id="A8">A8</div>
                    <div class="seat" data-seat-id="A9">A9</div>
                    <div class="seat" data-seat-id="A10">A10</div>
                    
                    <!-- Row 2 -->
                    <div class="seat" data-seat-id="B1">B1</div>
                    <div class="seat" data-seat-id="B2">B2</div>
                    <div class="seat" data-seat-id="B3">B3</div>
                    <div class="seat occupied" data-seat-id="B4">B4</div>
                    <div class="seat" data-seat-id="B5">B5</div>
                    <div class="seat" data-seat-id="B6">B6</div>
                    <div class="seat" data-seat-id="B7">B7</div>
                    <div class="seat" data-seat-id="B8">B8</div>
                    <div class="seat occupied" data-seat-id="B9">B9</div>
                    <div class="seat" data-seat-id="B10">B10</div>
                </div>
                
                <div class="text-center mt-3">
                    <div class="d-flex justify-between align-center" style="max-width: 400px; margin: 0 auto;">
                        <span>🟦 Disponible</span>
                        <span>🟥 Occupée</span>
                        <span style="color: var(--primary-color);">■ Sélectionnée</span>
                    </div>
                </div>
                
                <button class="btn btn-primary w-100 mt-3" data-modal-target="confirm-modal">Confirmer l'achat</button>
            </div>
        </div>

        <!-- Match Info -->
        <div class="card mt-3">
            <div class="card-body">
                <h3 class="mb-2">À propos du match</h3>
                <p>Le derby de Casablanca entre le Raja et le Wydad est l'un des matchs les plus attendus de la saison. Une atmosphère exceptionnelle garantie !</p>
                
                <h4 class="mt-3">Informations pratiques</h4>
                <ul>
                    <li>Ouverture des portes: 18:00</li>
                    <li>Coup d'envoi: 20:00</li>
                    <li>Places numérotées</li>
                    <li>Parking disponible</li>
                </ul>
            </div>
        </div>

        <!-- Comments Section -->
        <div class="card mt-3">
            <div class="card-body">
                <h3 class="mb-2">Commentaires et Avis</h3>
                
                <!-- Comment Form -->
                <form action="match_details.php" method="POST" class="mb-3">
                    <div class="form-group">
                        <label for="comment">Laisser un commentaire</label>
                        <textarea id="comment" name="comment" class="form-control" rows="3" placeholder="Partagez votre expérience..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Publier</button>
                </form>
                
                <!-- Comments List -->
                <div class="mt-3">
                    <div style="border-bottom: 1px solid var(--light-gray); padding: 1rem 0;">
                        <div class="d-flex justify-between align-center mb-1">
                            <strong>Mohamed A.</strong>
                            <span style="color: var(--gray-color); font-size: 0.875rem;">Il y a 2 jours</span>
                        </div>
                        <p>Excellent match ! Ambiance incroyable au stade.</p>
                        <div>⭐⭐⭐⭐⭐ 5/5</div>
                    </div>
                    
                    <div style="border-bottom: 1px solid var(--light-gray); padding: 1rem 0;">
                        <div class="d-flex justify-between align-center mb-1">
                            <strong>Fatima Z.</strong>
                            <span style="color: var(--gray-color); font-size: 0.875rem;">Il y a 5 jours</span>
                        </div>
                        <p>Organisation parfaite, places confortables.</p>
                        <div>⭐⭐⭐⭐ 4/5</div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Confirmation Modal -->
    <div id="confirm-modal" class="modal-overlay">
        <div class="modal">
            <div class="modal-header">
                <h3>Confirmer votre achat</h3>
                <button class="modal-close" data-modal-close>&times;</button>
            </div>
            <div class="modal-body">
                <h4>Récapitulatif de la commande</h4>
                <table style="width: 100%; margin-top: 1rem;">
                    <tr>
                        <td>Match:</td>
                        <td><strong>Raja vs Wydad</strong></td>
                    </tr>
                    <tr>
                        <td>Date:</td>
                        <td><strong>15 Janvier 2026 - 20:00</strong></td>
                    </tr>
                    <tr>
                        <td>Catégorie:</td>
                        <td><strong id="modal-category">VIP</strong></td>
                    </tr>
                    <tr>
                        <td>Places:</td>
                        <td><strong id="modal-seats">A1, A2</strong></td>
                    </tr>
                    <tr>
                        <td>Nombre:</td>
                        <td><strong id="modal-count">2 places</strong></td>
                    </tr>
                    <tr style="border-top: 2px solid var(--dark-color);">
                        <td><strong>Total:</strong></td>
                        <td><strong id="modal-total" style="color: var(--primary-color); font-size: 1.25rem;">700 MAD</strong></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" data-modal-close>Annuler</button>
                <button class="btn btn-primary" onclick="completePurchase()">Confirmer et payer</button>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2026 BuyMatch. Tous droits réservés.</p>
    </footer>

    <script src="../assets/js/main.js"></script>
    <script>
        // Initialize seat selection
        document.addEventListener('DOMContentLoaded', function() {
            BuyMatch.initSeatSelection();
        });

        // Select category
        function selectCategory(category) {
            document.getElementById('seat-section').style.display = 'block';
            document.getElementById('seat-section').scrollIntoView({ behavior: 'smooth' });
        }

        // Complete purchase
        function completePurchase() {
            BuyMatch.showLoading();
            // Simulate purchase process
            setTimeout(function() {
                BuyMatch.hideLoading();
                BuyMatch.closeModal(document.getElementById('confirm-modal'));
                BuyMatch.showAlert('Achat confirmé ! Vérifiez votre email pour le billet.', 'success');
                // Redirect to profile or tickets page
                // window.location.href = 'profile.php';
            }, 2000);
        }
    </script>
</body>
</html>
