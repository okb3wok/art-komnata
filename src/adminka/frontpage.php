<div class="row">
    <div class="col-lg-17">
        <div class="card mb-4 card-secondary">
            <div class="card-header">
                <h3 class="card-title">Главная</h3>
            </div>
            <div class="card-body">
                <h1>Главные параметры</h1>

                <?php

                    if(isset($_GET['update'])){
                      $jsonData = file_get_contents('../main-settings.json');
                      $dataArray = json_decode($jsonData, true);
                      $dataArray['sitename'] = htmlspecialchars(trim($_POST['sitename']));
                      $dataArray['title'] = htmlspecialchars(trim($_POST['title']));
                      $dataArray['desc'] = htmlspecialchars(trim($_POST['desc']));
                      $jsonData = json_encode($dataArray, JSON_UNESCAPED_UNICODE);
                      file_put_contents('../main-settings.json', $jsonData);
                      echo '<p style="color:green">Параметры обновлены</p>';
                    }

                ?>

                <form action="./?update" method="POST" enctype="multipart/form-data">

                <?php
                    $jsonData = file_get_contents('../main-settings.json');
                    $dataArray = json_decode($jsonData, true);
                ?>

                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label><strong>Название</strong> (sitename) используется в титуле на всех страницах, кроме главной</label>
                            <input class="form-control" type="text" name="sitename" value="<?php echo $dataArray['sitename']; ?>" autocomplete="off">
                        </div>
                    </div>
                    <br>

                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label><strong>Титул</strong> (title) главной страницы</label>
                            <input class="form-control" type="text" name="title" value="<?php echo $dataArray['title']; ?>" autocomplete="off">
                        </div>
                    </div>
                    <br>
                    <div class="col-12 col-lg-12">
                        <div class="form-group">
                            <label><strong>Описание</strong> (description) то что отображается в сниппете поисковой выдаче</label>
                            <input class="form-control" type="text" name="desc" value="<?php echo $dataArray['desc']; ?>" autocomplete="off">

                        </div>
                    </div>
                    <br>
                    <input type="submit" class="btn btn-primary" value="Обновить">
                </form>

            </div>
        </div>
    </div>
</div>