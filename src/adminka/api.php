<?php


header('Content-Type: application/json');


$postData = file_get_contents('php://input');
if($postData){

  $postArray = json_decode($postData, true);
  if(count($postArray['data'])>0){

    switch ($postArray["data"]["method"]) {
      case 'fetchTaggedGallery':

        $gallery_name = $postArray["data"]["gallery"];

        $jsonData = file_get_contents('../model-gallery-tagged.json');
        $dataArray = json_decode($jsonData, true);

        $gallery = $dataArray[$gallery_name];

        if($gallery ){
          echo '{"result":1, "error":0, "status":"OK", "gallery":' . json_encode($gallery, JSON_UNESCAPED_UNICODE) . '}';
        }else{
          echo '{"result":0, "error":1, "status":"Запрашиваемой галереи не найдено."}';
        }

        break;

      case 'updateTaggedGallery':

        $gallery_name = $postArray["data"]["gallery"];
        $gallery_new = $postArray["data"]["content"];

        $jsonData = file_get_contents('../model-gallery-tagged.json');
        $dataArray = json_decode($jsonData, true);
        $dataArray[$gallery_name] = $gallery_new;
        $result = file_put_contents( '../model-gallery-tagged.json', json_encode($dataArray, JSON_UNESCAPED_UNICODE) );

        if($result){
          echo '{"result":1, "error":0, "status":"OK", "gallery":' . json_encode($dataArray, JSON_UNESCAPED_UNICODE) . '}';
        }else{
          echo '{"result":0, "error":1, "status":"Ошибка записи"}';
        }
        break;

      default:
        echo '{"result":0,"error":1,"status":"Wrong request"}';
    }

  }else{
    header("HTTP/1.1 404");
    echo '{"result":0,"error":1,"status":"The POST method is not supported for this route"}';
  }

}else{
  header("HTTP/1.1 404");
  echo '{"result":0,"error":1,"status":"The GET method is not supported for this route"}';
}

