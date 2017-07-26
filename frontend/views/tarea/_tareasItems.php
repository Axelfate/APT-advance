<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\Usuarios;
use app\models\Departamento;
use yii\helpers\ArrayHelper;
use \kartik\editable\Editable;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CountrySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'Tareas';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tareas-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary'=>'', 
        //'filterModel' => $searchModel,
        'columns' => [
                    'descripcion_larga',
                    [
                        'class'=>'\kartik\grid\EditableColumn',
                        'attribute'=>'notas',
                        'editableOptions' => [
                                        'inputType'=>Editable::INPUT_TEXTAREA,
                                        'options' => ['class'=>'form-control'],
                                        //'asPopover' => false,
                                      'formOptions' => ['action' => ['/tarea/editnota']],
                                    ]
                    ],
                ],
            ]); 
        ?>
</div>