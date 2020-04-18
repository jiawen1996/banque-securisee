<?php
function inputFilteur($inputString){
return htmlentities($inputString, ENT_QUOTES) ;
}

function isAuthentificated() {
    return isset($_SESSION["connected_user"]) ? true : false;
}

function interdireSansLogin() {
    if (!isAuthentificated()) {
        header('Location: /banque-securisee/view/connexion.php');
    }
}
?>