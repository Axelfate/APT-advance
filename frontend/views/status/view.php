<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Status */
?>
<div class="status-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idStatus',
            'status',
        ],
    ]) ?>

</div>
