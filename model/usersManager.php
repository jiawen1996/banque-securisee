<?php

require_once('dbConnexion.php');

/**
 * Récupérer les informations d'utilisateur en sachant son login et son mot de passe
 */
function findUserByLoginPwd($login, $pwd) {
    $mysqli = getMySqliConnection();
  
    if ($mysqli->connect_error) {
        echo 'Erreur connection BDD (' . $mysqli->connect_errno . ') '. $mysqli->connect_error;
        $utilisateur = false;
    } else {
        $req="select nom,prenom,login,id_user,numero_compte,profil_user,solde_compte from users where login='$login' and mot_de_passe='$pwd'";
        if (!$result = $mysqli->query($req)) {
            echo 'Erreur requête BDD ['.$req.'] (' . $mysqli->errno . ') '. $mysqli->error;
            $utilisateur = false;
        } else {
            if ($result->num_rows === 0) {
  
              $utilisateur = false;
            } else {
              $utilisateur = $result->fetch_assoc();
            }
            $result->free();
        }
        $mysqli->close();
    }
  
    return $utilisateur;
  }
  
  
  function findAllUsers() {
    $mysqli = getMySqliConnection();
  
    $listeUsers = array();
  
    if ($mysqli->connect_error) {
        echo 'Erreur connection BDD (' . $mysqli->connect_errno . ') '. $mysqli->connect_error;
    } else {
        $req="select nom,prenom,login,id_user from users";
        if (!$result = $mysqli->query($req)) {
            echo 'Erreur requête BDD ['.$req.'] (' . $mysqli->errno . ') '. $mysqli->error;
        } else {
            while ($unUser = $result->fetch_assoc()) {
              $listeUsers[$unUser['id_user']] = $unUser;
            }
            $result->free();
        }
        $mysqli->close();
    }
  
    return $listeUsers;
  }

?>