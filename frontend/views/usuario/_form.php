<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\models\Ubicacion;
use frontend\models\Departamento;
use frontend\models\Tipousuario;

/* @var $this yii\web\View */
/* @var $model frontend\models\Usuario */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuario-form">

    <?php $form = ActiveForm::begin(); ?>

     <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nombres')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'apellidos')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'establecimiento')->dropDownList(
        ArrayHelper::map(Ubicacion::find()->all(),'idUbicacion', 'hotel'),
        ['prompt'=>'Selecciona...']
    )?>

    <?= $form->field($model, 'pertenece_departamento')->dropDownList(
        ArrayHelper::map(Departamento::find()->all(),'idDepartamento', 'nombre'),
        ['prompt'=>'Selecciona...']
    )?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cargo')->dropDownList(
        ArrayHelper::map(Tipousuario::find()->all(),'idTipo', 'tipo'),
        ['prompt'=>'Selecciona...']
    )?>


	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
