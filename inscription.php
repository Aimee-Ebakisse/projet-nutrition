<?php
session_start(); // Démarrer la session

// Connexion à la base de données
try {
    $pdo = new PDO('mysql:host=localhost;dbname=Projet conception', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $nom = $_POST['nom']; // Changer 'name' en 'nom'
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hasher le mot de passe
    $age = $_POST['age'];
    $objectif = $_POST['goal'];

    // Gestion de l'img de l'image
    $photo = $_FILES['photo'];
    $photoPath = 'img/' . basename($photo['name']); // Changer 'nom' en 'name'

    // Validation des données (à améliorer)
    if (empty($nom) || empty($email) || empty($password) || empty($age) || empty($objectif) || empty($photo['name'])) {
        die("Veuillez remplir tous les champs");
    }

    // Vérification et déplacement de l'image téléchargée
    if (move_uploaded_file($photo['tmp_name'], $photoPath)) { // Changer 'tmp_nom' en 'tmp_name'
        // Insertion dans la base de données
        $stmt = $pdo->prepare("INSERT INTO projet (nom, email, password, age, objectif, photo) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$nom, $email, $password, $age, $objectif, $photoPath])) {
    
            // Enregistrer le chemin de la photo et le nom dans la session
            $_SESSION['photo'] = $photoPath;
            $_SESSION['nom'] = $nom; // Enregistrer le nom dans la session

            // Redirection vers la page d'accueil
            header('Location: dashboard.php');
            exit();
        } else {
            echo "Erreur lors de l'inscription.";
        }
    } else {
        echo "Erreur lors du téléchargement de la photo.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Suivi Alimentaire</title>
    <link rel="stylesheet" href="Css/inscription.css"> <!-- Lien vers le fichier CSS -->
</head>
<body>
    <div class="container">
        <h1>Inscription</h1>
        <form action="#" method="post" enctype="multipart/form-data"> <!-- Ajout de l'attribut enctype -->
            <label for="nom">Nom :</label> <!-- Changer 'name' en 'nom' -->
            <input type="text" id="nom" name="nom" required> <!-- Changer 'name' en 'nom' -->

            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>

            <label for="age">Âge :</label>
            <input type="number" id="age" name="age" required>

            <label for="goal">Objectif :</label>
            <select id="goal" name="goal">
                <option value="perdre">Perdre du poids</option>
                <option value="maintenir">Maintenir le poids</option>
                <option value="prendre">Prendre du poids</option>
            </select>

            <label for="photo">Photo de profil :</label>
            <input type="file" id="photo" name="photo" accept="image/*" required> <!-- Champ pour la photo -->

            <button type="submit">S'inscrire</button>
        </form>
    </div>
</body>
</html>
