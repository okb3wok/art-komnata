<div class="row">
    <div class="col-lg-17">
        <div class="card mb-4 card-secondary">
            <div class="card-header">
                <h3 class="card-title">Галереи с тегами</h3>
            </div>
            <div class="card-body">

              <?php


              if(isset($_GET['gallery'])){

                echo '<a href="./?req=gallery_tagged">Назад</a>  
                <h1 id="gallery_name">' . $_GET['gallery'] . '</h1>
                
                <p>Заполните название галереи и описание</p>

                
                <div class="col-12 col-lg-6">
                    <div class="form-group">
                        <label><strong>Название</strong>(Title)</label>
                        <input id="gallery_title" class="form-control" type="text" name="title" value="">
                    </div>
                </div>    
                <br>
                <div class="col-12 col-lg-12">
                    <div class="form-group">
                        <label><strong>Описание</strong>(Description)</label>
                        <input id="gallery_desc" class="form-control" type="text" name="desc" value="">
                    </div>
                </div>
                <br>
                <div class="col-6 col-lg-3">
                    <div class="form-group">
                        <label><strong>Титульное изображение</strong> - имя нужного файла (например 1.jpg)</label>
                        <input id="gallery_thumb" class="form-control" type="text" name="thumb" value="">
                    </div>
                </div>
                <br>
                <button class="btn btn-secondary" id="addTags">+ Добавить теги</button>
                <br>
                <div id="tagsForm" ></div>

                <br>
                <input type="submit" class="btn btn-primary" value="Обновить" id="gallery_update">
                
                
                <br><br>
                <h4>Миниатюры галереи:</h4><div class="gallery__list"></div>';


              }else{

                $jsonData = file_get_contents('../model-gallery-tagged.json');
                $dataArray = json_decode($jsonData, true);

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