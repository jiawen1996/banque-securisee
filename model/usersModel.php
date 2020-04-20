<?php
require_once('outils_model.php');
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
        // Récupérer hashedPwd depuis la BD
        $realHashedPwd = getHashedPwd($login, $mysqli);
        
        if (isset($realHashedPwd)) {
          
            //Si le mot de passe est correct, continuer à récupérer des infos de cet utilisateur
            if (password_verify($pwd, $realHashedPwd)) {
                $req="select nom,prenom,login,id_user,numero_compte,profil_user,solde_compte from users where login='$login'";
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
            } else {
                $utilisateur = false;
            }
        } else {
            $utilisateur = false;
        }
        $mysqli->close();
    }
  
    return $utilisateur;
  }
  

/**
 * Récupérer les informations d'utilisateur en sachant son id_user
 */
function findUserById($id) {
  $mysqli = getMySqliConnection();

  if ($mysqli->connect_error) {
      echo 'Erreur connection BDD (' . $mysqli->connect_errno . ') '. $mysqli->connect_error;
      $utilisateur = false;
  } else {
      $req="select nom,prenom,login, numero_compte,profil_user,solde_compte, id_user from users where id_user='$id' and profil_user='client'";
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

  
/**
 * Récupérer nom,prenom,login,id_user de tous les users
 */
  function findAllUsers() {
    $mysqli = getMySqliConnection();
  
    $listeUsers = array();
  
    if ($mysqli->connect_error) {
        echo 'Erreur connection BDD (' . $mysqli->connect_errno . ') '. $mysqli->connect_error;
    } else {
        $req="select nom,prenom,login,id_user,numero_compte  from users";
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


  /**
 * Récupérer les informations des clients
 */
  function findAllClients() {
    $mysqli = getMySqliConnection();
  
    $listeUsers = array();
  
    if ($mysqli->connect_error) {
        echo 'Erreur connection BDD (' . $mysqli->connect_errno . ') '. $mysqli->connect_error;
    } else {
        $req="select id_user, nom, prenom, login, numero_compte, solde_compte from users where profil_user='client'";
        if (!$result = $mysqli->query($req)) {
            echo 'Erreur requête BDD ['.$req.'] (' . $mysqli->errno . ') '. $mysqli->error;
        } else {
            while ($unUser = $result->fetch_assoc()) {
              $listeClients[$unUser['id_user']] = $unUser;
            }
            $result->free();
        }
        $mysqli->close();
    }
  
    return $listeClients;
  }

?>