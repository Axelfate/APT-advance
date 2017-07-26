<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Tipousuario */
?>
<div class="tipousuario-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idTipo',
            'tipo',
        ],
    ]) ?>

</div>
