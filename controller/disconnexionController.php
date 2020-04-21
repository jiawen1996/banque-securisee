<?php
  require_once('outils_controller.php');
  session_start();

  // URL de redirection par défaut (si pas d'action ou action non reconnue)
  $url_redirect = "../index.php";

  function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
    }

    /* ======== DISCONNECT ======== */
    try {
        unset($_SESSION["connected_user"]);
    } catch (Exception $e) {
        echo 'Disconnexion erreur: ',  $e->getMessage(), "\n";
    }
  
  header("Location: $url_redirect");

?>