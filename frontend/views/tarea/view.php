<?php

use yii\widgets\DetailView;
use frontend\models\Usuario;
use frontend\models\Status;
use frontend\models\Departamento;
use frontend\models\Ubicacion;

/* @var $this yii\web\View */
/* @var $model frontend\models\Tarea */
?>
<div class="tarea-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'idTarea',
            'descripcion_corta',
            'descripcion_larga',
            [
                'attribute' => 'ubicacion',
                'value' => function($model){
                    $hotel = Ubicacion::findOne($model->ubicacion);
                    if ($hotel!=null) {
                      return $hotel->hotel;
                    } else {
                      return 'Seleccione una ubicacion';
                    }
                },
            ],
            [
                'attribute' => 'creado_por',
                'value' => function($model){
                    $usuario = Usuario::findOne($model->creado_por);
                    return $usuario->nombres;
                },
            ],
            [
                'attribute' => 'asignado_a',
                'value' => function($model){
                    $usuario = Usuario::findOne($model->asignado_a);
                    return $usuario->nombres;
                },
            ],            
            [
                'attribute' => 'departamento_asignado',
                'value' => function($model){
                    $depto = Departamento::findOne($model->departamento_asignado);
                    return $depto->nombre;
                },
            ],
            'fecha_inicio',
            'fecha_propuesta_fin',
            [
                'attribute' => 'estado',
                'value' => function($model){
                        $est = Status::findOne($model->estado);
                        return $est->status;
                },
            ],
            'notas',
        ],
    ]) ?>

</div>
