<div class="row">
  <div class="col-lg-17">
    <div class="card mb-4 card-secondary">
      <div class="card-header">
      <h3 class="card-title">Простые галереи1</h3>
      </div>
      <div class="card-body">

        <?php
        $jsonData = file_get_contents('/var/www/html/model-gallery-simple.json');
        $dataArray = json_decode($jsonData, true);

        foreach ($dataArray as $key => $value) {
            echo '<a href="./?req=gallery_simple&gallery=' . $key . '">' . $key . '</a><br>';
        }
        ?>

      </div>
    </div>
  </div>
</div>