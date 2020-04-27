<?php
// interdire la lecture du cookie de session avec un script
  ini_set( 'session.cookie_httponly', 1 );
// interdire le cookie de session via l'URL (uniquement par cookie)
  ini_set('session.use_only_cookies', 1);
  session_start();
  
  if(!isset($_SESSION["connected_user"]) || $_SESSION["connected_user"] == "") {
      // utilisateur non connect�
      header('Location: view/connexion.php');      
  } else {
      header('Location: view/accueil.php');      
  }

?>