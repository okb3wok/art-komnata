<?php

require '/var/www/html/vendor/autoload.php';

class Controller{

    private $templates_path = '/var/www/html/templates/';
    private $compilation_cache_path = '/var/www/html/compilation_cache/';

    private function render($template, $data = []){
        $twig_loader = new \Twig\Loader\FilesystemLoader($this->templates_path);
        $twig = new \Twig\Environment($twig_loader, ['cache' => $this->compilation_cache_path, 'auto_reload' => true ]);
        echo $twig->render($template, $data);
    }

    public function index()
    {
        $this->render('art.twig', ['pageTitle' => 'АртКомната']);
    }

    public function gallery_simple($name, $title='', $pageTitle='', $pageDescription='')
    {

        $files = glob('/var/www/html/photos/'.$name.'/*.jpg');
        $gallery = [];
        foreach ($files as $file) {
            $gallery[] = [ 'photo' => $name.'/'.basename($file), 'thumb' => $name.'/thumbs/'.basename($file), 'name' => 'name' ];
        }

        if($name=="wallpapers" ){
            $title = 'Интерьерные обои';
            $pageTitle = 'Интерьерные обои - АртКомната';
            $pageDescription = 'Некоторые интерьерные представленные в нашем магазине в Курске';
        }elseif ($name=="frescoes" ){
            $title = 'Интерьерные фрески';
            $pageTitle = 'Интерьерные фрески - АртКомната';
            $pageDescription = 'Интерьерные фрески';
        }
        $this->render('gallery_simple.twig', ['gallery' => $gallery, 'title' => $title, 'pageTitle' => $pageTitle, 'pageDescription' => $pageDescription]);
    }


    public function gallery_tagged($name){
        if($name=="interior-paints-and-decorative-plasters" ){
            $gallery = [];
            for ($i = 1; $i < 6; $i++) {
                $gallery[] = [ 'photo' => $name.'/'.$i.'.jpg', 'thumb' => $name.'/thumbs/'.$i.'.jpg', 'tag' => 'plasters', 'name' => 'Штукатурки' ];
            }
            for ($i = 6; $i < 104; $i++) {
                $gallery[] = [ 'photo' => $name.'/'.$i.'.jpg', 'thumb' => $name.'/thumbs/'.$i.'.jpg', 'tag' => 'paints', 'name' => 'Краски' ];
            }
            $title = 'Интерьерные краски и декоративные штукатурки';
            $pageTitle = 'Интерьерные краски и декоративные штукатурки - АртКомната';
            $pageDescription = 'Интерьерные краски и декоративные штукатурки';
            $this->render('gallery_tagged.twig', [
                'tags' => [['eng'=>'paints', 'ru'=>'Краски'], ['eng'=>'plasters', 'ru'=>'Штукатурки']],
                'gallery' => $gallery,
                'title' => $title,
                'pageTitle' => $pageTitle,
                'pageDescription' => $pageDescription]);
        }elseif($name=="cornices-and-moldings" ){

            $gallery = [];
            for ($i = 1; $i < 14; $i++) {

                $tag = 'cornices';
                $tag_name = 'Карнизы';

                if($i==2 || $i==4 || $i==5 || $i==7 || $i==11){
                    $tag = 'moldings';
                    $tag_name = 'Молдинги';
                }

                $gallery[] = [ 'photo' => $name.'/'.$i.'.jpg', 'thumb' => $name.'/thumbs/'.$i.'.jpg', 'tag' => $tag, 'name' => $tag_name ];
            }
            $title = 'Карнизы и молдинги';
            $pageTitle = 'Карнизы и молдинги - АртКомната';
            $pageDescription = 'Карнизы и молдинги';
            $this->render('gallery_tagged.twig', [
                'tags' => [['eng'=>'cornices', 'ru'=>'Карнизы'], ['eng'=>'moldings', 'ru'=>'Молдинги']],
                'gallery' => $gallery,
                'title' => $title,
                'pageTitle' => $pageTitle,
                'pageDescription' => $pageDescription]);
        }

    }


    public function gallery_nested($name){

        $this->render('gallery_nested.twig', ['name' => $name]);
    }



}