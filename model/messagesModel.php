<?php
require_once('dbConnexion.php');
require_once('usersModel.php');

function findMessagesInbox($userid) {
    $mysqli = getMySqliConnection();
  
    $listeMessages = array();
  
    if ($mysqli->connect_error) {
        echo 'Erreur connection BDD (' . $mysqli->connect_errno . ') '. $mysqli->connect_error;
    } else {
        $req="SELECT id_msg,sujet_msg,corps_msg,u.nom,u.prenom FROM messages m, users u WHERE m.id_user_from=u.id_user AND id_user_to=?";
        $stmt = $mysqli->prepare($req);

        if  (!$stmt) {
            echo 'Erreur de préparation de requête BDD ['.$req.'] (' . $mysqli->errno . ') '. $mysqli->error;
        } else {
            $stmt->bind_param("i", $userid);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if($result->num_rows === 0) {
            $utilisateur = false;
            } else {
                while ($unMessage = $result->fetch_assoc()) {
                    $listeMessages[$unMessage['id_msg']] = $unMessage;
                  }
                  $result->free();
            }
            $stmt->close();
        }
        
        $mysqli->close();
    }
  
    return $listeMessages;
  }
  
  
  function addMessage($to,$from,$subject,$body) {

    //encode le texte encore une fois pour éviter le faille CSRF et XSS
      $subject_encode = htmlentities($subject, ENT_QUOTES);
      $body_encode = htmlentities($body, ENT_QUOTES);

      $mysqli = getMySqliConnection();
  
    if ($mysqli->connect_error) {
        echo 'Erreur connection BDD (' . $mysqli->connect_errno . ') '. $mysqli->connect_error;
    } else {
        $req="INSERT INTO MESSAGES(id_user_to,id_user_from,sujet_msg,corps_msg) VALUE (?,?,?,?)";
        $stmt = $mysqli->prepare($req);

        if  (!$stmt) {
            echo 'Erreur de préparation de requête BDD ['.$req.'] (' . $mysqli->errno . ') '. $mysqli->error;
        } else {
            $stmt->bind_param("iiss", $to, $from, $subject_encode, $body_encode);
            $stmt->execute();
            $stmt->close();
        }
        
        $mysqli->close();
    }
  
  }
  
  ?>
  