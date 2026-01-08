<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../classes/MatchRepository.php";

$matchRepo = new MatchRepository();

// Accept match id from GET or POST so POSTs without query string still work
$match_id = $_GET['id'] ?? $_POST['match_id'] ?? null;

if ($match_id === null) {
    die("ID de match manquant.");
} 


$details = $matchRepo->getMatchById($match_id);

if(!$details){  
    die("Match introuvable.");
}

$match = null;
$categories = [];

foreach ($details as $row) {
    if ($match === null) {
        // Store match info once
        $match = [
            'id' => $row['id'],
            'team1_name' => $row['team1_name'],
            'team1_logo' => $row['team1_logo'],
            'team2_name' => $row['team2_name'],
            'team2_logo' => $row['team2_logo'],
            'stade_name' => $row['stade_name'],
            'stade_ville' => $row['stade_ville'],
            'date_heure' => $row['date_heure'],
            'duree_min' => $row['duree_min'],
            'capacite_total' => $row['capacite_total'],
            'statut' => $row['statut']
        ];
    }
    
    // Collect all categories
    $categories[] = [
        'nom' => $row['nom'],
        'prix' => $row['prix'],
        'capacite' => $row['capacite']
    ];
}
// die("Submitting comment");

// Always load comments (GET and POST)
$comments = $matchRepo->getCommentsByMatchId((int)$match_id);

if(isset($_POST['submit_comment'])){

    $user_id = $_SESSION['user_id'] ?? null;

    if(!$user_id){
        die("Vous devez être connecté pour commenter.");
    }

    $rating = (int)($_POST['rating'] ?? 0);
    $comment_text = trim($_POST['comment'] ?? '');
    $match_id_post = (int)($_POST['match_id'] ?? 0);

    if($match_id_post !== (int)$match_id){
        die("Match invalide.");
    }

    if($rating < 1 || $rating > 5){
        die("Note invalide.");
    }

    if($comment_text === ''){
        die("Commentaire vide.");
    }

    // Insert (sanitize when displaying, not when saving)
    $matchRepo->insertComment((int)$match_id_post, (int)$user_id, $rating, $comment_text);

    // Redirect to avoid resubmission on refresh and preserve the id in the URL
    header("Location: match_details.php?id=" . (int)$match_id_post);
    exit();
} 

