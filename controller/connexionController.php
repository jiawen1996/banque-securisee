<?php
  require_once('outils_controller.php');
  require_once('../model/usersModel.php');
  session_start();
  
  // URL de redirection par défaut (si pas d'action ou action non reconnue)
  $url_redirect = "../index.php";

  function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
  }
  
  
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

    // liste de clients à s'afficher dans ficheClient.php pour les employés
    if ($utilisateur["profil_user"] == "employe") {
      $_SESSION["listeClients"] = findAllClients();
    }
    $url_redirect = "../view/accueil.php";
    }
    
}
        
header("Location: $url_redirect");

?>