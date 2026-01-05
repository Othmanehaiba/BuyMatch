<?php
session_start();
require_once __DIR__ . "/../config/Database.php";

class MatchRepository{
    private PDO $pdo;
    private $team1_name;
    private $team1_logo_url;
    private $team2_name;
    private $team2_logo_url;
    private $date_match;
    private $time_match;
    private $location;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }
    
    public function all(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM matches WHERE organisateur_id = " . $_SESSION['user_id']);
        return $stmt->fetchAll();
    }

    public function create_stade($stade_name, $stade_ville): bool {
        $stmt = $this->pdo->prepare("INSERT INTO stades (nom, ville) VALUES (?, ?)");
        $stmt->bindParam(1, $stade_name);
        $stmt->bindParam(2, $stade_ville); 
        return $stmt->execute();
    }

    public function create_match($team1_name, $team1_logo_url, $team2_name, $team2_logo_url, $date_match, $time_match, $stade_name, $stade_ville, $total_seats): bool{
        $team_stmt = $this->pdo->prepare("INSERT INTO equipes (nom, logo) VALUES (?, ?), (?, ?)");
        $team_stmt->execute([$team1_name, $team1_logo_url, $team2_name, $team2_logo_url]);
        $this->create_stade($stade_name, $stade_ville);
        $stmt = $this->pdo->prepare("INSERT INTO matches (organisateur_id, stade_id, equipe_a_id, equipe_b_id, date_heure, duree_min, capacite_total, statut) VALUES (?, ?, ?, ?, ?, 90, ?, 'en_attente')");
        return $stmt->execute([$_SESSION['user_id'], 1, $this->pdo->lastInsertId() - 1, $this->pdo->lastInsertId(), "$date_match $time_match", $total_seats]);
    }

    public function create_category($match_id, $category_name, $price, $seats): bool {
        $stmt = $this->pdo->prepare("INSERT INTO categories_match (match_id, nom, prix, capacite) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$match_id, $category_name, $price, $seats]);
    }

    public function getIdMatch(): int {
        return (int)$this->pdo->lastInsertId();
    }
}
