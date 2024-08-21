<?php
session_start(); // Démarre la session pour gérer les données de session

// Informations de connexion à la base de données
$host = 'localhost'; // Hôte de la base de données
$dbname = 'projet conception'; // Nom de la base de données (sans espaces)
$username = 'root'; // Nom d'utilisateur pour la base de données
$password = ''; // Mot de passe pour la base de données

try {
    // Connexion à la base de données avec PDO
    $con = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Gestion des erreurs

    // Pagination
    $limit = 6; // Nombre d'images à afficher par page
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Récupère le numéro de page à partir de l'URL (par défaut 1)
    $offset = ($page - 1) * $limit; // Calcul de l'offset pour la requête SQL

    // Récupérer les repas depuis la base de données avec pagination
    $stmt = $con->prepare("SELECT * FROM repas LIMIT :limit OFFSET :offset");
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT); // Lier la limite
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT); // Lier l'offset
    $stmt->execute(); // Exécute la requête
    $repas = $stmt->fetchAll(PDO::FETCH_ASSOC); // Récupère tous les résultats sous forme de tableau associatif

    // Compter le nombre total de repas dans la base de données
    $countStmt = $con->query("SELECT COUNT(*) FROM repas");
    $totalCount = $countStmt->fetchColumn(); // Récupère le nombre total de repas
    $totalPages = ceil($totalCount / $limit); // Calcule le nombre total de pages
} catch (PDOException $e) {
    // Affiche un message d'erreur en cas de problème de connexion
    die("Erreur de connexion : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"> <!-- Définit le jeu de caractères -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Responsive design -->
    <title>Bienvenue dans mon application</title> <!-- Titre de la page -->
    <link rel="stylesheet" href="Css/indexb.css"> <!-- Lien vers la feuille de style CSS -->
</head>
<body>
    <section>
        <!-- En-tête de l'application -->
        <header>
            <a href="#"><img src="img/15.jpg" class="logo" alt="Logo"></a> <!-- Logo de l'application -->
            <ul>
                <li><a href="#">Accueil</a></li> <!-- Lien vers la page d'accueil -->
                <li><a href="#">Menu</a></li> <!-- Lien vers le menu -->
                <li><a href="#">À propos</a></li> <!-- Lien vers la page à propos -->
                <li><a href="#">Contact</a></li> <!-- Lien vers la page de contact -->
            </ul>
        </header>

        <!-- Contenu principal -->
        <div class="content">
            <div class="textBox">
                <h2>Bienvenue<br><span>dans l'univers</span></h2> <!-- Titre de bienvenue -->
                <p>qui changera votre santé nutritionnelle.</p> <!-- Description -->
                <a href="#">suivant</a> <!-- Lien pour passer à la page suivante -->
            </div>
        </div>

        <!-- Image principale -->
        <div class="imgBox">
            <img id="startbucks" src="img/14.jpg" alt="Image de Starbucks"> <!-- Image principale -->
         </div> 

        <!-- Vignettes des repas -->
        <ul class="thumb">
            <?php if (!empty($repas)): ?> <!-- Vérifie si des repas sont disponibles -->
                <?php foreach ($repas as $repas_item): ?> <!-- Parcourt chaque repas -->
                    <li>
                        <img src="uploads/<?php echo htmlspecialchars($repas_item['image']); ?>" 
                             alt="<?php echo htmlspecialchars($repas_item['titre']); ?>" 
                             onclick="imgSlider('uploads/<?php echo htmlspecialchars($repas_item['image']); ?>');"> <!-- Image du repas -->
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun repas trouvé.</p> <!-- Message si aucun repas n'est trouvé -->
            <?php endif; ?>
        </ul>
    </section>

    <section class="product">
        <div class="container py-5">
            <div class="row py-5 ">
                <div class="col-lg-5 m-auto text-center">
                    <h1>What's Trending</h1> <!-- Titre pour les produits tendance -->
                    <h6 style="color: red;">Be Healthy Organic Food</h6> <!-- Sous-titre -->
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <!-- Autres produits ou contenu -->
                </div>
            </div>
        </div>
    </section>

    <script type="text/javascript">
        // Fonction pour changer l'image principale
        function imgSlider(anything) {
            document.getElementById('startbucks').src = anything; // Change la source de l'image
        }
    </script>
</body>
</html>
