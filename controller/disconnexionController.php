<?php
  require_once('../outil/outils_securite.php');
  session_start();
  timeout_session();

  // URL de redirection par défaut (si pas d'action ou action non reconnue)
  $url_redirect = "../index.php";

  function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
    }

    /* ======== DISCONNECT ======== */
    if ( is_authentificated()) {
      try {
          unset($_SESSION["connected_user"]);
      } catch (Exception $e) {
          echo 'Disconnexion erreur: ',  $e->getMessage(), "\n";
      }
    }
  header("Location: $url_redirect");

?>