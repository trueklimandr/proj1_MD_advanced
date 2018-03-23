<?php
/**
 * Created by PhpStorm.
 * User: klimandr
 * Date: 20.03.18
 * Time: 14:36
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="modal-dialog">

    <h1><?= Html::encode($this->title)?></h1>

    <p>Please fill out the following fields to login</p>

    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= Html::submitButton('Enter', ['class'=> 'btn btn-success']) ?>
    <?php ActiveForm::end(); ?>

</div>
