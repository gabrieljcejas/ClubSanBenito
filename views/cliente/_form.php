<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Cliente */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cliente-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'razon_social')->textInput() ?>

    <?= $form->field($model, 'telefono')->textInput() ?>

    <?= $form->field($model, 'domicilio')->textInput() ?>

    <?= $form->field($model, 'rubro')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'obs')->textArea(['rows' => '4']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
