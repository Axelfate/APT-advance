<?php
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use frontend\models\Ubicacion;
use frontend\models\Usuario;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
        /*[
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'idDepartamento',
    ],*/
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nombre',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'encargado',
        'value' => function($model){
            $usuario = Usuario::findOne($model->encargado);
            if ($usuario!=null) {
              return $usuario->nombres;
            } else {
              return 'Seleccione un empleado como encargado';
            }
            //return $usuario->nombres;

        },
        'filter' => ArrayHelper::map(Usuario::find()->all(),'idUsuario','nombres'),
    ],
    [
        'attribute' => 'localizacion',
        'header' =>'Ubicacion',
        'value' => function($model){
            $loc = Ubicacion::findOne($model->localizacion);
            return $loc->hotel;
        },
        'filter' => ArrayHelper::map(Ubicacion::find()->all(),'idUbicacion','hotel'),
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) {
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete',
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'],
    ],

];
