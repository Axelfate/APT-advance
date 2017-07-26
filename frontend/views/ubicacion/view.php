<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Ubicacion */
?>
<div class="ubicacion-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'idUbicacion',
            'hotel',
            'pais',
            'estado',
            'direccion',
        ],
    ]) ?>

</div>
