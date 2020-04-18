<?php
    session_start();
    require_once('../outils_securite.php');
    interdireSansLogin();
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
    <form method="POST" action="../controller/myController.php">
        <input type="hidden" name="action" value="disconnect">
        <input type="hidden" name="loginPage" value="vw_login.php?disconnect">
        <button class="btn-logout form-btn">Déconnexion</button>
    </form>

    <h2><?php echo $_SESSION["connected_user"]["prenom"];?> <?php echo $_SESSION["connected_user"]["nom"];?> - Mon compte</h2>
</header>

<section>

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
        <form method="POST" action="../controller/virementController.php">
            <input type="hidden" name="action" value="transfert">
            <div class="fieldset">
                <div class="fieldset_label">
                    <span>Transférer de l'argent</span>
                </div>
                <div class="field">
                    <label>N° compte destinataire : </label>
                    <select name="destination">
                        <?php
                        foreach ($_SESSION['listeUsers'] as $id => $user) {
                            $idUser = $_SESSION["connected_user"]['id_user'];
                            if ($id != $_SESSION["connected_user"]["id_user"]){
                                echo '<option value="'.$id.'">'.$user['nom'].' '.$user['prenom'].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="field">
                    <label>Montant à transférer : </label><input type="text" size="10" name="montant">
                </div>
                <button class="form-btn">Transférer</button>
                <?php
                if (isset($_REQUEST["trf_ok"])) {
                    echo '<p>Virement effectué avec succès.</p>';
                }
                if (isset($_REQUEST["bad_mt"])) {
                    echo '<p>Le montant saisi est incorrect : '.$_REQUEST["bad_mt"].'</p>';
                }
                ?>
            </div>
        </form>
    </article>

</section>

</body>
</html>
