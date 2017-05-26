<?php

use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;
date_default_timezone_set('America/Buenos_Aires');
$this->title = $accion;
$this->params['breadcrumbs'][] = 'Reportes / ' . $this->title;
?>


<h1><?=Html::encode($this->title)?></h1><br>

<?php $form = ActiveForm::begin();?>

<div class="row">

	<div class="col-md-3">
     <label>Fecha Desde</label>
     <div class="input-group">
      	<?=
			DatePicker::widget([
				'name' => 'fecha_desde',
				'value'  => date('d-m-Y'),
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
				'value'  => date('d-m-Y'),
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
	<div class="col-md-3">
	<label>Caja Inicial</label>
	<?= Html::input('text', 'caja_inicial', $value = null, ['class' => 'form-control','placeHolder'=>'Ejemplo: 1000.50']); ?>
	</div>
</div>

<br>

<div><?=Html::submitButton('Buscar', ['class' => 'btn btn-success'])?></div>


<?php $form = ActiveForm::end();?>