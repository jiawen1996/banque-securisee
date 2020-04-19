<?php
    session_start();
    require_once('../outils_securite.php');
    interdireSansLogin();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Virement</title>
    <link rel="stylesheet" type="text/css" media="all"  href="../css/mystyle.css" />
</head>
<body>
<header>
    <form method="POST" action="../controller/myController.php">
        <input type="hidden" name="action" value="disconnect">
        <input type="hidden" name="loginPage" value="../view/connexion.php?disconnect">
        <button class="btn-logout form-btn">Déconnexion</button>
    </form>

    <h2><?php echo $_SESSION["connected_user"]["prenom"];?> <?php echo $_SESSION["connected_user"]["nom"];?> - Virement</h2>
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
                    
                        <!-- Si la destination n'est pas encore prédéfinie, on affiche une liste déroulante pour choisir
                            Sinon, on fixe la destination se trouvant dans $_SESSION['chosen_user']  -->

                        <!-- RAISON SÉCURITÉE : il y a une seule destination si le site est dirigé depuis ficheClient.php -->
                        <?php
                            if (!isset($_SESSION['chosen_user'])) {
                                foreach ($_SESSION['listeUsers'] as $id => $user) {
                                    $idUser = $_SESSION["connected_user"]['id_user'];
                                    if ($id != $_SESSION["connected_user"]["id_user"]){
                                        echo '<option value="'.$id.'">'.$user['nom'].' '.$user['prenom'].'</option>';
                                    }
                                }
                            } else {
                                echo '<option value="'.$_SESSION['chosen_user']['id_user'].'">'.$_SESSION['chosen_user']['nom'].' '.$_SESSION['chosen_user']['prenom'].'</option>';
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

    <article>
        <div class="field">
            <button class="btn-logout form-btn" onclick="location.href='accueil.php'">Retour vers Mon Compte</button>
        </div>
    </article>
    

</section>

</body>
</html>
