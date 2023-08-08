<?php
require_once 'functions.php';
$maj_d = date('d/m/Y');
$maj_h = date('H:i');
$url = "https://www.macrumors.com/";
$doc = new DOMDocument();
@$doc->loadHTML(cUrl($url));
$xpath = new DOMXPath($doc);
$xpathElement = "//div[contains(@id, 'maincontent')]//article[contains(@class, 'article--2pJwZBkO')]";
$element = $xpath->query("$xpathElement");
$title = $xpath->query("$xpathElement//h2[contains(@class, 'heading--1cooZo6n')]");
$link = $xpath->query("$xpathElement//h2[contains(@class, 'heading--1cooZo6n')]//a");
$time = $xpath->query("$xpathElement//time");
$category = $xpath->query("$xpathElement//div[contains(@class, 'linkback')]//a");
$img = $xpath->query("$xpathElement//div[contains(@class, 'js-contentInner')]//img[contains(@class, 'size-full') and substring(@src, string-length(@src) - 3)='.jpg']");$basic_information = array();
if($element->length > 0) {
    $basic_information[] = array(
        'error'=>false,
        'site'=>'MacRumors',
        'title'=> clean($title->item(0)->textContent),
        'alt_title'=> 'none',
        'text'=> 'none',
        'time'=> $time->item(0)->getAttribute('datetime'),
        'category'=> clean($category->item(0)->textContent),
        'url'=> $link->item(0)->getAttribute('href'),
        'img'=> $img->item(0)->getAttribute("src")
    );
}else{
    $basic_information[] = array('error'=>true);
}
$data = json_encode($basic_information);
echo $data;