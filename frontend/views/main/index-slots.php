<?php
/**
 * Created by PhpStorm.
 * User: klimandr
 * Date: 21.03.18
 * Time: 16:57
 */

use yii\bootstrap\Modal;
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
        <?= Html::encode("{$timeSlot->date} : | {$timeSlot->start} | - | {$timeSlot->end} |") ?>
            <?php
            Modal::begin([
                'header' => '<h2>Are you sure you want to delete this timeslot?</h2>',
                'toggleButton' => [
                        'tag' => 'button',
                        'class' => 'btn btn-xs btn-danger',
                        'label' => 'delete'
                ]
            ]);

            echo Html::encode("{$timeSlot->date} : | {$timeSlot->start} | - | {$timeSlot->end} |");
            echo '<br><hr>';
            echo Html::a(
                'Delete',
                Url::to(['main/delete-slot', 'id' => $timeSlot->id],true),
                ['class' => 'btn btn-lg btn-danger']);
            echo Html::button(
                'Cancel',
                ['class' => 'btn btn-lg btn-default pull-right', 'data-dismiss' => 'modal']);

            Modal::end();
            ?>
    </li>
<?php endforeach; ?>
</ul>
<h3>To add new slot, push the button</h3>
<?= Html::a('Add', Url::to(['main/add-slot'], true), ['class' => 'btn btn-lg btn-success']) ?>
