<?php
session_start(); // Démarre la session pour gérer les données de session

// Informations de connexion à la base de données
$host = 'localhost'; // Hôte de la base de données
$dbname = 'projet conception'; // Nom de la base de données
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
    echo "Erreur de connexion : " . $e->getMessage();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nutrition</title>
    <link rel="stylesheet" href="indexp.css">
</head>
<body>
    
    <header>
        <div class="logo">
            <p><span>Easy</span>Nutrition</p>
        </div>
        <ul class="menu">
            <li><a href="#home">Acceuil</a></li>
            <li><a href="#menu">Menu</a></li>
            <li><a href="#about_us">A Propos</a></li>
            <li><a href="#reservation">Contact</a></li>
        </ul>

        <!-- menu responsive -->
        <div class="toggle_menu"></div>
    </header>

    <!-- section acceuil home -->

    <section id="home">
        <div class="left">
            <h3>Bienvenue dans votre voyage</h3>
            <h4>vers une meilleure santé nutritionnelle</h4>
            <p>Nous sommes ravis de vous acceuillir dans notre communauté dédiée à la santé nutritionnelle et au bien etre. Ici, vous découvrirez des conseils nutritionnels personnalisés, des recettes savoureuses et des outils pour vous aidez à atteindre vos objectifs de santé. Que vous souhaitiez perdre du poids, améliorer votre énergie ou simplement adopter une alimentation plus équilibrée, nous sommes là pour vous accompagner à chaque étape. Ensemble, faisons de chaque repas une occasion de prendre soin de vous !Merci de nous rejoindre dans cette aventure. Votre chemin vers une meilleure nutrition commence ici!</p>
             <button><a href="#">Suivant</a></button>
        </div>
        <div class="right">
            <img id="startbucks" src="images/14.jpg" alt="Image de Starbucks"> <!-- Image principale -->
        </div>
    </section>


         <!-- Image principale -->
         <div class="imgBox">
            <img id="startbucks" src="images/14.jpg" alt="Image de Starbucks"> <!-- Image principale -->
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


       <!-- section  menu -->

       <section id="menu">
        <h4 class="mini_title">Menu</h4>
        <h2 class="title">Votre Menu Fonctionnel</h2>
        
        <div class="dishes">
            <?php if (!empty($repas)): ?> <!-- Vérifie si des repas sont disponibles -->
                <?php foreach ($repas as $repas_item): ?> <!-- Parcourt chaque repas -->
                    <div class="dish">
                        <img src="uploads/<?php echo htmlspecialchars($repas_item['image']); ?>" alt="<?php echo htmlspecialchars($repas_item['titre']); ?>"> <!-- Affiche l'image du repas -->
                        <p><?php echo htmlspecialchars($repas_item['titre']); ?></p> <!-- Affiche le titre du repas -->
                         <!-- Vous pouvez remplacer ce prix par une valeur dynamique si disponible -->
                         <!-- Bouton d'achat -->
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun repas trouvé.</p> <!-- Message si aucun repas n'est trouvé -->
            <?php endif; ?>
        </div>
    </section>


       <!-- section about us -->

       <section id="about_us">
            <h4 class="mini_title">A propos de nous</h4>
            <h2 class="title">Pourquoi nous choisir ?</h2>
            <div class="about">
                <div class="left">
                    <img src="images/img-about-us.png">
                </div>
                <div class="right">
                    <h3>Best Food in The Word</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae est, iure culpa ipsa tempora explicabo ullam similique? Ipsum, est, beatae adipisci autem dolores, dolore eveniet mollitia quibusdam eius provident fugiat!</p>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Debitis ipsa non quis pariatur enim fugit ratione. Unde maiores veritatis eaque accusamus minus sunt, eligendi nisi officiis quis vitae dignissimos officia.</p>
                    <button><a href="#">Learn More</a></button>
                </div>
            </div>
       </section>


       <!-- section comments -->
      <section class="comment_section">
            <h4 class="mini_title">Comments</h4>
            <h2 class="title"> What People this about us</h2>
            <div class="comments">
                <div class="comment">
                    <div>
                        <img src="images/img1.png">
                        <h4>Smith Johnson</h4>
                    </div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est, sequi repellat. Velit, temporibus! Repellat velit delectus vero suscipit ut, consequatur atque molestias obcaecati tenetur dignissimos! Eius eos reprehenderit aspernatur molestiae?</p>
                </div>
                <div class="comment">
                    <div>
                        <img src="images/img1.png">
                        <h4>Smith Johnson</h4>
                    </div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est, sequi repellat. Velit, temporibus! Repellat velit delectus vero suscipit ut, consequatur atque molestias obcaecati tenetur dignissimos! Eius eos reprehenderit aspernatur molestiae?</p>
                </div>
                <div class="comment">
                    <div>
                        <img src="images/img1.png">
                        <h4>Smith Johnson</h4>
                    </div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est, sequi repellat. Velit, temporibus! Repellat velit delectus vero suscipit ut, consequatur atque molestias obcaecati tenetur dignissimos! Eius eos reprehenderit aspernatur molestiae?</p>
                </div>


            </div>
      </section>

      <!-- section reservation -->
      <section id="reservation">
        <h4 class="mini_title">reservation</h4>
        <h2 class="title"> fill this form to make a reservation</h2>
        <form action="">
            <label> Your Name</label>
            <input type="text">
            <label> Your Email</label>
            <input type="email">
            <label> Your Number</label>
            <input type="text">
            <label> Reservation Date</label>
            <input type="date">
            <input type="submit" value="Make The Reservation">
            
        </form>
      </section>


      <!-- footer -->
      <footer>
          <div class="services_list">
              <div class="service">
                  <img src="images/clock.png" alt="">
                  <h2>Ouverture</h2>
                  <p>10h30 à 23h45</p>
                  <p>23h45 à 9h30</p>
              </div>

              <div class="service">
                <img src="images/pin.png" alt="">
                <h2>Adresses</h2>
                <p>France-Paris</p>
                <p>Bénin-Cotonou</p>
            </div>
            <div class="service">
                <img src="images/email.png" alt="">
                <h2>Emails</h2>
                <p>email@gmail.com</p>
                <p>your.dish@gmail.com</p>
            </div>
            <div class="service">
                <img src="images/call.png" alt="">
                <h2>Numbers</h2>
                <p>+33 54454544</p>
                <p>+33 45687515</p>
            </div>
            
            <hr>
          </div>

          <p class="footer_text"> <span></span> | Tous les droits sont réservés.</p>
      </footer>


      <script>
          var small_menu = document.querySelector('.toggle_menu')
          var menu = document.querySelector('.menu')

          small_menu.onclick = function(){
               small_menu.classList.toggle('active');
               menu.classList.toggle('responsive');
          }
      </script>

<script type="text/javascript">
        // Fonction pour changer l'image principale
        function imgSlider(anything) {
            document.getElementById('startbucks').src = anything; // Change la source de l'image
        }
    </script>

</body>
</html>