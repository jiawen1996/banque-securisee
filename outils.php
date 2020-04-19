<?php

// FILTRER XSS
function inputFilteur($inputString){
return htmlentities($inputString, ENT_QUOTES) ;
}
?>