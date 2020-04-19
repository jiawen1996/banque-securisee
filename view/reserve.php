<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Reserve</title>
    <link rel="stylesheet" type="text/css" media="all"  href="../css/mystyle.css" />
</head>
<body>
<header>
    <form method="POST" action="../controller/myController.php">
        <input type="hidden" name="action" value="disconnect">
        <input type="hidden" name="loginPage" value="../view/connexion.php?disconnect">
        <button class="btn-logout form-btn">Déconnexion</button>
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
                Vous n'avez pas droit à accéder à la page !
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