<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="proveedor-form">

    <?php $form = ActiveForm::begin();?>

    <div class="row">
        <div class="col-md-6"><?=$form->field($model, 'nombre')->textInput(['maxlength' => 80])?></div>
    </div>

     <div class="row">
        <div class="col-md-3">    
            <?=$form->field($model, 'cond_iva')->dropDownList([
                '1' => 'Responsable Inscripto',
                '2' => 'No Responsable',
                '3' => 'Monotributista',
                '4' => 'Exento',
                '5' => 'Consumidor Final'],
                ['prompt' => '...'])
            ?>
        </div>
    </div>  
    
    <div class="row">    
        <div class="col-md-3"><?=$form->field($model, 'cuit')->textInput(['maxlength' => 15])?></div>
    </div>  

    <div class="row">
        <div class="col-md-6"><?=$form->field($model, 'direccion')->textInput(['maxlength' => 80])?></div>
    </div>
    
    <div class="row">

        <div class="col-md-3"><?=$form->field($model, 'telefono')->textInput(['maxlength' => 15])?></div>
    
        <div class="col-md-3"><?=$form->field($model, 'email')->textInput(['maxlength' => 40])?></div>

    </div>

    <div class="row">
        <div class="col-md-6"><?=$form->field($model, 'rubro')->textInput(['maxlength' => 80])?></div>
    </div>

    <div class="form-group">
        <?=Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])?>
    </div>

    <?php ActiveForm::end();?>

</div>

