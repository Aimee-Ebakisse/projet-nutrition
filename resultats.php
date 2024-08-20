<?php
// Connexion à la base de données
$host = 'localhost'; // ou l'adresse de votre serveur
$dbname = 'projet conception';
$username = 'root';
$password = '';

try {
    $con = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer les repas depuis la base de données
    $stmt = $con->prepare("SELECT * FROM repas");
    $stmt->execute();
    $repas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultat</title>
    <link rel="stylesheet" href="ex.css">
</head>
<body>
    <div class="result">
        <div class="result-content">
            <a href="ex.php">Ajouter un repas</a>
            <h3>Liste des repas</h3>
            <div class="liste-repas">
                <?php if (!empty($repas)): ?>
                    <?php foreach ($repas as $repas_item): ?>
                        <div class="repas">
                            <div class="image-rep">
                                <img src="uploads/<?php echo htmlspecialchars($repas_item['image']); ?>" alt="<?php echo htmlspecialchars($repas_item['titre']); ?>" style="width: 100px;">
                            </div>
                            <div class="text">
                                <strong><p class="titre"><?php echo htmlspecialchars($repas_item['titre']); ?></p></strong>
                                <p class="description"><?php echo htmlspecialchars($repas_item['descrip']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Aucun repas trouvé.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
