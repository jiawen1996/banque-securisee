<?php
require_once('../model/myModel.php');
require_once('../outils_securite.php');
session_start();

function isConnectedUser () {

}
// URL de redirection par défaut (si pas d'action ou action non reconnue)
$url_redirect = "../index.php";
if (isset($_REQUEST['action']) && isset($_SESSION["connected_user"])) {
    if ($_REQUEST['action'] == 'transfert') {
        /* ======== TRANSFERT ======== */
        if (is_numeric ($_REQUEST['montant'])) {
            transfert($_REQUEST['destination'],$_SESSION["connected_user"]["numero_compte"], $_REQUEST['montant']);
            $_SESSION["connected_user"]["solde_compte"] = $_SESSION["connected_user"]["solde_compte"] -  $_REQUEST['montant'];
            $url_redirect = "../view/vw_virement.php?trf_ok";

        } else {
            $url_redirect = "../view/vw_virement.php?bad_mt=".$_REQUEST['montant'];
        }
    }
}

header("Location: $url_redirect");
?>