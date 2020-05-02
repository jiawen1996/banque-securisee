<?php
require_once('../outil/outils_securite.php');

session_start();
timeout_session();
// la session devrait vivre au maximum 15 minutes
$_SESSION['discard_after'] = time() + 900;
interdire_sans_login();
reserver_employe();

?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Déverrouiller un utilisateur</title>
    <link rel="stylesheet" type="text/css" media="all"  href="../css/mystyle.css" />
</head>
<body>
<header>
    <form method="POST" action="../controller/disconnexionController.php">
        <input type="hidden" name="action" value="disconnect">
        <input type="hidden" name="loginPage" value="../view/connexion.php?disconnect">
        <button class="btn-logout form-btn"><?php echo $_SESSION["connected_user"]["prenom"];?> <?php echo $_SESSION["connected_user"]["nom"];?> - Déconnexion</button>
    </form>

    <h2> Liste d'utilisateurs blocqués</h2>
</header>

<section>    
    <!-- Liste d'utilisateurs bloqués avec son login - la date de connexion échec - l'appareil -->
  
    <?php
        foreach ($_SESSION['listeBlockedUsers'] as $id => $connection) {
            echo '<acticle><div class="fieldset">';
            echo '<div class="fieldset_label">';
            echo '<span> Connexion </span>';
            echo '</div>';
            echo '<div class="field">';
            echo '<p>Login : '. $connection['login'] . '</p>';
            echo '</div>';
            echo '<div class="field">';
            echo '<p>Appareil : '. $connection['device'] . '</p>';
            echo '</div>';
            echo '<div class="field">';
            echo '<p>Dernière connexion : '. $connection['error_date'] . '</p>';
            echo '</div>';
            echo '<form action="../controller/deverrouillageController.php" method="POST">';
            echo '<button class="form-btn" type="submit" name="id_connection" value="' . $connection['id_connection'] . '">Déverrouiller</button>';
            echo '</form></div></acticle>';
      }
    ?>

    <!-- Afficher les informations d'un client sélectioné et un lien de virement -->
    <?php
        if (isset($_REQUEST["unlock_ok"])) {
            echo '<p>Déverrouillage réussit ! </p>';
        }

        if (isset($_REQUEST["unlock_fail"])) {
            echo '<p class="errmsg"> Déverrouillage échec </p>';
        }

        if (isset($_REQUEST["unfoundConnection"])) {
            echo '<p class="errmsg"> Unfound Connection </p>';
        }

        if (isset($_REQUEST["foundConnection"])) {
            echo '<p> found Connection : '.$_SESSION["ip"].' </p>';
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
