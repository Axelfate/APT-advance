<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;


/* @var $this yii\web\View */
/* @var $searchModel frontend\models\TareaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tareas';
//$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="tarea-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'rowOptions' => function($model){
                $r1=diferenciaDias($model->fecha_propuesta_fin,date('Y-m-d'));
                $r2=diferenciaDias($model->fecha_propuesta_fin, $model->fecha_inicio);
                $r3=(($r2-$r1)*100)/$r2;
                $r3=ceil($r3);
                if ($r3<=69 and $r3>0) {
                    return ['style' => 'background-color:white'];
                }
                if ($r3>=70 and $r3<=99) {
                  return ['style' => 'background-color:#FFB516'];
                }
                if ($r3>=100) {
                  return ['style' => 'background-color:#EC4B28'];
                }
            },
            'pjax'=>true,
            'summary'=>'',
            'columns' => require(__DIR__.'/_columns2.php'),
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'],
                    ['role'=>'modal-remote','title'=> 'Crear nueva tarea','class'=>'btn btn-default']).
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Reset Grid']).
                    //'{toggleData}'.
                    '{export}'
                ],
            ],
            'striped' => true,
            'condensed' => true,
            'responsive' => true,
            'panel' => [
                'type' => 'primary',
                'heading' => '<i class="glyphicon glyphicon-book"></i> Listado de tareas',
                //'before'=>'<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',

            ]
        ])?>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
<?php
    function diferenciaDias($fin, $inicio)
    {
        $inicio = strtotime($inicio);
        $fin = strtotime($fin);
        $dif = $fin - $inicio;
        $diasFalt = (( ( $dif / 60 ) / 60 ) / 24);
        return ceil($diasFalt);
    }
 ?>