?>

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
        <div class="match-header">
            <div class="teams-container">
                <div class="team">
                    <img src="<?= $match['team1_logo'] ?>" alt="<?= $match['team1_name'] ?>" class="team-logo" style="width: 100%; height: 100%; object-fit: cover;">
                    <h3><?= $match['team1_name'] ?></h3>
                </div>
                
                <div class="vs-text">VS</div>
                
                <div class="team">
                    <img src="<?= $match['team2_logo'] ?>" alt="<?= $match['team2_name'] ?>" class="team-logo" style="width: 100%; height: 100%; object-fit: cover;">

                    <h3><?= $match['team2_name'] ?></h3>
                </div>
            </div>
            
            <div class="text-center mt-3">
                <p>📍 <strong><?= $match['stade_name'] ?>, <?= $match['stade_ville'] ?></strong></p>
                <p>📅 <strong><?= $match['date_heure'] ?></strong></p>
                <p>⏱️ <strong>Durée: <?= $match['duree_min'] ?> minutes</strong></p>
            </div>
        </div>

        <!-- Categories and Prices -->
        <div class="card">
            <div class="card-body">
                <h3 class="mb-2">Choisissez votre catégorie</h3>
                
                <div class="stats-grid">
                    <div class="stat-card" style="cursor: pointer; border: 2px solid transparent;" onclick="selectCategory('vip')">
                        <h4>VIP</h4>
                        <div class="stat-value"><?= $categories[0]['prix'] ?></div>
                        <p class="stat-label"><?= $categories[0]['capacite'] ?> places disponibles</p>
                    </div>
                    
                    <div class="stat-card" style="cursor: pointer; border: 2px solid transparent;" onclick="selectCategory('premium')">
                        <h4>Premium</h4>
                        <div class="stat-value"><?= $categories[1]['prix'] ?></div>
                        <p class="stat-label"><?= $categories[1]['capacite'] ?> places disponibles</p>
                    </div>
                    
                    <div class="stat-card" style="cursor: pointer; border: 2px solid transparent;" onclick="selectCategory('standard')">
                        <h4>Standard</h4>
                        <div class="stat-value"><?= $categories[2]['prix'] ?></div>
                        <p class="stat-label"><?= $categories[2]['capacite'] ?> places disponibles</p>
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
                    <div class="seat" data-seat-id="A3">A3</div>
                    <div class="seat" data-seat-id="A4">A4</div>
                    <div class="seat" data-seat-id="A5">A5</div>
                    <div class="seat" data-seat-id="A6">A6</div>
                    <div class="seat" data-seat-id="A7">A7</div>
                    <div class="seat" data-seat-id="A8">A8</div>
                    <div class="seat" data-seat-id="A9">A9</div>
                    <div class="seat" data-seat-id="A10">A10</div>
                    
                    <!-- Row 2 -->
                    <div class="seat" data-seat-id="B1">B1</div>
                    <div class="seat" data-seat-id="B2">B2</div>
                    <div class="seat" data-seat-id="B3">B3</div>
                    <div class="seat" data-seat-id="B4">B4</div>
                    <div class="seat" data-seat-id="B5">B5</div>
                    <div class="seat" data-seat-id="B6">B6</div>
                    <div class="seat" data-seat-id="B7">B7</div>
                    <div class="seat" data-seat-id="B8">B8</div>
                    <div class="seat" data-seat-id="B9">B9</div>
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
                <form action="match_details.php?id=<?= (int)$match['id'] ?>" method="POST" class="mb-3">
                    <!-- Star Rating -->
                    <div class="form-group mb-3">
                        <label class="d-block mb-2">Votre évaluation</label>
                        <div class="star-rating">
                            <input type="radio" id="star5" name="rating" value="5" required>
                            <label for="star5" title="5 étoiles">★</label>

                            <input type="radio" id="star4" name="rating" value="4">
                            <label for="star4" title="4 étoiles">★</label>

                            <input type="radio" id="star3" name="rating" value="3">
                            <label for="star3" title="3 étoiles">★</label>

                            <input type="radio" id="star2" name="rating" value="2">
                            <label for="star2" title="2 étoiles">★</label>

                            <input type="radio" id="star1" name="rating" value="1">
                            <label for="star1" title="1 étoile">★</label>
                        </div>
                    </div>
                    <!-- Comment Input -->
                    <div class="form-group mb-3">
                        <label for="comment">Laisser un commentaire</label>
                        <textarea id="comment" name="comment" class="form-control" rows="3" placeholder="Partagez votre expérience..." required></textarea>
                    </div>

                    <input type="hidden" name="match_id" value="<?= $match['id'] ?>">
                    <button type="submit" name="submit_comment" class="btn btn-primary">Publier</button>
                </form>
                <!-- Comments List -->
                <div class="mt-3">
                    <?php if ($comments): ?>
                    <?php foreach ($comments as $comment): ?>
                    <div style="border-bottom: 1px solid var(--light-gray); padding: 1rem 0;">
                        <div class="d-flex justify-between align-center mb-1">
                            <strong><?= $comment['user_name'] ?></strong>
                            <span style="color: var(--gray-color); font-size: 0.875rem;">Il y a 2 jours</span>
                        </div>
                        <p><?= $comment['commentaire'] ?></p>
                        <div><?php echo str_repeat("⭐", (int)$comment['note']); ?><?php echo $comment['note']; ?> /5</div>
                    </div>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <p>Aucun commentaire pour le moment. Soyez le premier à en laisser un !</p>
                    <?php endif; ?>
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
    <script>
    let selectedSeats = [];
    const maxSeats = 4;

    // Initialize seat selection
    document.addEventListener('DOMContentLoaded', function() {
        // If you have BuyMatch.initSeatSelection, keep it
        if (typeof BuyMatch !== 'undefined' && BuyMatch.initSeatSelection) {
            BuyMatch.initSeatSelection();
        }
        
        // Initialize our seat selection
        initializeSeatSelection();
    });

    function initializeSeatSelection() {
        const seats = document.querySelectorAll('.seat:not(.occupied)');
        
        seats.forEach(seat => {
            seat.addEventListener('click', function() {
                const seatId = this.getAttribute('data-seat-id');
                
                // Check if seat is already selected
                if (this.classList.contains('selected')) {
                    // Deselect the seat
                    this.classList.remove('selected');
                    selectedSeats = selectedSeats.filter(id => id !== seatId);
                } else {
                    // Check if max seats reached
                    if (selectedSeats.length >= maxSeats) {
                        alert('Vous pouvez sélectionner maximum ' + maxSeats + ' places.');
                        return;
                    }
                    
                    // Select the seat
                    this.classList.add('selected');
                    selectedSeats.push(seatId);
                }
                
                // Update counter
                updateSelectedSeatsCount();
                
                // Update modal
                updateModalInfo();
            });
        });
    }

    function updateSelectedSeatsCount() {
        document.getElementById('selected-seats-count').textContent = selectedSeats.length;
    }

    function updateModalInfo() {
        if (selectedSeats.length > 0) {
            document.getElementById('modal-seats').textContent = selectedSeats.join(', ');
            document.getElementById('modal-count').textContent = selectedSeats.length + ' place(s)';
            
            // Calculate total (example with VIP price)
            const pricePerSeat = <?= $categories[0]['prix'] ?>; // Adjust based on selected category
            const total = selectedSeats.length * pricePerSeat;
            document.getElementById('modal-total').textContent = total + ' MAD';
        }
    }

    // Select category
    function selectCategory(category) {
        document.getElementById('seat-section').style.display = 'block';
        document.getElementById('seat-section').scrollIntoView({ behavior: 'smooth' });
    }

    // Complete purchase
    function completePurchase() {
        if (selectedSeats.length === 0) {
            alert('Veuillez sélectionner au moins une place.');
            return;
        }
        
        if (typeof BuyMatch !== 'undefined' && BuyMatch.showLoading) {
            BuyMatch.showLoading();
        }
        
        // Simulate purchase process
        setTimeout(function() {
            if (typeof BuyMatch !== 'undefined') {
                if (BuyMatch.hideLoading) BuyMatch.hideLoading();
                if (BuyMatch.closeModal) BuyMatch.closeModal(document.getElementById('confirm-modal'));
                if (BuyMatch.showAlert) BuyMatch.showAlert('Achat confirmé ! Vérifiez votre email pour le billet.', 'success');
            } else {
                alert('Achat confirmé ! Vérifiez votre email pour le billet.');
            }
            
            // Mark selected seats as occupied
            selectedSeats.forEach(seatId => {
                const seatElement = document.querySelector(`.seat[data-seat-id="${seatId}"]`);
                if (seatElement) {
                    seatElement.classList.remove('selected');
                    seatElement.classList.add('occupied');
                }
            });
            
            // Reset selection
            selectedSeats = [];
            updateSelectedSeatsCount();
            
            // Redirect to profile or tickets page
            // window.location.href = 'profile.php';
        }, 2000);
    }
</script>
</body>
</html>
