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
                            <h4><strong><?= $doctor->specialization ?></strong></h4>
                            <button id="btn<?= $doctor->doctorId ?>"
                                    class="btn btn-primary"
                                    onclick="showTimeDialog(<?= $doctor->doctorId ?>)">
                                Show timeslots</button>
                            <dialog id="dialog<?= $doctor->doctorId ?>">
                                <h3>Available slots for
                                    <?= $doctor->user->lastName . ' ' .
                                        $doctor->user->firstName?></h3>
                                <div id="table<?=$doctor->doctorId?>"></div>
                                <div id="error<?= $doctor->doctorId ?>"></div>
                                <div>
                                    <button id="cancel<?= $doctor->doctorId ?>" class="btn btn-danger">Cancel</button>
                                </div>
                            </dialog>
                        </div>
                    </div>
                </div>
        <?php } ?>
    </div>
</div>
