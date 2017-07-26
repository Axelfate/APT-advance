<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\Ubicacion;
use frontend\models\Usuario;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\models\Departamento */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="departamento-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'localizacion')->dropDownList(
        ArrayHelper::map(Ubicacion::find()->all(),'idUbicacion', 'hotel'),
        [
            'prompt'=>'Selecciona...',
            'onchange' => '
                $.post(
                    "' . Url::toRoute('getdata') . '",
                    {id: $(this).val()},
                    function(data){
                        $("#ubi-sel").html(data);
                    }
                );
            ',

        ]
    );

    echo $form->field($model, 'encargado')->dropDownList(
      [],
      [
          'prompt' => 'Selecciona...',
          'id' => 'ubi-sel'
      ]);
    ?>

    <!--<?= $form->field($model, 'encargado')->dropDownList(
        ArrayHelper::map(Usuario::find()->where(['cargo' =>2])->asArray()->all(),'idUsuario', 'nombres'),
        ['prompt'=>'Selecciona...']
    )?>-->

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
