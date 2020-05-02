<?php
    require_once('../outil/outils_securite.php');

    session_start();
    timeout_session();
    // la session devrait vivre au maximum 15 minutes
    $_SESSION['discard_after'] = time() + 900;
    interdire_sans_login();

    /*
    * Si la page virement est ouvert à l'aide du lien de virement dans la page fiche client
    * il signifie qu'il y a un client sélenctioné dans la session et on affiche les informations du compte de ce client.
    * Sinon, on affiche les informations du compte de l'utilisateur connecté 
    */
    function getUser() {
        if ( isset($_SESSION["chosen_user"])) {
            return $_SESSION["chosen_user"];
        } else {
            return $_SESSION["connected_user"];
        }
    }
    $mytoken = setToken();
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
    <form method="POST" action="../controller/disconnexionController.php">
        <input type="hidden" name="action" value="disconnect">
        <input type="hidden" name="loginPage" value="../view/connexion.php?disconnect">
        <button class="btn-logout form-btn"><?php echo $_SESSION["connected_user"]["prenom"];?> <?php echo $_SESSION["connected_user"]["nom"];?> - Déconnexion</button>
    </form>

    <h2><?php echo getUser()["prenom"];?> <?php echo getUser()["nom"];?> - Virement</h2>
</header>

<section>

    <article>
        <div class="fieldset">
            <div class="fieldset_label">
                <span>Votre compte</span>
            </div>
            <div class="field">
                <label>N° compte : </label><span><?php echo getUser()["numero_compte"];?></span>
            </div>
            <div class="field">
                <label>Solde : </label><span><?php echo getUser()["solde_compte"];?> &euro;</span>
            </div>
        </div>
    </article>

    <article>
        <form method="POST" action="../controller/virementController.php">
            <div class="fieldset">
                <div class="fieldset_label">
                    <span>Transférer de l'argent</span>
                </div>
                <div class="field">
                    <label>N° compte destinataire : </label>
                    <select name="destination">
                        <?php
                            foreach ($_SESSION['listeUsers'] as $id => $user) {
                                //Un client ne peut effectuer un virement que de son compte vers un autre compte (protection coté front-end)
                                $idUser = getUser()['id_user'];
                                if ($id != $idUser){
                                        echo '<option value="'.$user['numero_compte'].'">'.$user['nom'].' '.$user['prenom'].'</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="field">
                    <label>Montant à transférer : </label><input type="number" step='0.01' placeholder='0.00' name="montant">
                </div>
                <div class="field">
                    <label>Mot de passe : </label><input type="password" name="passwordTransfert" placeholder="mot de passe de virement" />
                </div>
                <input type="hidden" name="mytoken" value="<?php echo $mytoken; ?>">
                <button class="form-btn">Transférer</button>
                <?php
                if (isset($_REQUEST["err_token"])) {
                  echo '<p>Echec virement : le contrôle d\'intégrité a échoué.</p>';
                }else if (isset($_REQUEST["trf_ok"])) {
                    echo '<p>Virement effectué avec succès.</p>';
                } else if (isset($_REQUEST["bad_mt"])) {
                    echo '<p>Le montant saisi est incorrect : '.$_REQUEST["bad_mt"].'</p>';
                } else if (isset($_REQUEST["bad_pwd"])) {
                    echo '<p>Le mot de passe de virement n\'est pas correct</p>';
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
