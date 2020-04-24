<?php
require_once('../outil/outils_securite.php');

session_start();
timeout_session();
// la session devrait vivre au maximum 15 minutes
$_SESSION['discard_after'] = time() + 900;
interdire_sans_login();
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
    <form method="POST" action="../controller/disconnexionController.php">
        <input type="hidden" name="action" value="disconnect">
        <input type="hidden" name="loginPage" value="../view/connexion.php?disconnect">
        <button class="btn-logout form-btn">Déconnexion</button>
    </form>

    <h2><?php echo $_SESSION["connected_user"]["prenom"];?> <?php echo $_SESSION["connected_user"]["nom"];?> - Messagerie</h2>
</header>

<section>

    <article>
        <form method="POST" action="../controller/messagerieController.php">
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

                            // un client ne peut qu'envoyer un message à un employé
                            if ($_SESSION["connected_user"]["profil_user"] == "client" && $user["profil_user"] == "client" ) {
                                continue;
                            }

                            // l'utilisateur ne peut pas envoyer à lui-même
                            if ($id != $_SESSION["connected_user"]["id_user"]){
                                echo '<option value="'.$id.'">'.$user['nom'].' '.$user['prenom'].'</option>';
                            }
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
                
                if (isset($_REQUEST["msg_fail"])){
                    echo '<p>Envoie de message échoué. </p>';
                }
                ?>
                <p><a href="../controller/messagerieController.php?action=msglist&userid=<?php echo $_SESSION["connected_user"]["id_user"];?>" target="_blank">Mes messages reçus</a></p>
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
