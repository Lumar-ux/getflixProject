<?php
// Configuration de la base de données
include_once "dbh.inc.php";

// Requête SQL pour récupérer les données d'évolution des utilisateurs
$sql = "SELECT DATE(created_at) as date, COUNT(*) as user_count
        FROM users
        GROUP BY DATE(created_at)
        ORDER BY DATE(created_at) ASC";

$result = $pdo->query($sql);

if (!$result) {
    die("Requête invalide : " . $pdo->errorInfo()[2]);
}

$dates = [];
$userCounts = [];

// Récupérer et préparer les données pour le graphique
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $dates[] = $row['date'];
    $userCounts[] = $row['user_count'];
}

// Convertir les données en JSON pour les utiliser dans le graphique
$datesJson = json_encode($dates);
$userCountsJson = json_encode($userCounts);
?>