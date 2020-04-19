<?php
session_start();
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
    <form method="POST" action="../controller/myController.php">
        <input type="hidden" name="action" value="disconnect">
        <input type="hidden" name="loginPage" value="../view/connexion.php?disconnect">
        <button class="btn-logout form-btn">Déconnexion</button>
    </form>

    <h2><?php echo $_SESSION["connected_user"]["prenom"];?> <?php echo $_SESSION["connected_user"]["nom"];?> - Fiche client</h2>
</header>

<section>    
    <!-- TODO : Afficher tous les clients -->
    <!-- TODO : Afficher les informations d'un client sélectioné et un lien de virement -->

    <article>
        <div class="field">
            <button class="btn-logout form-btn" onclick="location.href='accueil.php'">Retour vers Mon Compte</button>
        </div>
    </article>

</section>

</body>
</html>
