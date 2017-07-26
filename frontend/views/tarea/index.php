<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
use frontend\models\Usuario;
use frontend\models\Ubicacion;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TareasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tareas';
//$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="tareas-index">
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
                if ($r3<=33 and $r3>0) {
                    return ['style' => 'background-color:white'];
                }
                if ($r3>=34 and $r3<=66) {
                  return ['style' => 'background-color:#FFB516'];
                }
                if ($r3>=67) {
                    /*if (date('Y-m-d')>$model->fecha_propuesta_fin) {
                        $customer = Usuario::find()->where(['idTarea',$model->idTarea])->one();
                        $customer->estado= 3;
                        $customer->update();
                    }*/
                  return ['style' => 'background-color:#EC4B28'];
                }
            },
            'pjax'=>true,
            'summary'=>'',
            'columns' => require(__DIR__.'/_columns.php'),
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
                'heading' => '<i class="glyphicon glyphicon-list"></i> Listado de Tareas',
                //'before'=>'<em>*.</em>',
                'after'=>BulkButtonWidget::widget([
                            'buttons'=>Html::a('<i class="glyphicon glyphicon-trash"></i>&nbsp; Borrar Todo',
                                ["bulk-delete"] ,
                                [
                                    "class"=>"btn btn-danger btn-xs",
                                    'role'=>'modal-remote-bulk',
                                    'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                                    'data-request-method'=>'post',
                                    'data-confirm-title'=>'¿Está usted seguro?',
                                    'data-confirm-message'=>'Usted borrará todos las tareas seleccionadas'
                                ]),
                        ]).
                        '<div class="clearfix"></div>',
            ],

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
