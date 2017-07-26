<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use frontend\models\Usuario;
use frontend\models\Departamento;
use frontend\models\Status;
use frontend\controllers\TareaController;
use app\controllers\DependentController;
use frontend\models\Ubicacion;

/* @var $this yii\web\View */
/* @var $model frontend\models\Tarea */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tarea-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descripcion_corta')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion_larga')->textInput(['maxlength' => true]) ?>

    <?php
    echo $form->field($model,'ubicacion')->dropDownList(
    ArrayHelper::map(Ubicacion::find()->all(), 'idUbicacion', 'hotel'),
    [
        'prompt' => 'Selecciona...',
        'onchange' => '
            $.post(
                "' . Url::toRoute('getdata2') . '",
                {id: $(this).val()},
                function(data){
                    $("#tarea-departamento_asignado").html(data);
                }
            );
        ',

        ]
        );

    echo $form->field($model, 'departamento_asignado')->dropDownList(
    //ArrayHelper::map(Departamento::find()->all(), 'idDepartamento', 'nombre'),    
    [],
    [
        'prompt' => 'Selecciona...',
        'onchange' => '
            $.post(
                "' . Url::toRoute('getdata') . '",
                {id: $(this).val()},
                function(data){
                    $("#usuario-sel").html(data);
                }
            );
        ',

        ]
    );

      echo $form->field($model, 'asignado_a')->dropDownList(
        [],
        [
            'prompt' => 'Selecciona...',
            'id' => 'usuario-sel'
        ]
    );
?>

    <?= $form->field($model, 'creado_por')->hiddenInput(['readonly'=>true, 'value'=>yii::$app->user->identity->idUsuario])->label(false) ?>

    <?= $form->field($model, 'fecha_inicio')->textInput(['readonly' => true, 'value' => date('Y-m-d'), ]) ?>

    <?= $form->field($model, 'fecha_propuesta_fin')->widget(DatePicker::className(),
    ['pluginOptions' => ['format'=>'yyyy-mm-dd']])?>

    <?= $form->field($model,'estado')->hiddenInput(['readonly'=>true, 'value'=>'1',])-> label(false)?>

    <!--<?= $form->field($model, 'estado')->dropDownList(
        ArrayHelper::map(Status::find()->all(),'idStatus', 'status'),
        ['prompt'=>'Selecciona...']
    )?>-->

    <?= $form->field($model, 'notas')->textInput(['maxlength' => true]) ?>


	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
