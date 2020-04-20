<?php
require_once('../model/myModel.php');
require_once('../outils_controller.php');
session_start();

function isDestEmploye($idDest) {
    $profilDest = $_SESSION["listeUsers"][$idDest]['profil_user'];
    return ($profilDest == 'employe' ?  true :  false);
}
// URL de redirection par défaut (si pas d'action ou action non reconnue)
$url_redirect = "../index.php";
if (isset($_REQUEST['action'])) {
    if ($_REQUEST['action'] == 'sendmsg') {
        /* ======== MESSAGE ======== */
        //Si l'utilisateur est un employé  -> ok
        //Sinon -> si la destination est un employé -> ok
        if ($_SESSION["profil_user"] == 'employe' || isDestEmploye($_REQUEST['to'])) {
            addMessage($_REQUEST['to'],$_SESSION["connected_user"]["id_user"],inputFilteur($_REQUEST['sujet']), inputFilteur($_REQUEST['corps']));
            $url_redirect = "../view/vw_messagerie.php?msg_ok";
        } else {
            $url_redirect = "../view/vw_messagerie.php?msg_fail";
        }
    } else if ($_REQUEST['action'] == 'msglist') {
        /* ======== MESSAGE ======== */
        $_SESSION['messagesRecus'] = findMessagesInbox($_REQUEST["userid"]);
        $url_redirect = "../view/vw_messagerie_recu.php";

    }
}

header("Location: $url_redirect");
?>