<?php
require_once __DIR__ . "/../config/Database.php";
if(isset($_GET['reject'])){
    $match_id = (int)$_GET['reject'];

    $pdo = Database::getConnection();
    $stmt = $pdo->prepare("UPDATE matches SET statut = 'refuse' WHERE id = ?");
    $stmt->execute([$match_id]);

    header("Location: dashboard.php");
    exit();
} else {
    die("ID de match invalide.");
}