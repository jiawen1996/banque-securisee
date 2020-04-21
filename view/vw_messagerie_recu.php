<?php
  session_start();
require_once('../controller/outils_controller.php');
interdireSansLogin();
?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Messages</title>
  <link rel="stylesheet" type="text/css" media="all"  href="/sr03/public/css/mystyle.css" />
</head>
<body>

  <main>
    <article>
      <div class="liste">
        <h3><?php echo $_SESSION["connected_user"]["prenom"];?> <?php echo $_SESSION["connected_user"]["nom"];?> - Messages reçus</h3>
        <table>
          <?php
          foreach ($_SESSION['messagesRecus'] as $cle => $message) {
            echo '<tr>';
            echo '<td>'.$message['nom'].' '.$message['prenom'].'</td>';
            echo '<td>'.$message['sujet_msg'].'</td>';
            echo '<td>'.$message['corps_msg'].'</td>';
            echo '</tr>';
          }
           ?>
        </table>
      </div>

    </article>
  </main>
</body>
</html>
