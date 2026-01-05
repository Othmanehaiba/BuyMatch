<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/../classes/MatchRepository.php";

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])){
    if($_POST['team1_name'] === $_POST['team2_name']){
        die("Les noms des équipes doivent être différents.");
    }
    $team1_name = trim($_POST['team1_name']);
    $team1_logo_url = $_POST['team1_logo_url'];
    $team2_name = trim($_POST['team2_name']);
    $team2_logo_url = $_POST['team2_logo_url'];
    $date_match = $_POST['date'];
    $time_match = $_POST['time'];
    $location = trim($_POST['location'] ?? '');

    if(!str_contains($location, ',')){
        die("Le lieu doit inclure le nom du stade et la ville, séparés par une virgule.");
    }
    
    $parts = array_map('trim', explode(',', $location, 2));

    $stade_nom  = $parts[0]?? '';
    $stade_ville = $parts[1]?? '';

    $duration = $_POST['duration'];
    $total_seats = $_POST['total_seats'];
    $category1_name = $_POST['category1_name']?? '';
    $category1_price = $_POST['category1_price'];
    $category1_seats = $_POST['category1_seats'];
    $category2_name = $_POST['category2_name']?? '';
    $category2_price = $_POST['category2_price'];
    $category2_seats = $_POST['category2_seats'];
    $category3_name = $_POST['category3_name']?? '';
    $category3_price = $_POST['category3_price'];
    $category3_seats = $_POST['category3_seats'];

    if($total_seats > 2000){
        die("Le nombre total de places ne peut pas dépasser 2000.");
    }
    if($category1_seats + $category2_seats + $category3_seats > $total_seats){
        die("Le total des places par catégorie dépasse le nombre total de places.");
    }
    

    
    $matchRepo = new MatchRepository();

    $matchId = $matchRepo->create_match(
        $team1_name,
        $team1_logo_url,
        $team2_name,
        $team2_logo_url,
        $date_match,
        $time_match,
        $stade_nom,
        $stade_ville,
        (int)$total_seats
    );

    if ($matchId <= 0) {
        die("Erreur lors de la création du match.");
    }

    $createdCat1 = $matchRepo->create_category(
        (int)$matchId,
        $category1_name,
        (float)$category1_price,
        (int)$category1_seats
    );

    if (!$createdCat1) {
        die("Erreur lors de la création de la catégorie 1.");
    }

    if (!empty($category2_name)) {
        if (empty($category2_price) || empty($category2_seats)) {
            die("Catégorie 2: prix et nombre de places sont obligatoires si tu choisis un nom.");
        }

        $createdCat2 = $matchRepo->create_category(
            (int)$matchId,
            $category2_name,
            (float)$category2_price,
            (int)$category2_seats
        );

        if (!$createdCat2) {
            die("Erreur lors de la création de la catégorie 2.");
        }
    }

    if (!empty($category3_name)) {
        if (empty($category3_price) || empty($category3_seats)) {
            die("Catégorie 3: prix et nombre de places sont obligatoires si tu choisis un nom.");
        }

        $createdCat3 = $matchRepo->create_category(
            (int)$matchId,
            $category3_name,
            (float)$category3_price,
            (int)$category3_seats
        );

        if (!$createdCat3) {
            die("Erreur lors de la création de la catégorie 3.");
        }
    }

    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BuyMatch - Créer un Match</title>
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
        <div class="form-container" style="max-width: 800px;">
            <h2 class="text-center mb-3">Créer un événement sportif</h2>
            
            <form action="create_match.php" method="POST" data-validate>
                <!-- Teams Information -->
                <h3 class="mb-2">Équipes</h3>

                <div class="form-group">
                    <label for="team1_name">Nom de l'équipe 1</label>
                    <input type="text" id="team1_name" name="team1_name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="team1_logo_url">Logo de l'équipe 1 (URL)</label>
                    <input
                        type="url"
                        id="team1_logo_url"
                        name="team1_logo_url"
                        class="form-control"
                        placeholder="https://example.com/logo1.png"
                        pattern="https?://.+"
                        required
                    >
                    <div class="mt-2">
                        <img id="team1_logo_preview"
                             alt="Aperçu logo équipe 1"
                             style="display:none; max-height:80px; border-radius:10px;">
                        <div id="team1_logo_error" class="text-danger mt-1" style="display:none;">
                          URL invalide ou image introuvable.
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="team2_name">Nom de l'équipe 2</label>
                    <input type="text" id="team2_name" name="team2_name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="team2_logo_url">Logo de l'équipe 2 (URL)</label>
                    <input
                        type="url"
                        id="team2_logo_url"
                        name="team2_logo_url"
                        class="form-control"
                        placeholder="https://example.com/logo2.png"
                        pattern="https?://.+"
                        required
                    >
                    <div class="mt-2">
                        <img id="team2_logo_preview"
                             alt="Aperçu logo équipe 2"
                             style="display:none; max-height:80px; border-radius:10px;">
                        <div id="team2_logo_error" class="text-danger mt-1" style="display:none;">
                          URL invalide ou image introuvable.
                        </div>
                    </div>
                </div>

                <!-- Match Information -->
                <h3 class="mt-3 mb-2">Informations du match</h3>

                <div class="form-group">
                    <label for="date">Date du match</label>
                    <input type="date" id="date" name="date" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="time">Heure du match</label>
                    <input type="time" id="time" name="time" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="location">Lieu (Stade)</label>
                    <input type="text" id="location" name="location" class="form-control"
                           placeholder="Ex: Stade Mohammed V, Casablanca" required>
                </div>

                <div class="form-group">
                    <label for="duration">Durée (minutes)</label>
                    <input type="number" id="duration" name="duration" class="form-control" value="90" readonly>
                </div>

                <div class="form-group">
                    <label for="total_seats">Nombre total de places (max 2000)</label>
                    <input type="number" id="total_seats" name="total_seats" class="form-control" max="2000" required>
                </div>

                <!-- Categories and Prices -->
                <h3 class="mt-3 mb-2">Catégories et Prix (max 3)</h3>

                <div class="form-group">
                    <label for="category1_name">Catégorie 1 - Nom</label>
                    <select id="category1_name" name="category1_name" class="form-control">
                        <option value="" selected>Choisir une catégorie</option>
                        <option value="VIP">VIP</option>
                        <option value="Premium">Premium</option>
                        <option value="Standard">Standard</option>
                    </select>                
                </div>

                <div class="form-group">
                    <label for="category1_price">Catégorie 1 - Prix (MAD)</label>
                    <input type="number" id="category1_price" name="category1_price" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="category1_seats">Catégorie 1 - Nombre de places</label>
                    <input type="number" id="category1_seats" name="category1_seats" class="form-control" required>
                </div>

                <hr>

                <div class="form-group">
                    <label for="category2_name">Catégorie 2 - Nom</label>
                    <select id="category2_name" name="category2_name" class="form-control">
                        <option value="" selected>Choisir une catégorie</option>
                        <option value="VIP">VIP</option>
                        <option value="Premium">Premium</option>
                        <option value="Standard">Standard</option>
                    </select>                
                </div>

                <div class="form-group">
                    <label for="category2_price">Catégorie 2 - Prix (MAD)</label>
                    <input type="number" id="category2_price" name="category2_price" class="form-control">
                </div>

                <div class="form-group">
                    <label for="category2_seats">Catégorie 2 - Nombre de places</label>
                    <input type="number" id="category2_seats" name="category2_seats" class="form-control">
                </div>

                <hr>

                <div class="form-group">
                    <label for="category3_name">Catégorie 3 - Nom</label>
                    <select id="category3_name" name="category3_name" class="form-control">
                        <option value="" selected>Choisir une catégorie</option>
                        <option value="VIP">VIP</option>
                        <option value="Premium">Premium</option>
                        <option value="Standard">Standard</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="category3_price">Catégorie 3 - Prix (MAD)</label>
                    <input type="number" id="category3_price" name="category3_price" class="form-control">
                </div>

                <div class="form-group">
                    <label for="category3_seats">Catégorie 3 - Nombre de places</label>
                    <input type="number" id="category3_seats" name="category3_seats" class="form-control">
                </div>

                <!-- Additional Information -->
                <h3 class="mt-3 mb-2">Informations supplémentaires</h3>

                <div class="alert alert-info">
                    ⚠️ Votre événement sera soumis à l'approbation de l'administrateur avant d'être publié.
                </div>

                <button type="submit" name="submit" class="btn btn-primary w-100">Créer l'événement</button>
            </form>

        </div>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2026 BuyMatch. Tous droits réservés.</p>
    </footer>

    <script src="../../assets/js/main.js"></script>
</body>
</html>
