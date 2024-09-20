<div class="row">
    <div class="col-lg-17">
        <div class="card mb-4 card-secondary">
            <div class="card-header">
                <h3 class="card-title">Галереи с тегами</h3>
            </div>
            <div class="card-body">

              <?php

              if(isset($_GET['gallery']) && isset($_GET['update'])){
//                $jsonData = file_get_contents('../model-gallery-tagged.json');
//                $dataArray = json_decode($jsonData, true);
//                $dataArray[$_GET['gallery']]['title'] = trim($_POST['title']);
//                $dataArray[$_GET['gallery']]['desc'] = trim($_POST['desc']);
//                $dataArray[$_GET['gallery']]['thumb'] = trim($_POST['thumb']);
//                $jsonData = json_encode($dataArray, JSON_UNESCAPED_UNICODE);
//                file_put_contents('../model-gallery-tagged.json', $jsonData);
                echo '<p style="color:green">Галерея обновлена</p>';

                print_r($_POST);

              }

              $jsonData = file_get_contents('../model-gallery-tagged.json');
              $dataArray = json_decode($jsonData, true);

              if(isset($_GET['gallery'])){
                $gallery = $dataArray[$_GET['gallery']];
                echo '<a href="./?req=gallery_tagged">Назад</a>  
                <h1>' . $_GET['gallery'] . '</h1>
                
                <p>Заполните название галереи и описание</p>
                <form action="./?req=gallery_tagged&gallery=' . $_GET['gallery'] . '&update" 
                method="POST" enctype="multipart/form-data">
                
                <div class="col-12 col-lg-6">
                    <div class="form-group">
                        <label><strong>Название</strong>(Title)</label>
                        <input class="form-control" type="text" name="title" value="' . $gallery['title'] . '">
                    </div>
                </div>    
                <br>
                <div class="col-12 col-lg-12">
                    <div class="form-group">
                        <label><strong>Описание</strong>(Description)</label>
                        <input class="form-control" type="text" name="desc" value="' . $gallery['desc'] . '">
                        
                    </div>
                </div>
                <br>
                <div class="col-6 col-lg-2">
                    <div class="form-group">
                        <label><strong>Титульное изображение</strong> - имя нужного файла (например 1.jpg)</label>
                        <input class="form-control" type="text" name="thumb" value="' . $gallery['thumb'] . '">
                    </div>
                </div> 
                <br>
                <button class="btn btn-secondary" id="addTags">+ Добавить теги</button>
                <br>
                <div id="tagsForm" >
                </div>

                <br>
                <input type="submit" class="btn btn-primary" value="Обновить">
                
                
                <br><br>
                <h4>Миниатюры галереи:</h4>';


                $files = glob('../photos/'. $_GET['gallery'] .'/*.jpg');
                $gallery = [];
                echo '<div class="gallery__list">';
                foreach ($files as $file) {
                  echo '<div class="gallery__item">';
                  echo '<div class="number">'.basename($file).'</div>';
                  echo '<img src="../photos/'.$_GET['gallery'].'/thumbs/'.basename($file).'" >';
                  echo '</div>';
                }
                echo '</div>
                </form>';

              }else{

                foreach ($dataArray as $key => $value) {
                  if($value['desc']==''){
                    echo '<a style="color:red" href="./?req=gallery_tagged&gallery=' . $key . '">' . $key . '</a><br>';
                  }else{
                    echo '<a href="./?req=gallery_tagged&gallery=' . $key . '">' . $key . '</a><br>';
                  }

                }

              }
              ?>
            </div>
        </div>
    </div>
</div>