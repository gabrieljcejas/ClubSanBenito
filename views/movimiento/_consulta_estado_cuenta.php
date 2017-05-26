<?php
use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
date_default_timezone_set('America/Buenos_Aires');
$this->title = $accion;
$this->params['breadcrumbs'][] = 'Reportes / ' . $this->title;
?>


<h1><?=Html::encode($this->title)?></h1><br>

<?php $form = ActiveForm::begin();?>

<div class="row">
	<div class="col-md-3">
	     <label>Periodo Desde</label>
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
	 	<label>Periodo Hasta</label> 	
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
	<div class="col-md-6">
		<label>Deportes</label>
		 	<?=
            	Select2::widget([
	    			'name' => 'deportes',
	                'data' => $deportes,
	                //'language' => 'de',
	                'options' => ['placeholder' => 'Selecione un Deporte ...','id'=>'deporte'],
	                'pluginOptions' => [
	                    'allowClear' => true
	                ],

        		]);
        	?>        
	</div>
</div><br>

<div class="row">
	<div class="col-md-3">
	     <label>Categoria Desde</label>
	     <?=html::input( "text", "categoria_desde", null, ["class"=>"form-control","placeholder"=>"Año"] ) ?>
    </div>

	<div class="col-md-3">
	 	<label>Categoria Hasta</label> 	
		<?=html::input( "text", "categoria_hasta", null, ["class"=>"form-control","placeholder"=>"Año"] ) ?>
	</div>
</div><br>

<div class="row">
	
	<div class="col-md-6">
		<label>Socio</label> 	
        <?=Select2::widget([
            'data' => $socios,
            'name' => 'socio',
            'options' => ['placeholder' => 'Selecione un Socio ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);?>
    </div>

</div>

<br>

<input type="button" id="buscar" name="buscar" value="Buscar" class="btn btn-success"/>

<?php $form = ActiveForm::end();?>


<script type="text/javascript" src="<?=Yii::$app->request->baseUrl?>/js/jquery.min.js"></script>

<script>


$(function () { 
    
   	/*
   	**	VALIDAR CAMPOS
   	**/

	$("#buscar").on( "click", function() {
		
		if ( $( "input[name='fecha_desde']" ).val() == "" ){
			alert("FECHA DESDE: Ingrese un valor.");
			$( "input[name='fecha_desde']" ).focus();
			return false;
		}

		if ( $( "input[name='fecha_hasta']" ).val() == "" ){
			alert("FECHA HASTA: Ingrese un valor.");
			$( "input[name='fecha_hasta']" ).focus();
			return false;
		}
		
		/*if ( $( "#select2-deporte-container" ).prop('title') == "" ){		
			alert("Ingrese un Deporte.");	
			$( "#select2-deporte-container" ).focus();
			return false;
		}*/

		if ( $( "input[name='categoria_hasta']" ).val() == "" ){
			alert("CATEGORIA HASTA: Ingrese un valor.");
			$( "input[name='categoria_hasta']" ).focus();
			return false;
		}

		if ( $( "input[name='categoria_desde']" ).val() == "" ){
			alert("CATEGORIA DESDE: Ingrese un valor.");
			$( "input[name='categoria_desde']" ).focus();
			return false;
		}
		

		$("#buscar").submit();
		
	});

}); 

</script>
