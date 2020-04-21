<?php
  require_once('../model/myModel.php');
  require_once('outils_controller.php');
  session_start();
  
  // URL de redirection par défaut (si pas d'action ou action non reconnue)
  $url_redirect = "../index.php";

  function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
  }
  
  if (isset($_REQUEST['action'])) {
  
      if ($_REQUEST['action'] == 'authenticate') {
          /* ======== AUTHENT ======== */
          if (!isset($_REQUEST['login']) || !isset($_REQUEST['mdp']) || $_REQUEST['login'] == "" || $_REQUEST['mdp'] == "") {
              // manque login ou mot de passe
              $url_redirect = "../view/connexion.php?nullvalue";
              
          } else {
          
              $utilisateur = findUserByLoginPwd($_REQUEST['login'], $_REQUEST['mdp']);
              
              if ($utilisateur == false) {
                // echec authentification
                $url_redirect = "../view/connexion.php?badvalue";
                
              } else {
                // authentification réussie
                $_SESSION["connected_user"] = $utilisateur;
                $_SESSION["listeUsers"] = findAllUsers();
                $url_redirect = "../view/accueil.php";
              }
          }
          
      } else if ($_REQUEST['action'] == 'disconnect') {
          /* ======== DISCONNECT ======== */
          unset($_SESSION["connected_user"]);
          $url_redirect = $_REQUEST['loginPage'] ;
          
      }
  }
  
  header("Location: $url_redirect");

?>
