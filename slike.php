<?php
// Ovaj kod popravlja vezu za slike
$target = __DIR__ . '/../storage/app/public';
$shortcut = __DIR__ . '/storage';

// 1. Brisanje stare neispravne veze
if(file_exists($shortcut)) {
    unlink($shortcut);
    echo "Stara veza obrisana... <br>";
}

// 2. Kreiranje nove veze
if(symlink($target, $shortcut)) {
    echo "<h1>USPJEH! 🚀 Slike su popravljene.</h1>";
    echo "Vratite se u Admin panel i osvježite stranicu.";
} else {
    echo "Greška pri kreiranju linka.";
}
?>