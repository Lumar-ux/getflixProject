<?php
require_once('dbh.inc.php');

$season_id = $_GET['season_id'];

// echo "from get_episode page: " . $series_id;

$query = "SELECT * FROM episodes WHERE season_id =:season_id";
$stmt = $pdo->prepare($query);
$stmt->execute([':season_id' => $season_id]);
$episodes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Convert the results into JSON format
$jsonResult = json_encode($episodes);

// Set the content type header to application/json
header('Content-Type: application/json');

// Output the JSON string
echo $jsonResult;
