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
if (ipIsBanned($_SERVER['REMOTE_ADDR'])){
    // cette IP est bloquée
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
      $rep = addTentative($_SERVER["REMOTE_ADDR"], $_REQUEST['login'], $deviceName);
      $_SESSION["rep"] = $rep;

      // Limiter le nombre de tentatives
      if (isset($_SESSION["tentatives"]) && $_SESSION["tentatives"] > 5) {
        $url_redirect = "../view/connexion.php?limitexceeded";
      } else {
        $url_redirect = "../view/connexion.php?badvalue";
      }
  } else {
      // authentification réussie
      $_SESSION["connected_user"] = $utilisateur;
      $_SESSION["listeUsers"] = findAllUsers();

      // liste de clients contenant tous les informations de client à s'afficher dans ficheClient.php pour les employés
      if ($utilisateur["profil_user"] == "employe") {
          $_SESSION["listeClients"] = findAllClients();
          $_SESSION["listeBlockedUsers"] = findAllErrorConnection();
      }
      $url_redirect = "../view/accueil.php";
  }
}

header("Location: $url_redirect");

?>