<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PlanCuenta */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="plan-cuenta-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'c1')->textInput() ?>

    <?= $form->field($model, 'c2')->textInput() ?>

    <?= $form->field($model, 'c3')->textInput() ?>

    <?= $form->field($model, 'concepto')->textInput(['maxlength' => 60]) ?>

    <?= $form->field($model, 'tipo_cuenta')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
