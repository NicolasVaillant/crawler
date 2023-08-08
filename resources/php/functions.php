<?php
function cUrl(string $input_url): string
{
    $ch = curl_init($input_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function clean($string): string
{
    return trim($string);
}