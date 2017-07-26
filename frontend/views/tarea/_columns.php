<?php
use yii\helpers\Url;
use kartik\grid\GridView;
use frontend\models\TareaSearch;
use yii\helpers\ArrayHelper;
use frontend\models\Usuario;
use frontend\models\Departamento;
use frontend\models\Status;
use kartik\datecontrol\Module;
use kartik\date\DatePicker;
use kartik\editable\Editable;
use frontend\models\Ubicacion;
use frontend\models\TareaSearch2;

return [
    [
        'class' => 'kartik\grid\ExpandRowColumn',
        'value' => function($model, $key, $index, $column){
            return GridView::ROW_COLLAPSED;
        } ,
        'detail' => function($model, $key, $index, $column){
            $searchModel = new TareaSearch2();
            $searchModel-> idTarea = $model->idTarea;
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return Yii::$app->controller->renderPartial('../tarea/_tareasItems',[
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        },
    ],
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    /*[
    'attribute' => 'idTarea',
    'contentOptions' => function ($model, $key, $index, $column) {
        return ['style' => 'background-color:'
            . ($model->idTarea == '2' ? 'red' : 'blue')];
        },
    ],*/
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'descripcion_corta',

    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ubicacion',
        'value' => function($model){
            $ub = Ubicacion::findOne($model->ubicacion);
            if ($ub!=null) {
              return $ub->hotel;
            } else {
              return 'Seleccione una ubicacion';
            }
            //return $usuario->nombres;

        },
    ],
    [
        'attribute' => 'asignado_a',
        'value' => function($model){
            $usuario = Usuario::findOne($model->asignado_a);
            return $usuario->nombres;
        },
        'filter' => ArrayHelper::map(Usuario::find()->all(),'idUsuario','nombres'),
    ],
    [
        'attribute' => 'creado_por',
        'value' => function($model){
            $usuario = Usuario::findOne($model->creado_por);
            return $usuario->nombres;
        },
        'filter' => ArrayHelper::map(Usuario::find()->all(),'idUsuario','nombres'),
    ],
    [
        'attribute' => 'departamento_asignado',
        'value' => function($model){
            $depto = Departamento::findOne($model->departamento_asignado);
            return $depto->nombre;
        },
        'filter' => ArrayHelper::map(Departamento::find()->all(),'idDepartamento','nombre'),
    ],
    [
         'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'fecha_inicio',
         'filter' => '',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute' => 'fecha_propuesta_fin',
        'filter'=>'',
    ],
    [
        'class'=>'\kartik\grid\EditableColumn',
        'attribute' => 'estado',
        'value' => function($model){
                $est = Status::findOne($model->estado);
                return $est->status;
        },
        'filter' => ArrayHelper::map(Status::find()->all(),'idStatus','status'),
        'editableOptions' => [
                                //'format'=>Editable::FORMAT_BUTTON,
                                'inputType'=>Editable::INPUT_DROPDOWN_LIST,
                                'data' => [1 => 'Iniciado', 2=>'Cancelado', 5 => 'Concluido', 6 => 'Revisión'],
                                'options' => ['class'=>'form-control'], //, 'prompt'=>'status...'],
                                'displayValueConfig'=> [
                                    1 => 'Iniciado',
                                    2=>'Cancelado',
                                    5 => 'Concluido',
                                    6 => 'Revisión',
                                    ], 
                              'formOptions' => ['action' => ['/tarea/editest']],
                            ]
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'notas',
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
