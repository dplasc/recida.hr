<?php
// Čišćenje predmemorije
echo "<h1>Čišćenje sustava...</h1>";

try {
    Artisan::call('optimize:clear');
    echo "<p>✅ Cache (Optimize) - OČIŠĆENO</p>";

    Artisan::call('config:clear');
    echo "<p>✅ Konfiguracija - OČIŠĆENA</p>";

    Artisan::call('view:clear');
    echo "<p>✅ Dizajn (View) - OČIŠĆEN</p>";

    echo "<h2>Sve je osvježeno! Probajte sada dodati oglas.</h2>";
} catch (Exception $e) {
    // Fallback ako Artisan klasa nije učitana (direktno brisanje fajlova)
    $files = glob(__DIR__ . '/../bootstrap/cache/*.php');
    foreach($files as $file){
        if(is_file($file)) unlink($file);
    }
    echo "<p>⚠️ Prisilno brisanje cache datoteka izvršeno.</p>";
}
?>