<?php
  session_start();
  
  if(!isset($_SESSION["connected_user"]) || $_SESSION["connected_user"] == "") {
      // utilisateur non connect�
      header('Location: vw_login.php');      
  } else {
      header('Location: vw_moncompte.php');      
  }

?>