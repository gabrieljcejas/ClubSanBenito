<?php
use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
date_default_timezone_set('America/Buenos_Aires');
$this->title = $accion;
$this->params['breadcrumbs'][] = 'Reportes / ' . $this->title;
?>


<h1>Libro Socio</h1><br>

<?php $form = ActiveForm::begin();?>

<div class="row">
	<div class="col-md-3">
	     <label>Categoria Desde</label>
	     <?=html::input( "text", "categoria_desde", null, ["class"=>"form-control"] ) ?>
    </div>

	<div class="col-md-3">
	 	<label>Categoria Hasta</label> 	
		<?=html::input( "text", "categoria_hasta", null, ["class"=>"form-control"] ) ?>
	</div>
</div><br>
<div class="row">		
	<div class="col-md-3">
		<label>Año</label> 
		<?=html::input( "text", "anio", null, ["class"=>"form-control"] ) ?>
	</div>
</div><br>

<input type="button" id="buscar" name="buscar" value="Buscar" class="btn btn-success"/>

<?php $form = ActiveForm::end();?>


<script type="text/javascript" src="<?=Yii::$app->request->baseUrl?>/js/jquery.min.js"></script>

<script>


$(function () { 
    
   	/*
   	**	VALIDAR CAMPOS
   	**/

	$("#buscar").on( "click", function() {
				
		if ( $( "input[name='categoria_desde']" ).val() == "" ){
			alert("CATEGORIA DESDE: Ingrese un valor.");
			$( "input[name='categoria_desde']" ).focus();
			return false;
		}

		if ( $( "input[name='categoria_hasta']" ).val() == "" ){
			alert("CATEGORIA HASTA: Ingrese un valor.");
			$( "input[name='categoria_hasta']" ).focus();
			return false;
		}


		if ( $( "input[name='anio']" ).val() == "" ){
			alert("AÑO: Ingrese un valor.");
			$( "input[name='anio']" ).focus();
			return false;
		}
		
		$("#buscar").submit();
		
	});

}); 

</script>
