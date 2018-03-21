<?php
/**
 * Created by PhpStorm.
 * User: klimandr
 * Date: 21.03.18
 * Time: 17:52
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Add slot';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="modal-dialog">

    <h1><?= Html::encode($this->title)?></h1>

    <p>Please fill out the following fields to add slot</p>

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($timeSlot, 'doctorId')->dropDownList([$doctorId => $doctorId]) ?>
    <?= $form->field($timeSlot, 'date') ?>
    <?= $form->field($timeSlot, 'start') ?>
    <?= $form->field($timeSlot, 'end') ?>
    <?= Html::submitButton('Add slot', ['class'=> 'btn btn-success']) ?>
    <?php ActiveForm::end(); ?>

</div>
