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
    <?= $form->field($timeSlot, 'doctorId')
        ->textInput(['value' => $doctorId, 'readonly' => 'readonly']) ?>
    <?= $form->field($timeSlot, 'date')
        ->input('date', ['value' => date('Y-m-d', strtotime('today'))]) ?>
    <?= $form->field($timeSlot, 'start')->input('time', ['value' => '08:00:00']) ?>
    <?= $form->field($timeSlot, 'end')->input('time', ['value' => '12:00:00']) ?>
    <?= Html::submitButton('Add slot', ['class'=> 'btn btn-success']) ?>
    <?php ActiveForm::end(); ?>

</div>
