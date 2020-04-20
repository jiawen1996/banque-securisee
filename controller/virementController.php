<?php
require_once('../model/virementModel.php');
require_once('../outils_securite.php');
session_start();

function isConnectedUser () {

}
// URL de redirection par défaut (si pas d'action ou action non reconnue)
$url_redirect = "../index.php";

/* ======== TRANSFERT ======== */
if ( isAuthentificated()) {
    if (is_numeric ($_REQUEST['montant'])) {

        /*
        * Si la page virement est ouvert à l'aide du lien de virement dans la page fiche client
        * il signifie qu'il y a un client sélenctioné dans la session et on le met en tant que le compte de source.
        * Sinon, on met le numéro de compte de l'utilisateur connecté à la place du numéro compte de source 
        */
        if (!isset($_SESSION["chosen_user"])){
            $src = &$_SESSION["connected_user"];
        } else {
            $src = &$_SESSION["chosen_user"];
        }
        if(!transfert($_REQUEST['destination'],$src["numero_compte"], $_REQUEST['montant'], $_REQUEST['passwordTransfert'])) {
            $url_redirect = "../view/vw_virement.php?bad_pwd";
        } else {
            $src["solde_compte"] = $src["solde_compte"] -  $_REQUEST['montant'];
            $url_redirect = "../view/vw_virement.php?trf_ok";
        }
        unset($src);

    } else {
        $url_redirect = "../view/vw_virement.php?bad_mt=".$_REQUEST['montant'];
    }
}

header("Location: $url_redirect");
?>