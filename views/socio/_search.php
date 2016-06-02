<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SocioSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="socio-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'apellido_nombre') ?>

    <?= $form->field($model, 'cp') ?>

    <?= $form->field($model, 'direccion') ?>

    <?= $form->field($model, 'dni') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'fecha_alta') ?>

    <?php // echo $form->field($model, 'fecha_baja') ?>

    <?php // echo $form->field($model, 'fecha_nacimiento') ?>

    <?php // echo $form->field($model, 'nombre_foto') ?>

    <?php // echo $form->field($model, 'grupo_sanguineo') ?>

    <?php // echo $form->field($model, 'id_categoria_social') ?>

    <?php // echo $form->field($model, 'id_ciudad') ?>

    <?php // echo $form->field($model, 'id_cobrador') ?>

    <?php // echo $form->field($model, 'matricula') ?>

    <?php // echo $form->field($model, 'provincia') ?>

    <?php // echo $form->field($model, 'sexo') ?>

    <?php // echo $form->field($model, 'telefono') ?>

    <?php // echo $form->field($model, 'telefono2') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
