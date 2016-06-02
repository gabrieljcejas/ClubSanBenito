<?php

use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
$this->title = $accion;
$this->params['breadcrumbs'][] = 'Reportes / ' . $this->title;
?>


<h1><?=Html::encode($this->title)?></h1><br>

<?php $form = ActiveForm::begin();?>

<div class="row">
	<div class="col-md-5">
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
</div><br>

<div class="row">	
	<div class="col-md-5">
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
	<div class="col-md-5">
		<label>Socios</label>		             
            <?=
            	Select2::widget([
	    			'name' => 'socios',
	                'data' => $socios,
	                //'language' => 'de',
	                'options' => ['placeholder' => 'Selecione un Socio ...'],
	                'pluginOptions' => [
	                    'allowClear' => true
	                ],
        		]);
            ?>            
	</div>
</div><br>

<div class="row">
	<div class="col-md-5">
		<label>Categorias</label>
		 	<?=
            	Select2::widget([
	    			'name' => 'categorias',
	                'data' => $categorias,
	                //'language' => 'de',
	                'options' => ['placeholder' => 'Selecione una Categoria ...'],
	                'pluginOptions' => [
	                    'allowClear' => true
	                ],
        		]);
        	?>        
	</div>
</div><br>

<div class="row">
	<div class="col-md-5">
		<label>Deportes</label>
		 	<?=
            	Select2::widget([
	    			'name' => 'deportes',
	                'data' => $deportes,
	                //'language' => 'de',
	                'options' => ['placeholder' => 'Selecione un Deporte ...'],
	                'pluginOptions' => [
	                    'allowClear' => true
	                ],
        		]);
        	?>        
	</div>
</div>

<br>

<div><?=Html::submitButton('Buscar', ['class' => 'btn btn-success'])?></div>


<?php $form = ActiveForm::end();?>