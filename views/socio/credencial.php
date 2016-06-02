<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;


$this->title = 'Emitir Credencial';
$this->params['breadcrumbs'][] = ['label' => 'Socios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<h1>Emitir Credencial</h1>

<br>

<div class="row">
    <div class="col-md-2"><?= $form->field($model, 'codigo_desde')->textInput() ?></div>        

    <div class="col-md-2"><?= $form->field($model, 'codigo_hasta')->textInput() ?></div>        
</div>

<div class="row">
    <div class="col-md-6">
        <?= Html::submitButton($model->isNewRecord ? 'Aceptar' : 'Aceptar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?> 



