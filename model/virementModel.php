<?php
require_once('dbConnexion.php');
require_once('usersModel.php');

function verifierMdp() {

}


/**
 * Effectuer un virement 
 * Vérifier le mot de passe de virement du réalisateur
 * Augmenter le montant dans le compte de destinataire
 * Diminuer le montant dans le compte d'expéditeur
 */
function transfert($dest, $src, $mt, $pwdTransfert, $realisateur) {
    $mysqli = getMySqliConnection();

    if ($mysqli->connect_error) {
        echo 'Erreur connection BDD (' . $mysqli->connect_errno . ') '. $mysqli->connect_error;
        $trf_ok = false;
    } else {
        $realHashedPwd = getHashedPwdTransfert($realisateur, $mysqli);

        if (password_verify($pwdTransfert, $realHashedPwd)) {
            //Le mot de passe de virement est correct
            $trf_ok = true;

            // Virement au compte du destinataire
            $req="UPDATE users SET solde_compte=solde_compte+? WHERE numero_compte=?";
            $stmt = $mysqli->prepare($req);

            if  (!$stmt) {
                echo 'Erreur de préparation de requête BDD ['.$req.'] (' . $mysqli->errno . ') '. $mysqli->error;
                $trf_ok = false;
            } else {
                $stmt->bind_param("is", $mt, $dest);
                $stmt->execute();
                $stmt->close();
            }

            // Retirement du compte du source
            $req="UPDATE users SET solde_compte=solde_compte-? WHERE numero_compte=?";
            $stmt = $mysqli->prepare($req);

            if  (!$stmt) {
                echo 'Erreur de préparation de requête BDD ['.$req.'] (' . $mysqli->errno . ') '. $mysqli->error;
                $trf_ok = false;
            } else {
                $stmt->bind_param("is", $mt, $src);
                $stmt->execute();
                $stmt->close();
            }
        } else {
            $trf_ok = false;
        }
        $mysqli->close();
    }

    return $trf_ok;
}
?>
