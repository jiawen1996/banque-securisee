<?php
require_once('dbConnexion.php');

/**
 * Si le client échoue à l'authentification, il va inserer une ligne dans la table de connection_errors
 */
function addTentative ($ip, $login, $device) {
    $mysqli = getMySqliConnection();
    if ($mysqli->connect_error) {
        $re ='Erreur connection BDD (' . $mysqli->connect_errno . ') '. $mysqli->connect_error;
        trigger_error('Erreur connection BDD (' . $mysqli->connect_errno . ') '. $mysqli->connect_error, E_USER_ERROR);
        return false;
    } else {
        try{
            $req = "insert into connection_errors(ip,error_date,login, device) values(?,CURTIME(),?,?)";
            $stmt = $mysqli->prepare($req);
            $stmt->bind_param("sss", $ip, $login,$device);
            $stmt->execute();
            return true;
        } catch(Exception $e) {
            return false;
        }
        $stmt->close();
        $mysqli->close();
    }
    
    
    
}


/**
 * Compter le nombre de tentatives en fonction de l'adresse ip
 */
function ipIsBanned($ip) {
    $mysqli = getMySqliConnection();

    if ($mysqli->connect_error) {
        trigger_error('Erreur connection BDD (' . $mysqli->connect_errno . ') '. $mysqli->connect_error, E_USER_ERROR);
        return false;
    } else {
        $stmt = $mysqli->prepare("select count(*) as nb_tentatives from connection_errors where ip=?");
        $stmt->bind_param("s",  $ip);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();

        // cette IP a atteint le nombre maxi de 5 tentatives infructueuses
        if($count > 4) {
            return true; 
        } else {
            return false;
        }
        $mysqli->close();
    }
}

/**
 * Supprimer un IP pour le déverrouiller
 */
function unlockIP($ip) {
    $mysqli = getMySqliConnection();

    if ($mysqli->connect_error) {
        trigger_error('Erreur connection BDD (' . $mysqli->connect_errno . ') '. $mysqli->connect_error, E_USER_ERROR);
        return false;
    } else {
        $stmt = $mysqli->prepare("DELETE FROM connection_errors WHERE ip=?");
        $stmt->bind_param("s",  $ip);
        $stmt->execute();
        $stmt->close();        
    }
    $mysqli->close();
    return true;
}

/**
 * Récupérer l'IP en sachant id_connection
 */
function getIP($id) {
    $mysqli = getMySqliConnection();

    if ($mysqli->connect_error) {
        trigger_error('Erreur connection BDD (' . $mysqli->connect_errno . ') '. $mysqli->connect_error, E_USER_ERROR);
        $ip = null;
    } else {
        $stmt = $mysqli->prepare("SELECT ip FROM connection_errors WHERE id_connection=?");
        $stmt->bind_param("i",  $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows === 0) {
            $ip = null;
        } else {
            $ip = $result->fetch_assoc()['ip'];
            $result->free();
        }
        $stmt->close();
        $mysqli->close();
    }

    return $ip;
}



/**
 * Récupérer les connexions erronées
 */
function findAllErrorConnection() {
    $mysqli = getMySqliConnection();
  
    $listeConnectionError = array();
  
    if ($mysqli->connect_error) {
        echo 'Erreur connection BDD (' . $mysqli->connect_errno . ') '. $mysqli->connect_error;
    } else {
        $req="SELECT id_connection, ip, error_date, device, login FROM connection_errors";
        if (!$result = $mysqli->query($req)) {
            echo 'Erreur requête BDD ['.$req.'] (' . $mysqli->errno . ') '. $mysqli->error;
        } else {
            while ($uneConnexion = $result->fetch_assoc()) {
              $listeConnectionError[$uneConnexion['id_connection']] = $uneConnexion;
            }
            $result->free();
        }
        $mysqli->close();
    }
  
    return $listeConnectionError;
  }

?>