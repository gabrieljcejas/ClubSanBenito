<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Debito;
/* @var $this yii\web\View */
/* @var $model app\models\SocioDebito */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="socio-debito-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_socio')->textInput() ?>
    
    <?php $listDataDebito = ArrayHelper::map(Debito::find()->all(), 'id', 'concepto'); ?>          
    <?= $form->field($model, 'id_debito')->dropDownList($listDataDebito, ['prompt' => '...']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
