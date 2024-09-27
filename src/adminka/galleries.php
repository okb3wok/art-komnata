<div class="row">
    <div class="col-lg-17">
        <div class="card mb-4 card-secondary">
            <div class="card-header">
                <h3 class="card-title">Добавить/обновить галереи</h3>
            </div>
            <div class="card-body">

                <p>Здесь можно добавить простые галереи как отдельно так и в существующие вложенные. А также добавить вложенные галереи.</p>

                <h3>Добавление галереи</h3>

                <p>1. Сформируйте галерею в виде папки. Название папки будет формировать её url на сайте.
                    Каждому изображению в папке должна соответсвтвовать миниатюра в папке thumbs.
                    Пример галереи из двух изображений:
                <pre>
                ├─┬ thumbs
                │ ├── 1.jpg
                │ └── 2.jpg
                ├── 1.jpg
                └── 2.jpg
                </pre>
                </p>

                <p>2. Загрузите через FTP клиент (например FileZilla) галерею в папку /var/www/art-komnata.ru/photos на сервере.</p>

                <p>3. Обновите эту страницу и добавьте новые галереи на этой странице в структуру галерей</p>

                <p>4. Если это не вложенная галерея перейдите на страницу <a href="./?req=gallery_simple">простые галереи</a>
                и заполните описание для загруженной галереи. Затем, если эта галерея находится во вложенной, то перейдите на страницу <a href="./?req=gallery_nested">вложенные галереи</a>
                и нажмите на кнопку "Обновить". Теперь она появится на странице этой вложенной галереи.</p>

                <p>Для добавления теггированных галерей нужна помощь <a href="https://t.me/ra3wok">администратора сайта</a></p>

                <h3>Удаление галереи</h3>
                <p>1. Через FTP клиент (например FileZilla) удалите папку галереи из /var/www/art-komnata.ru/photos на сервере.</p>
                <p>2. Обновите эту страницу и нажмите на кнопку "Убрать удаленные галереи"</p>
                <p>3. Если удаленная галерея находилась во вложенной, то перейдите на страницу <a href="./?req=gallery_nested">вложенные галереи</a>
                    и нажмите на кнопку "Обновить". Теперь она удалится и на странице этой вложенной галереи.</p>
              <?php
              function has_subdirectories($dir) {
                if (is_dir($dir)) {
                  $files = scandir($dir);
                  $hasSubdirs = false;

                  foreach ($files as $file) {
                    if ($file != '.' && $file != '..') {
                      if (is_dir($dir . '/' . $file) && $file!='thumbs') {
                        $hasSubdirs = true;
                        break;
                      }
                    }
                  }

                  return $hasSubdirs;
                } else {
                  return false;
                }
              }


              $PATH_TO_GALLERIES = '../photos';


              if(isset($_GET['update'])){

                $nested = $_POST['nested'];
                if($nested){
                  $jsonData = file_get_contents('../galleries_structure.json');
                  $dataArray = json_decode($jsonData, true);
                  foreach ($nested as $key => $value){
                    if(!array_key_exists($value, $dataArray)){
                      $dataArray[$value]=['type'=>'nested', 'subdirs'=>[]];
                      $gallery_nested = json_decode(file_get_contents('../model-gallery-nested.json'), true);
                      if(!in_array($value, $gallery_nested)){
                        $gallery_nested[$value]=['title'=>'', 'desc'=>''];
                      }
                      file_put_contents('../model-gallery-nested.json', json_encode($gallery_nested, JSON_UNESCAPED_UNICODE));
                    }
                  }
                  $jsonData = json_encode($dataArray, JSON_UNESCAPED_UNICODE);
                  file_put_contents('../galleries_structure.json', $jsonData);
                }


                $simple = $_POST['simple'];
                if($simple){
                  $jsonData = file_get_contents('../galleries_structure.json');
                  $dataArray = json_decode($jsonData, true);
                  foreach ($simple as $key => $value) {
                    preg_match('/^(.*)\/(.*)$/i', $value, $matches);
                    if($matches){
                      if(array_key_exists($matches[1], $dataArray)){
                        if(!in_array($matches[2], $dataArray[$matches[1]]['subdirs'])){
                          $dataArray[$matches[1]]['subdirs'][]=$matches[2];
                          $gallery_simple = json_decode(file_get_contents('../model-gallery-simple.json'), true);
                          if(!in_array($value, $gallery_simple)){
                            $gallery_simple[$value]=['title'=>'', 'desc'=>'', 'thumb'=>''];
                          }
                          file_put_contents('../model-gallery-simple.json', json_encode($gallery_simple, JSON_UNESCAPED_UNICODE));
                        }
                      }
                    }else{
                      if(!array_key_exists($value, $dataArray)){
                        $dataArray[$value]=['type'=>'simple'];
                        $gallery_simple = json_decode(file_get_contents('../model-gallery-simple.json'), true);
                        if(!in_array($value, $gallery_simple)){
                          $gallery_simple[$value]=['title'=>'', 'desc'=>'', 'thumb'=>''];
                        }
                        file_put_contents('../model-gallery-simple.json', json_encode($gallery_simple, JSON_UNESCAPED_UNICODE));

                      }
                    }
                  }
                  $jsonData = json_encode($dataArray, JSON_UNESCAPED_UNICODE);
                  file_put_contents('../galleries_structure.json', $jsonData);
                }

              }






              echo '<form action="./?req=galleries&update" method="POST" enctype="multipart/form-data">';
              $jsonData = file_get_contents('../galleries_structure.json');
              $dataArray = json_decode($jsonData, true);
              $if_new_galleries_exist = false;

              $dirs = glob('../photos/*', GLOB_ONLYDIR);
              foreach ($dirs as $dir) {
                if(basename($dir) != 'thumbs'){

                  if(array_key_exists(basename($dir), $dataArray)){
                    //echo '<strong style="color:green;">' . basename($dir) . "</strong><br>";

                    $subdirs = glob($dir . '/*', GLOB_ONLYDIR);
                    foreach ($subdirs as $subdir) {

                      if(basename($subdir) != 'thumbs'){
                        if(in_array(basename($subdir), $dataArray[basename($dir)]['subdirs'])){
                          //echo '<strong style="color:green; font-size:12px;">' . basename($dir) . "/" .basename($subdir) . "</strong><br>";
                        }else{
                          $if_new_galleries_exist = true;
                          echo '<strong style="color:red; font-size:12px;">- ' .basename($dir) . "/" .basename($subdir) . "</strong><br>";
                          echo '<input type="text" hidden=""  name="simple[]" value="' .basename($dir) . "/" .basename($subdir) . '" >';
                        }
                      }
                    }

                  }else{
                    $if_new_galleries_exist = true;
                    echo '<strong style="color:red;">' . basename($dir) . "</strong><br>";

                    if(has_subdirectories($dir)){
                      echo '<input type="text" hidden=""  name="nested[]" value="' . basename($dir) . '" >';
                      $subdirs = glob($dir . '/*', GLOB_ONLYDIR);
                      foreach ($subdirs as $subdir) {
                        echo '<span style="color:red; font-size:12px;">- ' . basename($dir) . "/" . basename($subdir) . "</span><br>";
                        echo '<input type="text" hidden=""  name="simple[]" value="' . basename($dir) . "/" . basename($subdir) . '" >';
                      }
                    }else{
                      echo '<input type="text" hidden=""  name="simple[]" value="' . basename($dir) . '" >';
                    }

                  }


                }
              }

              if($if_new_galleries_exist){
                echo '<h2>Найдены новые галереи</h2>
                <p>Нажмите на кнопку чтобы добавить их в galleries_structure.json:</p>';
                echo '<input type="submit" class="btn btn-primary" value="Добавить новые галереи">';
              }

              echo '</form>';


              if(isset($_GET['remove'])){

                $nested = $_POST['nested'];
                if($nested){
                  $jsonData = file_get_contents('../galleries_structure.json');
                  $dataArray = json_decode($jsonData, true);
                  //Пройтись по simple files и удалить все где nested-name/name


                  foreach ($nested as $key => $value){
                    if(array_key_exists($value, $dataArray)) {

                      $gallery_simple = json_decode(file_get_contents('../model-gallery-simple.json'), true);
                      foreach($gallery_simple as $key_simple => $value_simple){
                          if(preg_match('/^' . $value . '\/(.*)$/i', $key_simple,$matches_simple)) {
                              unset($gallery_simple[$key_simple]);
                          }
                      }
                      file_put_contents('../model-gallery-simple.json', json_encode($gallery_simple, JSON_UNESCAPED_UNICODE));

                      unset($dataArray[$value]);
                      $gallery_nested = json_decode(file_get_contents('../model-gallery-nested.json'), true);
                      if(array_key_exists($value, $gallery_nested)){
                        unset($gallery_nested[$value]);
                      }
                      file_put_contents('../model-gallery-nested.json', json_encode($gallery_nested, JSON_UNESCAPED_UNICODE));
                    }
                  }
                  $jsonData = json_encode($dataArray, JSON_UNESCAPED_UNICODE);
                  file_put_contents('../galleries_structure.json', $jsonData);
                }

                $simple = $_POST['simple'];
                if($simple){
                  $jsonData = file_get_contents('../galleries_structure.json');
                  $dataArray = json_decode($jsonData, true);
                  foreach ($simple as $key => $value) {
                    preg_match('/^(.*)\/(.*)$/i', $value, $matches);

                    if($matches){
                      if(in_array($matches[2], $dataArray[$matches[1]]['subdirs'])){
                        unset($dataArray[$matches[1]]['subdirs'][array_search($matches[2], $dataArray[$matches[1]]['subdirs'])]);
                        $gallery_simple = json_decode(file_get_contents('../model-gallery-simple.json'), true);
                        if(array_key_exists($value, $gallery_simple)){
                          unset($gallery_simple[$value]);
                        }
                        file_put_contents('../model-gallery-simple.json', json_encode($gallery_simple, JSON_UNESCAPED_UNICODE));
                      }
                    }else{
                      if(array_key_exists($value, $dataArray)){
                        unset($dataArray[$value]);
                        $gallery_simple = json_decode(file_get_contents('../model-gallery-simple.json'), true);
                        if(array_key_exists($value, $gallery_simple)){
                          unset($gallery_simple[$value]);
                        }
                        file_put_contents('../model-gallery-simple.json', json_encode($gallery_simple, JSON_UNESCAPED_UNICODE));
                      }
                    }
                  }
                  $jsonData = json_encode($dataArray, JSON_UNESCAPED_UNICODE);
                  file_put_contents('../galleries_structure.json', $jsonData);
                }

              }

                echo ' <p>Проверка наличия галерей в парке photos в соответствии со структурой в файле galleries_structure.json
                    (<span style="color:green;">есть</span>, <span style="color:red;">нет</span>):</p>

                <h2>Структура галерей</h2><p>Хранится в файле galleries_structure.json</p>';

                echo '<form action="./?req=galleries&remove" method="POST" enctype="multipart/form-data">';

                $jsonData = file_get_contents('../galleries_structure.json');
                $dataArray = json_decode($jsonData, true);

                $if_deleted_galleries_exist = false;

                foreach ($dataArray as $key => $value) {

                  if (file_exists($PATH_TO_GALLERIES . "/" . $key)) {
                    echo '<strong style="color:green;">' . $key . "</strong><br>";

                    if($value['type']=='nested'){

                      foreach ($value['subdirs'] as $subdir) {
                        if(file_exists($PATH_TO_GALLERIES . "/" . $key . "/" . $subdir)){
                          echo ' - <span style="font-size:12px; color:green;">'. $key . "/" .basename($subdir) . "</span><br>";
                        }else{
                          echo ' - <span style="font-size:12px; color:red;">'. $key . "/" .basename($subdir) . "</span><br>";
                          echo '<input type="text" hidden=""  name="simple[]" value="' .$key . "/" .basename($subdir) . '" >';
                          $if_deleted_galleries_exist = true;
                        }
                      }
                    }
                  }else{

                    if($value['type']=='nested'){
                      echo '<strong style="color:red;">' . $key . "</strong><br>";
                      echo '<input type="text" hidden=""  name="nested[]" value="' . $key . '" >';
                      $if_deleted_galleries_exist = true;
                    }else{
                      echo '<strong style="color:red;">' . $key . "</strong><br>";
                      echo '<input type="text" hidden=""  name="simple[]" value="' . $key . '" >';
                      $if_deleted_galleries_exist = true;
                    }

                  }

                }

                if($if_deleted_galleries_exist){
                    echo '<br><input type="submit" class="btn btn-primary" value="Убрать удаленные галереи">';
                }
                echo '</form>';





//                $jsonData = file_get_contents('../galleries_structure.json');
//
//                if(isset($_GET['update'])){
//                  $jsonData = json_encode($galleries,JSON_UNESCAPED_UNICODE);
//                  file_put_contents('../galleries_structure.json', $jsonData);
//                  echo '<p style="color:green">структура галерей обновлена</p>';
//                }
//
//
//                if($jsonData != json_encode($galleries,JSON_UNESCAPED_UNICODE)){
//                    echo 'Структура галерей изменилась. Обновить?';
//
//                    echo '<form action="./?req=galleries&update" method="POST" enctype="multipart/form-data">
//                        <input type="submit" class="btn btn-primary" value="Обновить">
//                        </form>';
//                }





//                function scan_directory_for_jpg($dir) {
//                  $files = array();
//
//                  if (is_dir($dir)) {
//                    if ($dh = opendir($dir)) {
//                      while (($file = readdir($dh)) !== false) {
//                        if (is_file($dir . '/' . $file) && preg_match("/\.jpg$/i", $file)) {
//                          $files[] = basename($file);
//                        }
//                      }
//                      closedir($dh);
//                    }
//                  }
//                  return $files;
//                }

                ?>

            </div>
        </div>
    </div>
</div>