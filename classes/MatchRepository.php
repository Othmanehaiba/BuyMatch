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
        $stmt = $this->pdo->prepare("SELECT m.id, e1.nom AS team1_name, e2.nom AS team2_name, s.nom AS stade_name, m.date_heure, m.duree_min, m.capacite_total, m.statut  
                                    FROM matches m 
                                    JOIN equipes e1 ON m.equipe_a_id = e1.id
                                    JOIN equipes e2 ON m.equipe_b_id = e2.id
                                    JOIN stades s ON m.stade_id = s.id
                                    WHERE m.organisateur_id = ?");
        $stmt->execute([$organisateur_id]);
        return $stmt->fetchAll();
    }

    public function getPendingMatches(): array {
        $stmt = $this->pdo->prepare("SELECT m.id, u.nom as name_orga, m.created_at, e1.nom AS team1_name, e2.nom AS team2_name, s.nom AS stade_name, m.date_heure, m.duree_min, m.capacite_total, m.statut  
                                    FROM matches m 
                                    RIGHT JOIN equipes e1 ON m.equipe_a_id = e1.id
                                    RIGHT JOIN equipes e2 ON m.equipe_b_id = e2.id
                                    RIGHT JOIN stades s ON m.stade_id = s.id
                                    RIGHT JOIN users u ON m.organisateur_id = u.id
                                    WHERE m.statut = 'en_attente'");
        $stmt->execute();
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

    public function getAllUsers():array{
        $stmt = $this->pdo->prepare("SELECT id, nom, email, role, statut FROM users");
        $stmt->execute();
        return $stmt->fetchAll();   
    }  

    public function getNbrUsers(): int {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users");
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function getNbrMatches(): int {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM matches WHERE statut = 'valide'");
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function getNbrPendingMatches(): int {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM matches WHERE statut = 'en_attente'");
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }
}