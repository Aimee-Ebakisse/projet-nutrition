<?php
header('Content-Type: application/json');

// Connexion à la base de données
$servername = "localhost";
$username = "root"; // Change selon ta configuration
$password = ""; // Change selon ta configuration
$dbname = "nutrition"; // Change selon ta configuration

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifie la connexion
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Erreur de connexion à la base de données']));
}

// Récupère les repas
$result = $conn->query("SELECT nom, description, calories, type FROM repas");
$meals = [];

while ($row = $result->fetch_assoc()) {
    $meals[] = $row;
}

echo json_encode($meals);

$conn->close();
?>
