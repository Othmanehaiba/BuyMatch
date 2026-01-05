<?php
session_start();
require_once __DIR__ . "/../config/Database.php";

class MatchRepository{
    public PDO $pdo;
    // private $team1_name;
    // private $team1_logo_url;
    // private $team2_name;
    // private $team2_logo_url;
    // private $date_match;
    // private $time_match;
    // private $location;

    public function __construct(){
        $this->pdo = Database::getConnection();
    }
    
    public function getMatchesByOrganisateur(int $organisateur_id): array {
        $stmt = $this->pdo->prepare("SELECT * FROM matches WHERE organisateur_id = ?");
        $stmt->execute([$organisateur_id]);
        return $stmt->fetchAll();
    }

     private function createEquipe(string $nom, string $logo): int{
        $stmt = $this->pdo->prepare("SELECT id FROM equipes WHERE nom = ? LIMIT 1");
        $stmt->execute([$nom]);
        $id = $stmt->fetchColumn();

        if ($id) {
            $update = $this->pdo->prepare("UPDATE equipes SET logo = ? WHERE id = ?");
            $update->execute([$logo, $id]);
            return (int)$id;
        }

        $stmt = $this->pdo->prepare("INSERT INTO equipes (nom, logo) VALUES (?, ?)");
        $stmt->execute([$nom, $logo]);
        return (int)$this->pdo->lastInsertId();
    }

    private function createStade(string $nom, string $ville): int
    {
        $stmt = $this->pdo->prepare("SELECT id FROM stades WHERE nom = ? AND ville = ? LIMIT 1");
        $stmt->execute([$nom, $ville]);
        $id = $stmt->fetchColumn();

        if ($id) return (int)$id;

        $stmt = $this->pdo->prepare("INSERT INTO stades (nom, ville) VALUES (?, ?)");
        $stmt->execute([$nom, $ville]);
        return (int)$this->pdo->lastInsertId();
    }

    public function create_match( string $team1_name, string $team1_logo_url, string $team2_name, string $team2_logo_url, string $date_match, string $time_match, string $stade_name, string $stade_ville, int $total_seats): int {
        $this->pdo->beginTransaction();
        try {
            $teamAId = $this->createEquipe($team1_name, $team1_logo_url);
            $teamBId = $this->createEquipe($team2_name, $team2_logo_url);
            $stadeId = $this->createStade($stade_name, $stade_ville);

            $dateHeure = $date_match . " " . $time_match; 

            $stmt = $this->pdo->prepare("
                INSERT INTO matches (organisateur_id, stade_id, equipe_a_id, equipe_b_id, date_heure, duree_min, capacite_total, statut)
                VALUES (?, ?, ?, ?, ?, 90, ?, 'en_attente')
            ");

            $stmt->execute([
                (int)$_SESSION['user_id'],
                $stadeId,
                $teamAId,
                $teamBId,
                $dateHeure,
                $total_seats
            ]);

            $matchId = (int)$this->pdo->lastInsertId();

            $this->pdo->commit();
            return $matchId;

        } catch (Throwable $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function create_category(int $match_id, string $category_name, float $price, int $seats): bool{
        $stmt = $this->pdo->prepare("
            INSERT INTO categories_match (match_id, nom, prix, capacite)
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([$match_id, $category_name, $price, $seats]);
    }
}