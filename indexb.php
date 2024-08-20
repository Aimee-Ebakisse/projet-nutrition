<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue dans mon application</title>
    <link rel="stylesheet" href="Css/indexb.css">
</head>
<body>
    <section>
        <header>
            <a href="#"><img src="img/15.jpg" class="logo" alt="Logo"></a>
            <ul>
                <li><a href="#">Accueil</a></li>
                <li><a href="#">Menu</a></li>
                <li><a href="#">À propos</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </header>
        <div class="content">
            <div class="textBox">
                <h2>Bienvenue<br><span>dans l'univers</span></h2>
                <?php echo isset($_SESSION['nom']) ? htmlspecialchars($_SESSION['nom']) : 'nom'; ?>
                <?php
                // Affichage de la photo si elle est définie dans la session
                if (isset($_SESSION['photo'])) {
                    echo '<h3>Votre photo:</h3>';
                    echo '<img src="' . htmlspecialchars($_SESSION['photo']) . '" alt="Votre photo" style="max-width: 200px;"/>';
                } else {
                    echo '<p>Aucune photo de profil disponible.</p>';
                }
                ?>
                <p>qui changera votre santé nutritionnelle.</p>
                <a href="#">suivant</a>
            </div>
        </div>
        <div class="imgBox">
            <img id="startbucks" src="img/14.jpg" alt="Image de Starbucks">
        </div>
        <ul class="thumb">
            <li><img src="img/11.jpg" onclick="imgSlider('img/11.jpg');changeCircleColor('#017143')"></li>
            <li><img src="img/14.jpg" onclick="imgSlider('img/14.jpg');changeCircleColor('#eb7495')"></li>
            <li><img src="img/13.jpg" onclick="imgSlider('img/13.jpg');changeCircleColor('#d752b1')"></li>
        </ul>
    </section>



    <section class="product">
    <div class="container py-5">
        <div class="row py-5 ">
            <div class="col-lg-5 m-auto text-center">
                 <h1>What's Trendinng</h1>
                 <h6 style="color: red;">Be Healthy Organic Food</h6>
            </div>
        </div>
            <div class="row">
                <div class="col-lg-3">
                 
                </div>
            </div>
    </div>
</section>



    <script type="text/javascript">
        function imgSlider(anything) {
            document.getElementById('startbucks').src = anything; // Correction ici
        }
        function changeCircleColor(color) {
            const circle = document.querySelector('.circle');
            circle.style.background = color;
        }
    </script>
</body>
</html>
