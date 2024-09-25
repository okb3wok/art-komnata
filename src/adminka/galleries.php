<div class="row">
    <div class="col-lg-17">
        <div class="card mb-4 card-secondary">
            <div class="card-header">
                <h3 class="card-title">Все галереи</h3>
            </div>
            <div class="card-body">

                <p>Считаны все галереи расположенные в папке photos:</p>
                <?php
                $dirs = glob('/var/www/art-komnata.ru/photos/*', GLOB_ONLYDIR);
                foreach ($dirs as $dir) {
                    if(basename($dir) != 'thumbs'){
                        echo '<strong>'.basename($dir) . "</strong><br>";
                        $subdirs = glob($dir . '/*', GLOB_ONLYDIR);
                        foreach ($subdirs as $subdir) {
                            if(basename($subdir) != 'thumbs'){
                                echo ' - '. basename($dir) . "/" .basename($subdir) . "<br>";
                            }
                        }
                    }
                }


                function scan_directory_for_jpg($dir) {
                  $files = array();

                  if (is_dir($dir)) {
                    if ($dh = opendir($dir)) {
                      while (($file = readdir($dh)) !== false) {
                        if (is_file($dir . '/' . $file) && preg_match("/\.jpg$/i", $file)) {
                          $files[] = basename($file);
                        }
                      }
                      closedir($dh);
                    }
                  }
                  return $files;
                }

                ?>

            </div>
        </div>
    </div>
</div>