<?php
  require_once('../outil/outils_securite.php');
  require_once('../model/usersModel.php');
  require_once('../model/connection_errorsModel.php');
  session_start();

  
  // URL de redirection par défaut (si pas d'action ou action non reconnue)
  $url_redirect = "../index.php";

  function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
  }


/* ======== AUTHENT ======== */
//éviter l'attaque CSRF
if (isset($_REQUEST['mytoken']) || $_REQUEST['mytoken'] != $_SESSION['mytoken']) {
  if (ipIsBanned($_SERVER['REMOTE_ADDR'])) {
    // cette IP est bloquée, blocque le bouton login
    $_SESSION['tentatives'] = 5;
    $url_redirect = "../view/connexion.php?limitexceeded";
  } else if (!isset($_REQUEST['login']) || !isset($_REQUEST['mdp']) || $_REQUEST['login'] == "" || $_REQUEST['mdp'] == "") {
    // manque login ou mot de passe
    $url_redirect = "../view/connexion.php?nullvalue";
  } else {
    //vérifier l'autentification
    $utilisateur = findUserByLoginPwd($_REQUEST['login'], $_REQUEST['mdp']);

    // L'authentification échoue
    if ($utilisateur == false) {
      // Augmenter de nbre de tentative
      if (!isset($_SESSION["tentatives"])) {
        $_SESSION["tentatives"] = 0;
      }

      //Augmenter le nombre de tentatives dans la session
      $_SESSION["tentatives"] = $_SESSION["tentatives"] + 1;
      $deviceName = $_SERVER["HTTP_USER_AGENT"];
      //Augmenter le nombre de tentatives dans la base de donnée
      addTentative($_SERVER["REMOTE_ADDR"], $_REQUEST['login'], $deviceName);

      // Limiter le nombre de tentatives
      if (isset($_SESSION["tentatives"]) && $_SESSION["tentatives"] >= 5) {
        $url_redirect = "../view/connexion.php?limitexceeded";
      } else {
        $url_redirect = "../view/connexion.php?badvalue";
      }
    } else {
      // authentification réussie
      $_SESSION["connected_user"] = $utilisateur;
      $_SESSION["listeUsers"] = findAllUsers();

      /**
       * liste de clients contenant tous les informations de client à s'afficher dans ficheClient.php pour les employés
       * listeConnectionError contient les informations de connection échouée à s'afficher dans deverrouillage.php
       */
      if ($utilisateur["profil_user"] == "employe") {
        $_SESSION["listeClients"] = findAllClients();
        $_SESSION["listeConnectionError"] = findAllErrorConnection();
      }
      $url_redirect = "../view/accueil.php";
    }
  }
}

header("Location: $url_redirect");

?>