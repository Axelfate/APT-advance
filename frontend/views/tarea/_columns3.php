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
        'attribute' => 'ubicacion',
        'value' => function($model){
            $hotel = Ubicacion::findOne($model->ubicacion);
            if ($hotel!=null) {
              return $hotel->hotel;
            } else {
              return 'Seleccione una ubicacion';
            }
        },
        'filter' => '',
    ],
    [
        'attribute' => 'asignado_a',
        'value' => function($model){
            $usuario = Usuario::findOne($model->asignado_a);
            return $usuario->nombres;
        },
        'filter' => '',
    ],
    [
        'attribute' => 'creado_por',
        'value' => function($model){
            $usuario = Usuario::findOne($model->creado_por);
            return $usuario->nombres;
        },
        'filter' =>'',
    ],
    [
        'attribute' => 'departamento_asignado',
        'value' => function($model){
            $depto = Departamento::findOne($model->departamento_asignado);
            return $depto->nombre;
        },
        'filter' => '',
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
        'filter' => '',

        'editableOptions' => [
                                //'format'=>Editable::FORMAT_BUTTON,
                                'inputType'=>Editable::INPUT_DROPDOWN_LIST,
                                'data' => [1 => 'Iniciado', 6 => 'Revisión'],
                                'options' => ['class'=>'form-control'], //, 'prompt'=>'status...'],
                                'displayValueConfig'=> [
                                    //'Iniciado' => '<i class="glyphicon glyphicon-remove"></i>',
                                    //'Concluido' => '<i class="glyphicon glyphicon-ok"></i>',
                                    1 => 'Iniciado',
                                    6 => 'Revisión',
                                    ], 
                              'formOptions' => ['action' => ['/tarea/editest']],
                            ]
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'notas',
    // ],

];
