<?php
// Connexion à la base de données
try {
    $pdo = new PDO('mysql:host=localhost;dbname=projet conception', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hasher le mot de passe
    

    // Validation des données (à améliorer)
    if (empty($email) || empty($password) ) {
        die("Veuillez remplir tous les champs");
    }

    // Insertion dans la base de données
    $stmt = $pdo->prepare("INSERT INTO projet (email, password) VALUES (?, ?)");
    if ($stmt->execute([$email, $password])) {
        // Redirection vers la page dashboard
        header('Location: dashboard.php');
        exit();
    } else {
        echo "Erreur lors de la connexion.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Suivi Alimentaire</title>
    <link rel="stylesheet" href="connexion.css"> <!-- Lien vers le fichier CSS -->
</head>
<body>
    <div class="container">
        <h1>Connexion</h1>
        <form action="#" method="post"> <!-- toujours penser a mettre ca -->
        <form>
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Se connecter</button>
        </form>
        <p class="register-link">Pas encore inscrit ? <a href="inscription.php">Créer un compte</a></p>
    </div>
</body>
</html>
