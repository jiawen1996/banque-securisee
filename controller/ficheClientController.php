<?php
  require_once('../outil/outils_securite.php');
  require_once('../model/usersModel.php');
  session_start();
  
  // URL de redirection par défaut (si pas d'action ou action non reconnue)
  $url_redirect = "../index.php";

  function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
  }
  
  
/* ======== GET CLIENT'S INFORMATIONS ======== */
    $utilisateur = findUserById($_REQUEST['id_client']);
    
    if ($utilisateur == false) {
        $url_redirect = "../view/ficheClient.php?badvalue";
    } else {
        $_SESSION["chosen_user"] = $utilisateur;
        $url_redirect = "../view/ficheClient.php?userfound";
    }

    header("Location: $url_redirect");
        
?>