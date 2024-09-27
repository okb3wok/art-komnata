<?php

require '/var/www/art-komnata.ru/vendor/autoload.php';

class Controller{

    private $templates_path = '/var/www/art-komnata.ru/templates/';
    private $compilation_cache_path = '/var/www/art-komnata.ru/compilation_cache/';

    private function render($template, $data = []){
        $twig_loader = new \Twig\Loader\FilesystemLoader($this->templates_path);
        $twig = new \Twig\Environment($twig_loader, ['cache' => $this->compilation_cache_path, 'auto_reload' => true ]);
        echo $twig->render($template, $data);
    }

    public function index()
    {
      $settingsData = file_get_contents('./main-settings.json');
      $settingsArray = json_decode($settingsData, true);

      $pageDescription = $settingsArray['desc'];
      $pageTitle = $settingsArray['title'];

      $this->render('art.twig', ['pageTitle' => $pageTitle, 'pageDescription' => $pageDescription]);

    }

    public function gallery_simple($name)
    {

        // get data from model
        $jsonData = file_get_contents('./model-gallery-simple.json');
        $dataArray = json_decode($jsonData, true);

        if($dataArray[$name]){
          $title = $dataArray[$name]['title'];
          $pageDescription = $dataArray[$name]['desc'];

          $settingsData = file_get_contents('./main-settings.json');
          $settingsArray = json_decode($settingsData, true);

          $pageTitle = $dataArray[$name]['title'] . ' - ' . $settingsArray['sitename'];


          $files = glob('/var/www/art-komnata.ru/photos/'.$name.'/*.jpg');
          $gallery = [];
          foreach ($files as $file) {
            $gallery[] = [ 'photo' => $name.'/'.basename($file), 'thumb' => $name.'/thumbs/'.basename($file), 'name' => $title ];
          }

          $this->render('gallery_simple.twig', ['gallery' => $gallery, 'title' => $title, 'pageTitle' => $pageTitle, 'pageDescription' => $pageDescription]);

        }else{
          $this->not_found($name);
        }

}


    public function gallery_tagged($name){


      $jsonData = file_get_contents('./model-gallery-tagged.json');
      $dataArray = json_decode($jsonData, true);


      if($dataArray[$name]){
        $title = $dataArray[$name]['title'];
        $pageDescription = $dataArray[$name]['desc'];

        $settingsData = file_get_contents('./main-settings.json');
        $settingsArray = json_decode($settingsData, true);

        $pageTitle = $dataArray[$name]['title'] . ' - ' . $settingsArray['sitename'];

        $tags=$dataArray[$name]['tags'];

        $gallery = [];
        foreach ($dataArray[$name]['content'] as $item) {
          $gallery[] = [ 'photo' => $name.'/'.$item['img'], 'thumb' => $name.'/thumbs/'.$item['img'], 'tag' => $tags[$item['tag']]['slug'], 'name' => $tags[$item['tag']]['name'] ];
        }

        $this->render('gallery_tagged.twig', [
          'tags' => $tags,
          'gallery' => $gallery,
          'title' => $title,
          'pageTitle' => $pageTitle,
          'pageDescription' => $pageDescription]);
      }else{
        $this->not_found($name);
      }

    }


    public function gallery_nested($name){

      $jsonData = file_get_contents('./model-gallery-nested.json');
      $dataArray = json_decode($jsonData, true);

      $title = $dataArray[$name]['title'];
      $pageDescription = $dataArray[$name]['desc'];

      $settingsData = file_get_contents('./main-settings.json');
      $settingsArray = json_decode($settingsData, true);

      $pageTitle = $dataArray[$name]['title'] . ' - ' . $settingsArray['sitename'];

      $content = $dataArray[$name]['content'];
      $this->render('gallery_nested.twig', ['content'=>$content, 'title' => $title, 'pageTitle' => $pageTitle, 'pageDescription' => $pageDescription]);

    }

    public function not_found ($url)
    {
      $title = 'Страница не найдена';
      $pageDescription = 'Страница не найдена';

      $settingsData = file_get_contents('./main-settings.json');
      $settingsArray = json_decode($settingsData, true);
      $pageTitle = 'Страница не найдена - ' . $settingsArray['sitename'];

      header("HTTP/1.0 404 Not Found");
      $this->render('404.twig', ['content'=>$url, 'title' => $title, 'pageTitle' => $pageTitle, 'pageDescription' => $pageDescription]);
    }



}