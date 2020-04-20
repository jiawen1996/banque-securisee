<?php
require_once('dbConnexion.php');

function verifierMdp() {

}

function transfert($dest, $src, $mt, $pwdTransfert) {
    $mysqli = getMySqliConnection();

    if ($mysqli->connect_error) {
        echo 'Erreur connection BDD (' . $mysqli->connect_errno . ') '. $mysqli->connect_error;
        $utilisateur = false;
    } else {
        $realHashedPwd = getHashedPwdTransfert($src, $mysqli);
        if (password_verify($pwdTransfert, $realHashedPwd)) {
            $req="update users set solde_compte=solde_compte+$mt where numero_compte='$dest'";
            if (!$result = $mysqli->query($req)) {
                echo 'Erreur requête BDD ['.$req.'] (' . $mysqli->errno . ') '. $mysqli->error;
            }
            $req="update users set solde_compte=solde_compte-$mt where numero_compte='$src'";
            if (!$result = $mysqli->query($req)) {
                echo 'Erreur requête BDD ['.$req.'] (' . $mysqli->errno . ') '. $mysqli->error;
            }
            //Le mot de passe de virement est correct
            $utilisateur = true;
        } else {
            $utilisateur = false;
        }
        $mysqli->close();
    }

    return $utilisateur;
}
?>
