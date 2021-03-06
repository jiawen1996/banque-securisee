<?php

// FILTRER XSS
function input_filteur($inputString){
return htmlentities($inputString, ENT_QUOTES) ;
}

// VÉRIFIER SI L'UTILISATEUR S'EST CONNECTÉ
function is_authentificated() {
    return isset($_SESSION["connected_user"]) ? true : false;
}

// REDIRIGER VERS LA PAGE DE CONNEXION SI L'UTILISATEUR NE S'EST PAS CONNECTÉ
function interdire_sans_login() {
    if (!is_authentificated()) {
        header('Location: /banque-securisee/view/connexion.php');
    }
}

//générier un token et le mettre dans la session
function setToken() {
  $mytoken = bin2hex(random_bytes(128)); // token qui va servir à prévenir des attaques CSRF
  $_SESSION["mytoken"] = $mytoken;
  return $mytoken;
}

/*
* REDIRIGER VERS LA PAGE DE MESSAGE D'ERREUR 
* SI L'UTILISATEUR VEUX ACCÉDER AUX PAGES RÉSERVÉES POUR LES EMPLOYÉS
*/
function reserver_employe() {
    if (!is_authentificated()) {
        header('Location: /banque-securisee/view/connexion.php');
    } else {
        if ( $_SESSION["connected_user"]["profil_user"] != "employe" ) {
            // URL de redirection par défaut (si pas d'action ou action non reconnue)
            $url_redirect = "../view/erreur.php";
            header("Location: $url_redirect");
        }
    }
}

/*
* LORSQUE L'EMPLOYÉ RETOURNE DEPUIS LA PAGE VIREMENT D'UN CLIENT
* IL FAUT RAFRAICHIR SON SESSION EN SUPPRIMANT $_SESSION["chosen_user"]
*/
function delete_chosen_user() {
    if (isset($_SESSION["chosen_user"])) {
        unset($_SESSION["chosen_user"]);
    }
}

/**
 * ACTUALISER LA SESSION LORSQUE LE TEMP D'INACTIVITÉ SE DÉPASSE (15 minutes)
 * REDIGIRER VERS LA PAGE index.php
 */
function timeout_session() {
    $now = time();
    
    if (isset($_SESSION['discard_after']) && $now > $_SESSION['discard_after']) {
        // this session has worn out its welcome; kill it and start a brand new one
        session_unset();
        session_destroy();
        header("Location: ../index.php");
    }
}

?>