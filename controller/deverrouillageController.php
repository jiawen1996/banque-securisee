<?php
  require_once('../outil/outils_securite.php');
  require_once('../model/connection_errorsModel.php');
  session_start();
  timeout_session();
  
  // URL de redirection par défaut (si pas d'action ou action non reconnue)
  $url_redirect = "../index.php";

  function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
  }


/* ======== DÉVEROUILLER L'IP BLOQUÉ ======== */
if ( is_authentificated()) {
  //vérifier le rôle d'utilisateur
  if($_SESSION["connected_user"]["profil_user"] == "employe") {
    //éviter l'attaque CSRF
    if (isset($_REQUEST['mytoken']) || $_REQUEST['mytoken'] != $_SESSION['mytoken']) {
      if (isset($_REQUEST['id_connection'])) {
        $ip = getIP($_REQUEST['id_connection']);
        if ($ip == null) {
          $url_redirect = "../view/deverrouillage.php?unfoundConnection";
        } else {
          $unlock = unlockIP($ip);
          // Mise à jour la liste connections
          unset($_SESSION["listeConnectionError"]);
          $_SESSION["listeConnectionError"] = findAllErrorConnection();

          if ($unlock == false) {
            $url_redirect = "../view/deverrouillage.php?unlock_fail";
          }
          if ($unlock == true) {
            $url_redirect = "../view/deverrouillage.php?unlock_ok";
          }
        }
      } else {
        $url_redirect = "../view/erreur.php?unfoundConnection";
      }
    } else {
      $url_redirect = "../view/erreur.php?unfoundConnection";
    }
  } else {
    $url_redirect = "../view/erreur.php?unfoundConnection";

  }

} else {
  $url_redirect = "../index.php";
}    
header("Location: $url_redirect");

?>