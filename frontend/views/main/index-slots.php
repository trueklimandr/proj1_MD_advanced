<?php
/**
 * Created by PhpStorm.
 * User: klimandr
 * Date: 21.03.18
 * Time: 16:57
 */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $doctor->user->lastName.'\'s timeslots';
$this->params['breadcrumbs'][] = $this->title;

?>
<?php if (count($timeSlots) > 0): ?>
<h1>Existing slots</h1>
<?php endif; ?>
<?php if (count($timeSlots) == 0): ?>
    <h1>No existing slots</h1>
<?php endif; ?>
<ul>
<?php foreach ($timeSlots as $timeSlot): ?>
    <li>
        <?= Html::encode("{$timeSlot->date}: {$timeSlot->start} - {$timeSlot->end}") ?>
    </li>
<?php endforeach; ?>
</ul>
<h3>To add new slot, push the button</h3>
<?= Html::a('Add', Url::to(['main/add-slot'], true), ['class' => 'btn btn-lg btn-success']) ?>
