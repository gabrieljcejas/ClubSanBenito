<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EstadoCuenta */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="estado-cuenta-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fecha_vencimiento')->textInput() ?>

    <?= $form->field($model, 'periodo_mes')->textInput(['maxlength' => 15]) ?>

    <?= $form->field($model, 'periodo_anio')->textInput() ?>

    <?= $form->field($model, 'subcuenta_id')->textInput() ?>

    <?= $form->field($model, 'socio_id')->textInput() ?>

    <?= $form->field($model, 'fecha_pago')->textInput() ?>

    <?= $form->field($model, 'importe_apagar')->textInput(['maxlength' => 15]) ?>

    <?= $form->field($model, 'importe_pagado')->textInput(['maxlength' => 15]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
