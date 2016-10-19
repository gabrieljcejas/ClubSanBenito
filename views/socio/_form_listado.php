<?php
use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
$this->title = "Listado de Socios";
$this->params['breadcrumbs'][] = 'Reportes / ' . $this->title;
?>


<h1><?=Html::encode($this->title)?></h1><br>

<?php $form = ActiveForm::begin();?>
	
	
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

		<div class="col-md-2">
		    
		    <?=Html::radio("check",true,["label"=>"Socios Activos","uncheck"=>true,"value"=>1,'class'=>'form-control'])?>

		</div>                            

	    <div class="col-md-2">
	        
	        <?=Html::radio("check",false,["label"=>"Socios dados de Baja","uncheck"=>true,"value"=>0,'class'=>'form-control'])?>

	    </div>    

    </div><br> <br>
	<input type="button" id="buscar" name="buscar" value="Buscar" class="btn btn-success"/>

<?php $form = ActiveForm::end();?>


<script type="text/javascript" src="<?=Yii::$app->request->baseUrl?>/js/jquery.min.js"></script>

<script>


$(function () { 
    
   	/*
   	**	VALIDAR CAMPOS
   	**/

	$("#buscar").on( "click", function() {
						
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
