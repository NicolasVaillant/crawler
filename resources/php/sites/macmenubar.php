<?php
require_once 'functions.php';
$maj_d = date('d/m/Y');
$maj_h = date('H:i');
$url = "https://macmenubar.com/recently-added/";
$doc = new DOMDocument();
@$doc->loadHTML(cUrl($url));
$xpath = new DOMXPath($doc);
$xpathElement = "//*[contains(@id, 'archive-container')]//article[contains(@class, 'entry')]";
$element = $xpath->query("$xpathElement");
$title = $xpath->query("$xpathElement//h2[contains(@class, 'entry-title')]");
$link = $xpath->query("$xpathElement//h2[contains(@class, 'entry-title')]//a");
$category = $xpath->query("$xpathElement//div[contains(@class, 'category-links')]//a");
$img = $xpath->query("$xpathElement//img[contains(@class, 'resource__image')]");
$basic_information = array();
if($element->length > 0) {
    $basic_information[] = array(
        'error'=>false,
        'site'=>'macmenubar',
        'title'=> clean($title->item(0)->textContent),
        'alt_title'=> 'none',
        'text'=> 'none',
        'time'=> 'none',
        'category'=> clean($category->item(0)->textContent),
        'url'=> $link->item(0)->getAttribute('href'),
        'img'=> $img->item(0)->getAttribute("src")
    );
}else{
    $basic_information[] = array('error'=>true);
}
$data = json_encode($basic_information);
echo $data;