<?php
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use frontend\models\Ubicacion;
use frontend\models\Departamento;

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
        'attribute'=>'idUsuario',
    ],*/
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nombres',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'apellidos',
    ],
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
        'filter' => ArrayHelper::map(Ubicacion::find()->all(),'idUbicacion','hotel'),
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
        'filter' => ArrayHelper::map(Departamento::find()->all(),'idDepartamento','nombre'),
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=> 'username',
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'password',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'cargo',
    // ],
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
