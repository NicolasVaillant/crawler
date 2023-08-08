<?php
require_once 'functions.php';
$maj_d = date('d/m/Y');
$maj_h = date('H:i');
$url = "https://www.raycast.com/changelog";
$doc = new DOMDocument();
@$doc->loadHTML(cUrl($url));
$xpath = new DOMXPath($doc);
$xpathElement = "//article";
$element = $xpath->query("$xpathElement");
$version = $xpath->query("$xpathElement//span[@id]");
$title = $xpath->query("$xpathElement//h2");
$text = $xpath->query("$xpathElement//div[contains(@class, 'ChangelogEntry_changelogBody__lqlZ5')]//p[not(descendant::img)]");
$link = $xpath->query("$xpathElement//a[contains(@class, 'Pill_pill__mhK_q Pill_button__44Ljp')]");
$img = $xpath->query("$xpathElement//img");
$time = $xpath->query("$xpathElement//span[contains(@class, 'ChangelogEntry_changelogDate__2gIE5')]");
$basic_information = array();
if($element->length > 0) {
    $basic_information[] = array(
        'error'=>false,
        'site'=>'Raycast',
        'title'=> clean($title->item(0)->textContent),
        'alt_title'=> clean($version->item(0)->textContent),
        'text'=> clean($text->item(0)->textContent),
        'time'=> clean($time->item(0)->textContent),
        'category'=> 'none',
        'url'=> $link->item(0)->getAttribute('href'),
        'img'=> $img->item(0)->getAttribute("src")
    );
}else{
    $basic_information[] = array('error'=>true);
}
$data = json_encode($basic_information);
echo $data;