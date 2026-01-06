<?php
$id = $_GET['id'] ?? null;
if($id){
    require_once __DIR__ . "/../config/Database.php";
    $pdo = Database::getConnection();
    $stmt = $pdo->prepare("UPDATE users SET statut = CASE WHEN statut = 'actif' THEN 'inactif' ELSE 'actif' END WHERE id = ?");
    $stmt->execute([(int)$id]);
    header("Location: users.php");
    exit();
} else {
    die("ID utilisateur manquant.");
}