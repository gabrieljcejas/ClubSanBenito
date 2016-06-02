<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MovimientoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="movimiento-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nro_recibo') ?>

    <?= $form->field($model, 'fecha') ?>

    <?= $form->field($model, 'tipo_comp') ?>

    <?= $form->field($model, 'nro') ?>

    <?php // echo $form->field($model, 'fk_prov') ?>

    <?php // echo $form->field($model, 'fk_cliente') ?>

    <?php // echo $form->field($model, 'fk_sc') ?>

    <?php // echo $form->field($model, 'obs') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
