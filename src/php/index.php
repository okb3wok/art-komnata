<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);


$url  =  $_SERVER["REQUEST_URI"];
$url = preg_replace("/^\//", "", $url);
$url = preg_replace("/\?(.*)$/", "", $url);
$url = preg_replace("/\/$/", "", $url);


include 'controller.php';


$routes = [
//    'o-nas',
    'gallery',
    'public-spaces-gallery',
    'cornices-and-moldings',
    'interior-paints-and-decorative-plasters',
    'wallpapers',
    'frescoes'
];

$controller = new Controller();


if($url=="") {  // in case Home Page
    $controller->index();
}else{ // Other pages

    preg_match("/^([a-z0-9-_]*)\/?([a-z0-9-_]*)$/i", $url, $matches);

    if(in_array($matches[1], $routes)){

        if($matches[1] == "wallpapers" || $matches[1] == "frescoes"  ){
            $controller->gallery_simple($matches[0]);
        }elseif ($matches[1] == "cornices-and-moldings" || $matches[1] == "interior-paints-and-decorative-plasters"){
            $controller->gallery_tagged($matches[1]);
        }elseif ($matches[1] == "gallery" || $matches[1] == "public-spaces-gallery"){
            if($matches[2]){
              $controller->gallery_simple($matches[0]);
            }else{
              $controller->gallery_nested($matches[0]);
            }
        }

    }else{
        $controller->not_found($url);
    }

}
