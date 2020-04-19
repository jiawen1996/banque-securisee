<?php
session_start();
require_once('../outils_securite.php');
interdireSansLogin();
?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Mon Compte</title>
  <link rel="stylesheet" type="text/css" media="all"  href="../css/mystyle.css" />
</head>
<body>
    <header>
        <form method="POST" action="../controller/myController.php">
            <input type="hidden" name="action" value="disconnect">
            <input type="hidden" name="loginPage" value="../view/connexion.php?disconnect">
            <button class="btn-logout form-btn">Déconnexion</button>
        </form>
        
        <h2><?php echo $_SESSION["connected_user"]["prenom"];?> <?php echo $_SESSION["connected_user"]["nom"];?> - Mon compte</h2>
    </header>
    
    <section>
      
        <article>
          <div class="fieldset">
              <div class="fieldset_label">
                  <span>Vos informations personnelles</span>
              </div>
              <div class="field">
                  <label>Nom : </label><span><?php echo $_SESSION["connected_user"]["nom"];?></span>
              </div>
              <div class="field">
                  <label>Prénom : </label><span><?php echo $_SESSION["connected_user"]["prenom"];?></span>
              </div>
              <div class="field">
                  <label>Login : </label><span><?php echo $_SESSION["connected_user"]["login"];?></span>
              </div>
              <div class="field">
                  <label>Profil : </label><span><?php echo $_SESSION["connected_user"]["profil_user"];?></span>
              </div>
              <p><a href="vw_messagerie.php" target="_blank">Messagerie</a></p>
              <p><a href="vw_virement.php" target="_blank">Virement</a></p>
          </div>
        </article>
        
        <article>
          <div class="fieldset">
              <div class="fieldset_label">
                  <span>Votre compte</span>
              </div>
              <div class="field">
                  <label>N° compte : </label><span><?php echo $_SESSION["connected_user"]["numero_compte"];?></span>
              </div>
              <div class="field">
                  <label>Solde : </label><span><?php echo $_SESSION["connected_user"]["solde_compte"];?> &euro;</span>
              </div>
          </div>
        </article>
        
        <article>
          <div class="fieldset">
              <div class="fieldset_label">
                  <span>Vos activités</span>
              </div>
              <div class="field">
                <button onclick="location.href='vw_virement.php'">Effectuer un virement</button>
              </div>
              <div class="field">
                <button onclick="location.href='vw_messagerie.php'">Messagerie</button>
              </div>

              <!-- Fiche Client s'affiche uniquement pour les employés -->
              <?php
              if ($_SESSION["connected_user"]["profil_user"] == "employe") {
                echo("<div class=\"field\"><button onclick=\"location.href='ficheClient.php'\">Fiche client</button></div>"); 
              }
              ?>
          </div>
        </article>
    </section>

</body>
</html>
