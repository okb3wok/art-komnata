<div class="row">
    <div class="col-lg-17">
        <div class="card mb-4 card-secondary">
            <div class="card-header">
                <h3 class="card-title">Все галереи</h3>
            </div>
            <div class="card-body">

                <p>Считаны все галереи расположенные в папке photos:</p>
                <?php
                $dirs = glob('/var/www/html/photos/*', GLOB_ONLYDIR);
                foreach ($dirs as $dir) {
                    if(basename($dir) != 'thumbs'){
                        echo '<strong>'.basename($dir) . "</strong><br>";
                        $subdirs = glob($dir . '/*', GLOB_ONLYDIR);
                        foreach ($subdirs as $subdir) {
                            if(basename($subdir) != 'thumbs'){
                                echo ' - '. basename($subdir) . "<br>";
                            }
                        }
                    }
                }

                ?>

            </div>
        </div>
    </div>
</div>