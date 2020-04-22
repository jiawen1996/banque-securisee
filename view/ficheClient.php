<?php
require_once('../outil/outils_securite.php');
session_start();
interdireSansLogin();
reserverEmploye();

?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Fiche client</title>
    <link rel="stylesheet" type="text/css" media="all"  href="../css/mystyle.css" />
</head>
<body>
<header>
    <form method="POST" action="../controller/disconnexionController.php">
        <input type="hidden" name="action" value="disconnect">
        <input type="hidden" name="loginPage" value="../view/connexion.php?disconnect">
        <button class="btn-logout form-btn">Déconnexion</button>
    </form>

    <h2><?php echo $_SESSION["connected_user"]["prenom"];?> <?php echo $_SESSION["connected_user"]["nom"];?> - Fiche client</h2>
</header>

<section>    
    <!-- Liste de clients -->
    <article>
          <div class="fieldset">
              <div class="fieldset_label">
                  <span>Liste de clients</span>
              </div>

              <?php
                    foreach ($_SESSION['listeClients'] as $id => $user) {
                        echo '<div class="field"><form action="../controller/ficheClientController.php" method="POST"><button type="submit" name="id_client" value="' . $user['id_user'] . '">'. $user['nom'].' '.$user['prenom'];
                        echo'</button></form></div>';
                    }
                ?>
          </div>
        </article>  

    <!-- Afficher les informations d'un client sélectioné et un lien de virement -->
    <?php
        if (isset($_SESSION["chosen_user"]) && isset($_REQUEST["userfound"])) {
            echo '<article><div class="fieldset"><div class="fieldset_label">';
            echo '<span>Informations clientèlles</span><span><a href="ficheClient.php"><button>X</button></a></span></div>';
            echo '<div class="field"><label>Nom : </label><span>' . $_SESSION['chosen_user']["nom"] . '</span></div>';
            echo '<div class="field"><label>Prénom : </label><span>' . $_SESSION['chosen_user']["prenom"] . '</span></div>';
            echo '<div class="field"><label>N° compte : </label><span>' . $_SESSION['chosen_user']["numero_compte"] . '</span></div>';
            echo '<div class="field"><label>Solde : </label><span>' . $_SESSION['chosen_user']["solde_compte"] . '</span></div>';
            echo '<div class="field"><label>Login : </label><span>' . $_SESSION['chosen_user']["login"] . '</span></div>';
            
            // numéro du compte de client se trouve dans $_SESSION["chosen_user"]["numero_compte"] est plus sécurité que le passe en URL
            echo '<p><a href="virement.php" target="_blank">Virement en tant que ' . $_SESSION['chosen_user']["nom"] . ' </a></p></div></article>';

        }

        if (isset($_REQUEST["badvalue"])) {
            echo '<p class="errmsg">Le client sélectionné ne se trouve pas dans la base de données.</p>';
        }

    ?>

    <article>
        <div class="field">
            <button class="btn-logout form-btn" onclick="location.href='accueil.php'">Retour vers Mon Compte</button>
        </div>
    </article>

</section>
</body>
</html>
