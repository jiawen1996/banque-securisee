<?php
require_once('../outil/outils_securite.php');

session_start();
timeout_session();
// la session devrait vivre au maximum 15 minutes
$_SESSION['discard_after'] = time() + 900;
interdire_sans_login();
delete_chosen_user();

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
        <form method="POST" action="../controller/disconnexionController.php">
            <input type="hidden" name="action" value="disconnect">
            <input type="hidden" name="loginPage" value="../view/connexion.php?disconnect">
            <button class="btn-logout form-btn"><?php echo $_SESSION["connected_user"]["prenom"];?> <?php echo $_SESSION["connected_user"]["nom"];?> - Déconnexion</button>
        </form>
        
        <h2> Mon compte</h2>
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
                <button onclick="location.href='virement.php'">Effectuer un virement</button>
              </div>
              <div class="field">
                <button onclick="location.href='messagerie.php'">Messagerie</button>
              </div>

              <!-- Fiche Client s'affiche uniquement pour les employés -->
              <?php
              if ($_SESSION["connected_user"]["profil_user"] == "employe") {
                echo '<div class="field">';
                echo '<button onclick="location.href=\'fiche_client.php\'">Fiche client</button>';
                echo '</div>'; 
                echo '<div class="field">';
                echo '<button onclick="location.href=\'deverrouillage.php\'">Déverrouiller d\' un utilisateur</button>';
                echo '</div>'; 
              }
              ?>
          </div>
        </article>
    </section>

</body>
</html>

