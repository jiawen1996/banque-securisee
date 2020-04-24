<?php
require_once('../model/messagesModel.php');
require_once('../outil/outils_securite.php');

session_start();
timeout_session();

function isDestEmploye($idDest) {
    $profilDest = $_SESSION["listeUsers"][$idDest]['profil_user'];
    return ($profilDest == 'employe' ?  true :  false);
}
// URL de redirection par défaut (si pas d'action ou action non reconnue)
$url_redirect = "../index.php";
if ( is_authentificated()) {
    if (isset($_REQUEST['action'])) {
        if ($_REQUEST['action'] == 'sendmsg') {

            /* ======== MESSAGE ======== */  
            if (addMessage($_REQUEST['to'],$_SESSION["connected_user"]["id_user"],input_filteur($_REQUEST['sujet']), input_filteur($_REQUEST['corps']))){
                $url_redirect = "../view/messagerie.php?msg_ok";
            } else {
                $url_redirect = "../view/messagerie.php?msg_fail";
            }
        } else if ($_REQUEST['action'] == 'msglist') {
            /* ======== MESSAGE ======== */
            $_SESSION['messagesRecus'] = findMessagesInbox($_REQUEST["userid"]);
            $url_redirect = "../view/messagerie_recu.php";
        }
    }
}

header("Location: $url_redirect");
?>