<?php
$sitesPath = 'sites/*.php';
$results = array();
foreach (glob($sitesPath) as $file) {
    if (is_file($file)) {
        ob_start();
        require_once $file;
        $result = ob_get_clean();
        $results[basename($file, ".php")] = $result;
    }
}

$json = json_encode($results);
echo $json;