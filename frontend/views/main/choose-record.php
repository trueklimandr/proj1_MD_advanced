<?php
/**
 * Created by PhpStorm.
 * User: klimandr
 * Date: 05.04.18
 * Time: 14:07
 */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Choose record';
$this->params['breadcrumbs'][] = ['label' => 'Medical record', 'url' => '/main/record'];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-md-4">
<div class="panel panel-default">
  <div class="panel-heading">Choose suitable visit day</div>
    <table class="table">
      <thead>
        <tr>
          <th>Date</th><th>Day</th><th></th>
        </tr>
      </thead>
      <?php foreach ($timeSlots as $item):?>
        <tr>
          <td><?=$item['date']?></td>
          <td><?=date('D', strtotime($item['date']))?></td>
          <td class="text-center"><?= Html::a(
                'Want this',
                Url::to(['main/choose-record'], true),
                ['class' => 'btn btn-sm btn-success']
              ) ?></td>
        </tr>
      <?php endforeach;?>
    </table>
</div>
</div>