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
	
	<div class="col-md-6">
	 	<?=Html::radio("ep",true,["label"=>"Todo","uncheck"=>false,"data-id"=>1,"class"=>"form-control"])?>
	    
	    <?=Html::radio("ep",false,["label"=>"Pagos","uncheck"=>true,"data-id"=>2,"class"=>"form-control"])?>
	    
	    <?=Html::radio("ep",false,["label"=>"Deudas","uncheck"=>true,"data-id"=>3,"class"=>"form-control"])?>

	    <?=Html::textInput("estado_opcion", 1 ,["id"=>"estado_opcion","type"=>"hidden"] )?>
    </div>

</div><br>
<!--<div class="row">
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
</div><br>-->

<div class="row">
	<div class="col-md-5">
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
	<div class="col-md-5">
		<label>Categorias</label>
		 	<?=
            	Select2::widget([
	    			'name' => 'categorias',
	                'data' => $categorias,
	                //'language' => 'de',
	                'options' => ['placeholder' => 'Selecione una Categoria ...','id'=>'categoria'],
	                'pluginOptions' => [
	                    'allowClear' => true
	                ],
        		]);
        	?>        
	</div>
</div>

<br>

<div><!--<?=Html::Button('Buscar', ['class' => 'btn btn-success','name'=>'buttonSubmit'])?>--></div>

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
		
		//if ( $( ".select2-selection__rendered" ).prop('title') == "" ){		
		if ( $( "#select2-deporte-container" ).prop('title') == "" ){		
			alert("Ingrese un Deporte.");	
			$( "#select2-deporte-container" ).focus();
			return false;
		}

		if ( $( "#select2-categoria-container" ).prop('title') == "" ){
			alert("Ingrese una Categoria.");
			$( "#select2-categoria-container" ).focus();			
			return false;
		}
		

		$("#buscar").submit();
		
	});

    $( "input[type=radio]" ).on( "click", function() {
        var valor = $(this).data("id");                       
        $("#estado_opcion").val(valor);
    }); 

    
    /*$( "#select2-input" ).change(function() {
 		 alert( "Handler for .change() called." );
	});*/

}); 

</script>
