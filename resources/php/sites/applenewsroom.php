<?php
require_once 'functions.php';
$maj_d = date('d/m/Y');
$maj_h = date('H:i');
$url = "https://www.apple.com/fr/newsroom/";
$doc = new DOMDocument();
@$doc->loadHTML(cUrl($url));
$xpath = new DOMXPath($doc);
$elements = $xpath->query("//*[contains(@class, 'everydayfeed')]//*[contains(@class, 'tile__headline')]");
$category= $xpath->query("//*[contains(@class, 'everydayfeed')]//*[contains(@class, 'tile__category')]");
$time = $xpath->query("//*[contains(@class, 'everydayfeed')]//*[contains(@class, 'tile__timestamp')]");
$aHref = $xpath->query("//*[contains(@class, 'tile-item')]//a");
$basic_information = array();
if($elements->length > 0) {
    foreach ($elements as $i => $element) {
        if ($i > 0) {break;}
        $href = $aHref->item($i)->getAttribute("href");
        $docInside = new DOMDocument();
        @$docInside->loadHTML(cUrl('https://www.apple.com/'.$href));
        $xpathInside = new DOMXPath($docInside);
        $headline = $xpathInside
            ->query("//*[contains(concat(' ', normalize-space(@class), ' '), 'hero-headline')]");
        if($headline->length === 0){
            $headline = $xpathInside
                ->query("//*[contains(concat(' ', normalize-space(@class), ' '), 'headersplitview__title')]");
        }
        $cover = $xpathInside
            ->query("//img");
        if ($cover->length > 0) {
            $src = $cover->item(0)->getAttribute("src");
        }else{
            $src = "https://www.apple.com/newsroom/images/apple-logo_black.jpg.landing-regular_2x.jpg";
        }
        if($headline->length > 0){
            $text = $headline->item(0)->textContent;
            $trimmed_text = preg_replace('/^\s+|\s+$/', '', $text); // remove leading and trailing whitespace
            $regex = '/\s+/';
            $final_text = preg_replace($regex, ' ', $trimmed_text); // replace multiple spaces with a single space
        }else{$final_text = "none";}
        $basic_information[] = array(
            'error'=>false,
            'site'=>'Apple',
            'title'=> clean($element->nodeValue),
            'alt_title'=> clean($final_text),
            'text'=> 'none',
            'time'=> $time->item($i)->textContent,
            'category'=> clean($category->item($i)->textContent),
            'url'=> 'https://www.apple.com/'.$href,
            'img'=> $src
        );
    }
    $basic_information[] = array(
        "maj_d"=> $maj_d,
        "maj_h"=> $maj_h,
    );
}else{
    $basic_information[] = array('error'=>true);
}
$data = json_encode($basic_information);
echo $data;