<?php


header('Content-Type: application/json');


$postData = file_get_contents('php://input');
if($postData){

  $postArray = json_decode($postData, true);
  if(count($postArray['data'])>0){

    switch ($postArray["data"]["method"]) {
      case 'fetchTaggedGallery':

        $gallery_name = $postArray["data"]["gallery"];
        $photos_dir = "/var/www/art-komnata.ru/photos/" . $gallery_name;

        $jsonData = file_get_contents('../model-gallery-tagged.json');
        $dataArray = json_decode($jsonData, true);

        if (!isset($dataArray[$gallery_name])) {
          echo '{"result":0, "error":1, "status":"Запрашиваемой галереи не найдено."}';
          break;
        }

        $gallery = $dataArray[$gallery_name];

        if (!isset($gallery["content"])) {
          $gallery["content"] = [];
        }

        // список изображений из JSON
        $jsonImages = [];
        foreach ($gallery["content"] as $item) {
          $jsonImages[] = $item["img"];
        }

        // сканируем папку
        if (is_dir($photos_dir)) {

          $files = scandir($photos_dir);

          foreach ($files as $file) {

            if ($file == '.' || $file == '..') {
              continue;
            }

            // проверяем расширение
            if (!preg_match('/\.(jpg|jpeg|png|webp|gif)$/i', $file)) {
              continue;
            }

            // если нет в JSON — добавляем
            if (!in_array($file, $jsonImages)) {
              $gallery["content"][] = [
                "img" => $file,
                "tag" => 0
              ];
            }
          }
        }

        echo json_encode([
          "result" => 1,
          "error" => 0,
          "status" => "OK",
          "gallery" => $gallery
        ], JSON_UNESCAPED_UNICODE);

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

