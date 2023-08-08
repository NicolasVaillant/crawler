<?php
require_once 'functions.php';
$maj_d = date('d/m/Y');
$maj_h = date('H:i');
$url = "https://www.allout.space/";
$doc = new DOMDocument();
@$doc->loadHTML(cUrl($url));
$xpath = new DOMXPath($doc);
$xpathElement = "//div[contains(@class, 'elementor-widget-container')]//div[contains(@class, 'elementor-posts-container')]//div[contains(@class, 'elementor-post__card')]";
$element = $xpath->query("$xpathElement");
$title = $xpath->query("$xpathElement//h3[contains(@class, 'elementor-post__title')]");
$text = $xpath->query("$xpathElement//div[contains(@class, 'elementor-post__excerpt')]//p");
$link = $xpath->query("$xpathElement//a[contains(@class, 'elementor-post__thumbnail__link')]");
$img = $xpath->query("$xpathElement//div[contains(@class, 'elementor-post__thumbnail')]//img");
$time = $xpath->query("$xpathElement//span[contains(@class, 'elementor-post-date')]");
$basic_information = array();
if($element->length > 0) {
    $basic_information[] = array(
        'error'=>false,
        'site'=>'Allout',
        'title'=> clean($title->item(0)->textContent),
        'alt_title'=> 'none',
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