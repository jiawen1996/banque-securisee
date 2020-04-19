<?php
session_start();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Messagerie</title>
    <link rel="stylesheet" type="text/css" media="all"  href="../css/mystyle.css" />
</head>
<body>
<header>
<form method="POST" action="../controller/myController.php">
        <input type="hidden" name="action" value="disconnect">
        <input type="hidden" name="loginPage" value="../view/connexion.php?disconnect">
        <button class="btn-logout form-btn">Déconnexion</button>
    </form>

    <h2><?php echo $_SESSION["connected_user"]["prenom"];?> <?php echo $_SESSION["connected_user"]["nom"];?> - Messagerie</h2>
</header>

<section>

    <article>
        <form method="POST" action="myController.php">
            <input type="hidden" name="action" value="sendmsg">
            <div class="fieldset">
                <div class="fieldset_label">
                    <span>Envoyer un message</span>
                </div>
                <div class="field">
                    <label>Destinataire : </label>
                    <select name="to">
                        <?php
                        foreach ($_SESSION['listeUsers'] as $id => $user) {
                            echo '<option value="'.$id.'">'.$user['nom'].' '.$user['prenom'].'</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="field">
                    <label>Sujet : </label><input type="text" size="20" name="sujet">
                </div>
                <div class="field">
                    <label>Message : </label><input type="text" size="40" name="corps">
                </div>
                <button class="form-btn">Envoyer</button>
                <?php
                if (isset($_REQUEST["msg_ok"])) {
                    echo '<p>Message envoyé avec succès.</p>';
                }
                ?>
                <p><a href="myController.php?action=msglist&userid=<?php echo $_SESSION["connected_user"]["id_user"];?>" target="_blank">Mes messages reçus</a></p>
            </div>
        </form>
    </article>

    <article>
        <div class="field">
            <button class="btn-logout form-btn" onclick="location.href='accueil.php'">Retour vers Mon Compte</button>
        </div>
    </article>

</section>

</body>
</html>
