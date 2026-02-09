<?php
// Definiramo putanje
$target = $_SERVER['DOCUMENT_ROOT'] . '/storage/app/public';
$link = $_SERVER['DOCUMENT_ROOT'] . '/public/storage';

// Brišemo stari link ako postoji (da ne smeta)
if(file_exists($link)) {
    unlink($link);
}

// Kreiramo novi ispravan link
if(symlink($target, $link)) {
    echo "<h1>USPJEH! 🚀</h1>";
    echo "Vrata su otključana. Slike će sada raditi.";
} else {
    echo "<h1>Greška...</h1>";
    echo "Nismo uspjeli. Probajte kontaktirati podršku.";
}
?>