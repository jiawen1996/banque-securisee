<?php
  session_start();
require_once('../outil/outils_securite.php');
interdireSansLogin();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Boite réception</title>
    <link rel="stylesheet" type="text/css" media="all"  href="../css/mystyle.css" />
</head>
<body>
  <header>
        <form method="POST" action="../controller/disconnexionController.php">
            <input type="hidden" name="action" value="disconnect">
            <input type="hidden" name="loginPage" value="../view/connexion.php?disconnect">
            <button class="btn-logout form-btn">Déconnexion</button>
        </form>
        
        <h2><?php echo $_SESSION["connected_user"]["prenom"];?> <?php echo $_SESSION["connected_user"]["nom"];?> - Boite réception</h2>
  </header>
  <section>
    <?php
      foreach ($_SESSION['messagesRecus'] as $cle => $message) {
        echo '<acticle><div class="fieldset">';
        echo '<div class="fieldset_label">';
        echo '<span> Message </span>';
        echo '</div>';
        echo '<div class="field">';
        echo '<label">Expédicteur : </label><span>'. $message['nom'].' '.$message['prenom'] . '</span>';
        echo '</div>';
        echo '<div class="field">';
        echo '<label">Sujet : </label><span>'.  $message['sujet_msg'] . '</span>';
        echo '</div>';
        echo '<div class="field">';
        echo '<label>Message : </label><div><span>'. $message['corps_msg'].'</div></span>';
        echo '</div></div></article>';
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
