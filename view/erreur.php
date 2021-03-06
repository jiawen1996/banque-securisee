<?php
require_once('../outil/outils_securite.php');

session_start();
timeout_session();
interdire_sans_login();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Erreur</title>
    <link rel="stylesheet" type="text/css" media="all"  href="../css/mystyle.css" />
</head>
<body>
<header>
    <form method="POST" action="../controller/disconnexionController.php">
        <input type="hidden" name="action" value="disconnect">
        <input type="hidden" name="loginPage" value="../view/connexion.php?disconnect">
        <button class="btn-logout form-btn"><?php echo $_SESSION["connected_user"]["prenom"];?> <?php echo $_SESSION["connected_user"]["nom"];?> - Déconnexion</button>
    </form>
    <h2>ATTENTION !</h2>
</header>

<section>    
    <article>
        <div class="fieldset">
            <div class="fieldset_label">
                <span>Erreur</span>
            </div>
            <div class="field">
            <?php 
                if (isset($_REQUEST["unfoundConnection"])) {
                    echo 'La connexion ne se trouve pas dans la base.';
                } else {
                    echo 'Vous n\'avez pas droit à accéder à la page !';
                }
            ?>  
            </div>
        </div>
    </article>

    <article>
        <div class="field">
            <button class="btn-logout form-btn" onclick="location.href='accueil.php'">Retour vers Mon Compte</button>
        </div>
    </article>

</section>

</body>
</html>
