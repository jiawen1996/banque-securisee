<?php

/*
* Récupérer hashedPwd depuis la BD qui est chiffré par password_hash
* en utilisant l'algo de PASSWORD_DEFAULT
*/
function getHashedPwd ($login, $mysqli) {
    $req="select mot_de_passe from users where login='$login'";
    if (!$result = $mysqli->query($req)) {
        echo 'Erreur requête BDD ['.$req.'] (' . $mysqli->errno . ') '. $mysqli->error;
        return $realHashedPwd = null;
    } else {
        $realHashedPwd = $result->fetch_assoc()['mot_de_passe'];
        return $realHashedPwd;
    }
}

/*
* Récupérer hashedPwd depuis la BD qui est chiffré par password_hash
* en utilisant l'algo de PASSWORD_DEFAULT
*/
function getHashedPwdTransfert ($numeroCompte, $mysqli) {
    $req="select mot_de_passe_virement from users where numero_compte='$numeroCompte'";
    if (!$result = $mysqli->query($req)) {
        echo 'Erreur requête BDD ['.$req.'] (' . $mysqli->errno . ') '. $mysqli->error;
        return $realHashedPwd = null;
    } else {
        $realHashedPwd = $result->fetch_assoc()['mot_de_passe_virement'];
        return $realHashedPwd;
    }
}

/*
* Récupérer hashedPwd depuis la BD qui est chiffré par password_hash
* en utilisant l'algo de PASSWORD_DEFAULT
*/

?>