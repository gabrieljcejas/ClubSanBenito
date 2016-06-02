<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PlanCuentaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="plan-cuenta-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'c1') ?>

    <?= $form->field($model, 'c2') ?>

    <?= $form->field($model, 'c3') ?>

    <?= $form->field($model, 'concepto') ?>

    <?php // echo $form->field($model, 'tipo_cuenta') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
