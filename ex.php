<?php 
if(isset($_POST['btn-ajouter'])){
    // Connexion à la base de données
    $host = 'localhost'; // ou l'adresse de votre serveur
    $dbname = 'projet conception';
    $username = 'root';
    $password = '';

    try {
        $con = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Récupérer les données du formulaire
        $titre = $_POST['titre'];
        $description = $_POST['description'];
        $image = $_FILES['image']['name'];
        

        // Déplacer l'image vers un dossier (si nécessaire)
        move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $image);

        // Préparer et exécuter la requête d'insertion
        $stmt = $con->prepare("INSERT INTO repas (titre, descrip, image) VALUES (:titre, :descrip, :image)");
        $stmt->bindParam(':titre', $titre);
        $stmt->bindParam(':descrip', $description);
        $stmt->bindParam(':image', $image);
        
        if($stmt->execute()) {
            echo "Le repas a été ajouté avec succès.";
        } else {
            echo "Une erreur est survenue lors de l'ajout du repas.";
        }
    } catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de repas</title>
    <link rel="stylesheet" href="ex.css">
</head>
<body>
    <section class="input_add">
        <form action="" method="POST" enctype="multipart/form-data" id="addRepasForm">
            <label>Nom du repas</label>
            <input type="text" name="titre" required>
            <label>Description du repas</label>
            <textarea name="description" cols="30" rows="10" required></textarea>
            <label>Ajouter une image</label>
            <input type="file" name="image" accept="image/*" required>
            <input type="submit" value="ajouter" name="btn-ajouter">
            <a class="btn-liste-prod" href="resultats.php">Liste des repas</a>
        </form>
    </section>
</body>
</html>
