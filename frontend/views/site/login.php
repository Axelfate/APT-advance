<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
//$this->params['breadcrumbs'][] = $this->title;
?>
<center>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Administrador de proyectos Palace</p>

    <div class="row">
        <div class="col-lg-12">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

              <div class="col-lg-4 col-lg-offset-4">
                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
              </div>

              <div class="col-lg-4 col-lg-offset-4">
                <?= $form->field($model, 'password')->passwordInput() ?>
              </div>

              <div class="col-lg-4 col-lg-offset-4">
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
              </div>

              <div class="col-lg-4 col-lg-offset-4">
                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
              </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
</center>
