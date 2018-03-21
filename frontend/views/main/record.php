<?php
/**
 * Created by PhpStorm.
 * User: klimandr
 * Date: 20.03.18
 * Time: 17:06
 */

$this->title = 'Medical record';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="body-content">
    <div class="row">
        <?php foreach ($doctors as $doctor) { ?>

                <div class="col-sm-6 col-md-3">
                    <div class="thumbnail">
                        <div class="caption">
                            <h3><?= $doctor->user->lastName . ' ' . $doctor->user->firstName?></h3>
                            <p>...</p>
                            <p class=""><a href="#" class="btn btn-primary" role="button">Button</a></p>
                        </div>
                    </div>
                </div>

        <?php } ?>
    </div>
</div>
