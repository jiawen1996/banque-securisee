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
        // Récupérer hashedPwd depuis la BD
        $realHashedPwd = getHashedPwd($login, $mysqli);
        
        if (isset($realHashedPwd)) {
          
            //Si le mot de passe est correct, continuer à récupérer des infos de cet utilisateur
          if (password_verify($pwd, $realHashedPwd)) {
            $req = "SELECT nom,prenom,login,id_user,numero_compte,profil_user,solde_compte FROM users WHERE login= ?";
            $stmt = $mysqli->prepare($req);

            if  (!$stmt) {
              echo 'Erreur de préparation de requête BDD ['.$req.'] (' . $mysqli->errno . ') '. $mysqli->error;
              $utilisateur = false;
            } else {
              $stmt->bind_param("s", $login);
              $stmt->execute();
              $result = $stmt->get_result();
              
              if($result->num_rows === 0) {
                $utilisateur = false;
              } else {
                $utilisateur = $result->fetch_assoc();
                $result->free();
              }

              $stmt->close();
            }
            
          } 
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
      $req="SELECT nom,prenom,login, numero_compte,profil_user,solde_compte, id_user FROM users WHERE id_user= ? AND profil_user='client'";
      $stmt = $mysqli->prepare($req);

      if  (!$stmt) {
        echo 'Erreur de préparation de requête BDD ['.$req.'] (' . $mysqli->errno . ') '. $mysqli->error;
        $utilisateur = false;
      } else {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows === 0) {
          $utilisateur = false;
        } else {
          $utilisateur = $result->fetch_assoc();
          $result->free();
        }
        $stmt->close();
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
        $req="SELECT nom,prenom,login,id_user,numero_compte FROM users";
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
        $req="SELECT id_user, nom, prenom, login, numero_compte, solde_compte FROM users WHERE profil_user='client'";
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

/*
* Récupérer hashedPwd de colonne mot_de_passe depuis la BD qui est chiffré par password_hash
* en utilisant l'algo de PASSWORD_DEFAULT
*/
function getHashedPwd ($login, $mysqli) {
  $realHashedPwd = null;
  $req="SELECT mot_de_passe FROM users WHERE login=?";
  $stmt = $mysqli->prepare($req);

  if  (!$stmt) {
      echo 'Erreur de préparation de requête BDD ['.$req.'] (' . $mysqli->errno . ') '. $mysqli->error;
  } else {
      $stmt->bind_param("s", $login);
      $stmt->execute();
      $result = $stmt->get_result();
      
      if($result->num_rows != 0) {
          $realHashedPwd = $result->fetch_assoc()['mot_de_passe'];
          $result->free();
      }
      $stmt->close();
  }
  
  return $realHashedPwd;
}


/*
* Récupérer hashedPwd de colonne mot_de_passe_virement depuis la BD qui est chiffré par password_hash
* en utilisant l'algo de PASSWORD_DEFAULT
*/
function getHashedPwdTransfert ($numeroCompte, $mysqli) {
  $realHashedPwd = null;
  $req="SELECT mot_de_passe_virement FROM users WHERE numero_compte=?";
  $stmt = $mysqli->prepare($req);

  if  (!$stmt) {
      echo 'Erreur de préparation de requête BDD ['.$req.'] (' . $mysqli->errno . ') '. $mysqli->error;
  } else {
      $stmt->bind_param("s", $numeroCompte);
      $stmt->execute();
      $result = $stmt->get_result();
      
      if($result->num_rows != 0) {
          $realHashedPwd = $result->fetch_assoc()['mot_de_passe_virement'];
          $result->free();
      }
      $stmt->close();
  }
  
  return $realHashedPwd;
}


?>