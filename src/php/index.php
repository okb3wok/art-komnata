<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);


$url  =  $_SERVER["REQUEST_URI"];
$url = preg_replace("/^\//", "", $url);
$url = preg_replace("/\?(.*)$/", "", $url);
$url = preg_replace("/\/$/", "", $url);


include 'controller.php';

$jsonData = file_get_contents('./galleries_structure.json');
$galleriesStructure = json_decode($jsonData, true);


$controller = new Controller();


if($url=="") {  // in case Home Page
    $controller->index();
}else{ // Other pages

    preg_match("/^([a-z0-9-_]*)\/?([a-z0-9-_]*)$/i", $url, $matches);

    if(array_key_exists($matches[1], $galleriesStructure)){

        if($galleriesStructure[$matches[1]]['type'] == "simple" ){
            $controller->gallery_simple($matches[0]);
        }elseif ($galleriesStructure[$matches[1]]['type'] == "tagged"){
            $controller->gallery_tagged($matches[1]);
        }elseif ($galleriesStructure[$matches[1]]['type'] == "nested"){
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
