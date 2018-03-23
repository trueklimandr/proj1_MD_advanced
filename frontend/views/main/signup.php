<?php
/**
 * Created by PhpStorm.
 * User: klimandr
 * Date: 20.03.18
 * Time: 16:34
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Sign up';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="modal-dialog">

    <h1><?= Html::encode($this->title)?></h1>

    <p>Please fill out the following fields to sign up</p>

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'firstName') ?>
    <?= $form->field($model, 'lastName') ?>
    <?= $form->field($model, 'email') ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= Html::submitButton('Sign up', ['class'=> 'btn btn-success']) ?>
    <?php ActiveForm::end(); ?>

</div>
