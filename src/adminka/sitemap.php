<div class="row">
  <div class="col-lg-17">
    <div class="card mb-4 card-secondary">
      <div class="card-header">
        <h3 class="card-title">Генерация карты сайта</h3>
      </div>
      <div class="card-body">

        <?php



        include "sitemap-generator.php";
        include "sitemap-config.php";

        if(isset($_GET['update'])) {
          $smg = new SitemapGenerator($CONFIG);

          $smg->GenerateSitemap();

          $anchors = $smg->scanned;

          echo '<a href="./?req=sitemap">Назад</a><br><br>';

          foreach ($anchors as $a) {
            echo '<a href="' . $a . '">' . $a . '</a><br>';
          }
        }else{

          $file = '../sitemap.xml';
          $modifiedTime = filemtime($file);
          echo "Карта сайта была обновлена: " . date('Y-m-d H:i:s', $modifiedTime) ."<br><br>";

          echo '<a href="/sitemap.xml">sitemap.xml</a><br><br>';

          echo '<form action="./?req=sitemap&update" method="POST" enctype="multipart/form-data">
          <div class="col-12 col-lg-6">
              <div class="form-group">
                  <input class="btn btn-primary" type="submit" value="Обновить" />
              </div>
          </div>
          </form>';
        }
        ?>



      </div>
    </div>
  </div>
</div>