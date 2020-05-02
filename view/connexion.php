<?php
session_start();
require_once('../outil/outils_securite.php');
delete_chosen_user();

?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Connexion</title>
  <link rel="stylesheet" type="text/css" media="all"  href="../css/mystyle.css" />
</head>
<body>
  <header>
    <h1>Connexion</h1>
  </header>
  
  <section>
      <div class="login-page">
        <div class="form">
            <form method="POST" action="../controller/connexionController.php">
                <input type="text" name="login" placeholder="login"/>
                <input type="password" name="mdp" placeholder="mot de passe"/>
                <button <?php
                    if (isset($_SESSION['tentatives']) && $_SESSION['tentatives'] >=5) {
                        echo 'disabled style="cursor: not-allowed;background-color: #999;"';
                    }
                ?>>
                  login
                </button>
            </form>
        </div>
      </div>

      <?php
      if (isset($_REQUEST["nullvalue"])) {
        echo '<p class="errmsg">Merci de saisir votre login et votre mot de passe</p>';
      } else if (isset($_REQUEST["badvalue"])) {
        echo '<p class="errmsg">Votre login/mot de passe est incorrect. Nombre de tentatives : '. $_SESSION["tentatives"] .'/5</p>';
      } else if (isset($_REQUEST["disconnect"])) {
        echo '<p>Vous avez bien été déconnecté.</p>';
      } else if (isset($_REQUEST["limitexceeded"])) {
        echo '<p class="errmsg">Le nombre de tentatives a été dépassé ! Vous êtes verrouillé.</p>';
        echo '<p class="errmsg">Veuillez contacter à votre conseiller pour vous déverrouiller.</p>'; 
      } else if (isset($_REQUEST["unlock"])) {
        //Unlock button Login
        unset($_SESSION['tentatives']);
        header( "Location:connexion.php");
      }
      ?>
  </section>

</body>
</html>
 