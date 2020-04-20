<?php

// FILTRER XSS
function inputFilteur($inputString){
return htmlentities($inputString, ENT_QUOTES) ;
}

// VÉRIFIER SI L'UTILISATEUR S'EST CONNECTÉ
function isAuthentificated() {
    return isset($_SESSION["connected_user"]) ? true : false;
}

// REDIRIGER VERS LA PAGE DE CONNEXION SI L'UTILISATEUR NE S'EST PAS CONNECTÉ
function interdireSansLogin() {
    if (!isAuthentificated()) {
        header('Location: /banque-securisee/view/connexion.php');
    }
}

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


/*
* REDIRIGER VERS LA PAGE DE MESSAGE D'ERREUR 
* SI L'UTILISATEUR VEUX ACCÉDER AUX PAGES RÉSERVÉES POUR LES EMPLOYÉS
*/
function reserverEmploye() {
    if (!isAuthentificated()) {
        header('Location: /banque-securisee/view/connexion.php');
    } else {
        if ( $_SESSION["connected_user"]["profil_user"] != "employe" ) {
            // URL de redirection par défaut (si pas d'action ou action non reconnue)
            $url_redirect = "../view/reserve.php";
            header("Location: $url_redirect");
        }
    }
}

/*
* LORSQUE L'EMPLOYÉ RETOURNE DEPUIS LA PAGE VIREMENT D'UN CLIENT
* IL FAUT RAFRAICHIR SON SESSION EN SUPPRIMANT $_SESSION["chosen_user"]
*/
function deleteChosenUser() {
    if (isset($_SESSION["chosen_user"])) {
        print_r($_SESSION["chosen_user"]);
        unset($_SESSION["chosen_user"]);
        echo 'supprimer chosen_user';
        print_r($_SESSION["chosen_user"]);
    }
}

?>