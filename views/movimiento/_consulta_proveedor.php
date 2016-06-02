<?php

use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;
$this->title = "Consulta Pago a Proveedores";
$this->params['breadcrumbs'][] = 'Reportes / ' . $this->title;
?>


<h1><?=Html::encode($this->title)?></h1><br><br>

<?php $form = ActiveForm::begin();?>

<div class="row">

	<div class="col-md-3">
     <label>Fecha Desde</label>
     <div class="input-group">
      <?=
DatePicker::widget([

	'name' => 'fecha_desde',
	'dateFormat' => 'php:d-m-Y',
	'options' => [
		'class' => 'form-control',
	],
]);
?>
      <span class="input-group-addon glyphicon glyphicon-calendar"></span>
    </div>
	</div>

	<div class="col-md-3">
     <label>Fecha Hasta</label>
     <div class="input-group">
      <?=
DatePicker::widget([

	'name' => 'fecha_hasta',
	'dateFormat' => 'php:d-m-Y',
	'options' => [
		'class' => 'form-control',
	],
]);
?>
      <span class="input-group-addon glyphicon glyphicon-calendar"></span>
    </div>
	</div>

</div><br>

<div class="row">

	<div class="col-md-3"><label>Proveedor</label><?=Html::dropDownList('proveedor', null, $proveedor, ['prompt' => '...', 'class' => 'form-control'])?></div>

</div><br><br>

<div><?=Html::submitButton('Buscar', ['class' => 'btn btn-success'])?></div>


<?php $form = ActiveForm::end();?>