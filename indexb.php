<?php
session_start(); // Assurez-vous que la session est démarrée

// Connexion à la base de données
$host = 'localhost';
$dbname = 'projet conception';
$username = 'root';
$password = '';

try {
    $con = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Pagination
    $limit = 6; // Nombre d'images par page
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $limit;

    // Récupérer les repas depuis la base de données
    $stmt = $con->prepare("SELECT * FROM repas LIMIT :limit OFFSET :offset");
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $repas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Compter le nombre total de repas
    $countStmt = $con->query("SELECT COUNT(*) FROM repas");
    $totalCount = $countStmt->fetchColumn();
    $totalPages = ceil($totalCount / $limit);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue dans mon application</title>
    <link rel="stylesheet" href="Css/indexb.css">

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        /* Style de la navbar */
        nav {
            background-color: #333;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1000;
            width: 200vh;
        }

        /* Style du logo */
        nav .logo {
            max-height: 50px;
            height: auto;
        }

        /* Style des liens de la navbar */
        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            color: #b73816;
            align-items: center;
        }

        nav ul li {
            margin: 0 15px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            padding: 8px 12px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        nav ul li a:hover {
            background-color: #555;
        }

        /* Style pour la réactivité (responsive) */
        @media (max-width: 768px) {
            nav ul {
                flex-direction: column;
                display: none;
                width: 100%;
                background-color: #333;
            }

            nav ul.active {
                display: flex;
            }

            nav ul li {
                text-align: center;
                margin: 10px 0;
            }

            nav .menu-toggle {
                display: block;
                cursor: pointer;
                font-size: 28px;
                color: white;
            }
        }
    </style>
</head>




<body>
    <section>
        <header>
        <nav>
        <a href="#"><img src="img/15.jpg" class="logo" alt="Logo"></a>
        <div class="menu-toggle">&#9776;</div>
        <ul>
            <li><a href="#">Accueil</a></li>
            <li><a href="#">Menu</a></li>
            <li><a href="#">À propos</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
    </nav>

        </header>
        <div class="content">
            <div class="textBox">
                <h2>Bienvenue<br><span>dans l'univers</span></h2>
                <p>qui changera votre santé nutritionnelle.</p>
                <a href="#">suivant</a>
            </div>
        </div>
        <div class="imgBox">
            <img id="startbucks" src="img/14.jpg" alt="Image de Starbucks">
        </div>
        <ul class="thumb">
            <?php if (!empty($repas)): ?>
                <?php foreach ($repas as $repas_item): ?>
                    <li>
                        <img src="uploads/<?php echo htmlspecialchars($repas_item['image']); ?>" 
                             alt="<?php echo htmlspecialchars($repas_item['titre']); ?>" 
                             onclick="imgSlider('uploads/<?php echo htmlspecialchars($repas_item['image']); ?>');">
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun repas trouvé.</p>
            <?php endif; ?>
        </ul>
    </section>

    <section class="product">
        <div class="container py-5">
            <div class="row py-5 ">
                <div class="col-lg-5 m-auto text-center">
                    <h1>What's Trending</h1>
                    <h6 style="color: red;">Be Healthy Organic Food</h6>
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
        function imgSlider(anything) {
            document.getElementById('startbucks').src = anything;
        }
        function changeCircleColor(color) {
            const circle = document.querySelector('.circle');
            circle.style.background = color;
        }
    </script>
     <script>
        // JavaScript pour le menu responsive
        document.querySelector('.menu-toggle').addEventListener('click', function() {
            document.querySelector('nav ul').classList.toggle('active');
        });
    </script>


</body>
</html>
