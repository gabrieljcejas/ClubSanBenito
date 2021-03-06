<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\SubCuenta;
/* @var $this yii\web\View */
/* @var $model app\models\Debito */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="debito-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'concepto')->textInput(['maxlength' => 60]) ?>

    <?= $form->field($model, 'importe')->textInput(['maxlength' => 15]) ?>
	
	<?php $list = ArrayHelper::map(SubCuenta::find()->select('id,concepto')->where(['<', 'codigo', '4.2'])->andWhere(['>', 'codigo', '4.1'])->all(), 'id', 'concepto');?>
    
    <?=$form->field($model, 'subcuenta_id')->dropDownList($list, ['prompt' => '...'])?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Agregar' : 'Modificar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
