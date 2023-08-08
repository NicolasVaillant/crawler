<?php
require_once 'functions.php';
$maj_d = date('d/m/Y');
$maj_h = date('H:i');
$base = "https://sindresorhus.com";
$url = $base."/apps";
$doc = new DOMDocument();
@$doc->loadHTML(cUrl($url));
$xpath = new DOMXPath($doc);
$xpathElement = "//main//section[contains(@class, 'mx-auto')]//a[contains(@class, 'flex')]";
$element = $xpath->query($xpathElement);
$title = $xpath->query("$xpathElement//div[contains(@class, 'text-2xl')]");
$text = $xpath->query("$xpathElement//div[contains(@class, 'text-gray-700')]");
$category = $xpath->query("/$xpathElement//span[contains(@class, 'dark:bg-sky-200')]");
$img = $xpath->query("$xpathElement//img");
$basic_information = array();
if($element->length > 0) {
    $basic_information[] = array(
        'error'=>false,
        'site'=>'Sindre Sorhus',
        'title'=> clean($title->item(0)->textContent),
        'alt_title'=> 'none',
        'text'=> clean($text->item(0)->textContent),
        'time'=> 'none',
        'category'=> clean($category->item(0)->textContent),
        'url'=> $url.$element->item(0)->getAttribute('href'),
        'img'=> $base.$img->item(0)->getAttribute("src")
    );
}else{
    $basic_information[] = array('error'=>true);
}
$data = json_encode($basic_information);
echo $data;