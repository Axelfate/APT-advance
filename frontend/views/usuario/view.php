<?php

use yii\widgets\DetailView;
use frontend\models\Ubicacion;
use frontend\models\Departamento;
use frontend\models\Tipousuario;

/* @var $this yii\web\View */
/* @var $model frontend\models\Usuario */
?>
<div class="usuario-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'idUsuario',
            'nombres',
            'apellidos',
            [
                'attribute' => 'establecimiento',
                'value' => function($model){
                    $loc = Ubicacion::findOne($model->establecimiento);
                    if($loc!=null){
                        return $loc->hotel;
                    }
                    else{
                        return 'Asigne un establecimiento';
                    }
                    
                },
            ],
            [
                'attribute' => 'pertenece_departamento',
                'value' => function($model){
                    $depto = Departamento::findOne($model->pertenece_departamento);
                    if($depto!=null){
                        return $depto->nombre;
                    }
                    else{
                        return 'Asigne un departamento';
                    }
                    
                },
            ],
            [
                'attribute' => 'cargo',
                'value' => function($model){
                    $tip = Tipousuario::findOne($model->cargo);
                    if($tip!=null){
                        return $tip->tipo;
                    }
                    else{
                        return 'Asigne un cargo';
                    }
                    
                },
            ],
        ],
    ]) ?>

</div>
