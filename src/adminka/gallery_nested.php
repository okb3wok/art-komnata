<div class="row">
    <div class="col-lg-17">
        <div class="card mb-4 card-secondary">
            <div class="card-header">
                <h3 class="card-title">Вложенные галереи</h3>
            </div>
            <div class="card-body">

                <a href="./?req=gallery_nested">Назад</a>
                <h1>Вложенные галереи</h1>

                <p>Данные вложенных галерей генерируются на основе <a href="./?req=gallery_simple">простых гелерей</a></p>
                <form action="./?req=gallery_nested&update" method="POST" enctype="multipart/form-data">
                <?php
                if(isset($_GET['update'])){

                    $jsonData = file_get_contents('../model-gallery-nested.json');
                    $dataArray = json_decode($jsonData, true);

                    foreach($_POST['gallery'] as $key => $value){

                      $jsonData_simple = file_get_contents('../model-gallery-simple.json');
                      $dataArray_simple = json_decode($jsonData_simple, true);

                      $content = [];
                      foreach ($dataArray_simple as $key_simple => $value_simple) {
                          if(preg_match('/'.$value.'\/(.*)/', $key_simple)){
                            $content[$key_simple]= [
                              'title' => $value_simple['title'],
                              'thumb' => $value_simple['thumb']];
                          }
                      }

                      $dataArray[$value]['title'] = htmlspecialchars(trim($_POST['title'][$key]));
                      $dataArray[$value]['desc'] = htmlspecialchars(trim($_POST['desc'][$key]));
                      $dataArray[$value]['content'] = $content;
                    }

                    $jsonData = json_encode($dataArray, JSON_UNESCAPED_UNICODE);
                    file_put_contents('../model-gallery-nested.json', $jsonData);

                    echo '<p style="color:green">Галереи обновлены</p>';

                }

                $file = '../model-gallery-nested.json';
                $modifiedTime = filemtime($file);
                echo "Вложенные галереи были обновлены: " . date('Y-m-d H:i:s', $modifiedTime) ."<br><br>";

                $jsonData = file_get_contents('../model-gallery-nested.json');
                $dataArray = json_decode($jsonData, true);

                foreach ($dataArray as $key => $value) {
                    echo '<h3>' . $key . '</h3>
                    <input type="text" name="gallery[]" value="' . $key . '" hidden="">
                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label><strong>Название</strong>(Title)</label>
                            <input class="form-control" type="text" name="title[]" value="' . $value['title'] . '">
                        </div>
                    </div>
                    <div class="col-12 col-lg-12">
                        <div class="form-group">
                            <label><strong>Описание</strong>(Description)</label>
                            <input class="form-control" type="text" name="desc[]" value="' . $value['desc'] . '">
                        </div>
                    </div>
                    <br>
                    ';


                }

                ?>

                    <br>
                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" value="Обновить" />
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>