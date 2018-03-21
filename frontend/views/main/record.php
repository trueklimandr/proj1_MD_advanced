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
                            <button id="btn<?= $doctor->doctorId ?>" class="btn btn-primary">Show timeslots</button>

                            <dialog id="dialog<?= $doctor->doctorId ?>">
                                <h3>Available slots for <?= $doctor->user->lastName . ' ' . $doctor->user->firstName?></h3>
                                <div id="slotDate<?= $doctor->doctorId ?>" class="col-md-4"></div>
                                <div id="slotStart<?= $doctor->doctorId ?>" class="col-md-3"></div>
                                <div id="slotEnd<?= $doctor->doctorId ?>" class="col-md-3"></div>
                                <div id="slotChoose<?= $doctor->doctorId ?>" class="col-md-2"></div>
                                <p id="chooseone<?= $doctor->doctorId ?>"></p>
                                <div id="error<?= $doctor->doctorId ?>"></div>
                                <div>
                                    <button id="cancel<?= $doctor->doctorId ?>" class="btn btn-default">Cancel</button>
                                </div>
                            </dialog>

                        </div>
                    </div>
                </div>

        <?php } ?>
    </div>
</div>
