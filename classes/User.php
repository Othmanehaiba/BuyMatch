<?php
require_once __DIR__ . "/../config/Database.php";   

class User{
    private $name;
    private $email;
    private $password_hash;
    private $role;

    public function __construct($name, $email, $password_hash, $role){
        $this->name = $name;
        $this->email = $email;
        $this->password_hash = $password_hash;
        $this->role = $role;
    }
    public function create_user($role): bool {
        require_once __DIR__ . "/../config/Database.php";
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO users (nom, email, password_hash, role) VALUES (?, ?, ?, ?)");
        $stmt->execute([$this->name, $this->email, $this->password_hash, $this->role]);
        if($role === 'organisateur'){
            $stmt = $pdo->prepare("INSERT INTO organisateurs (user_id) VALUES (?)");
        } else {
            $stmt = $pdo->prepare("INSERT INTO acheteurs (user_id) VALUES (?)");
        }
        return $stmt->execute([$pdo->lastInsertId()]);
    }
     public static function getUserInfos($user_id): array {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT id, nom, email, role FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}