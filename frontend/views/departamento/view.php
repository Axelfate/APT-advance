<?php

use yii\widgets\DetailView;
use frontend\models\Ubicacion;
use frontend\models\Usuario;

/* @var $this yii\web\View */
/* @var $model frontend\models\Departamento */
?>
<div class="departamento-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'idDepartamento',
            'nombre',
            [
            	'attribute' => 'localizacion',
		        'header' =>'Ubicacion',
		        'value' => function($model){
		            $loc = Ubicacion::findOne($model->localizacion);
		            return $loc->hotel;
		        },
            ],
            [
            	'attribute'=>'encargado',
		        'value' => function($model){
		            $usuario = Usuario::findOne($model->encargado);
		            return $usuario->nombres;	         
		        },
            ],
        ],
    ]) ?>

</div>
