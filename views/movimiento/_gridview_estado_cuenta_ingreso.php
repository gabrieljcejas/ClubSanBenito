 <?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
date_default_timezone_set('America/Buenos_Aires');        
?>
<h3>Estado de Cuenta</h3>

<div class="row">
<div class="col-md-6">
   <?=GridView::widget([
	'dataProvider' => $dataProvider,
	//'filterModel' => $searchModel,
	'rowOptions' => function ($model) {
		if ($model->movimiento->fecha_pago == "") {
			return ['class' => 'danger'];
		}
	},
	'summary' => '',
	'columns' => [		
		'subCuenta.concepto',
		[
			'attribute' => 'Periodo',
			'value' => function ($model) {
				return $model->getMes($model->periodo_mes)." ".$model->periodo_anio;
			},
		],
		[
			'attribute' => 'Cuota',
			'value' => function ($model) {
				return "$ " . $model->importe;
			},
		],
		[
			'attribute' => 'movimiento.fecha_pago',
			'format' => 'raw',
			'value' => function ($model) {
				if ($model->movimiento->fecha_pago == "") {
					return "-";
				} else {
					return date("d-m-Y", strtotime($model->movimiento->fecha_pago));
				}
			},
		],
		[
			'attribute' => 'Importe',
			'format' => 'raw',
			'value' => function ($model) {
				if ($model->movimiento->fecha_pago == "") {
					return "-";
				} else {
					return "$ " . $model->importe;
				}
			},
		],		
	],

]);
?>
</div>
</div>
	
    <div align="left"><strong>Deuda Total: $
    <?php if ($deuda->importe == null) {
			echo "0.00";
		} else {
			echo $deuda->importe;
		}
	?></strong>	
	</div>
	<?=
      Html::a(' Estado Cuenta', ['socio/imprimir-estado-cuenta', 'id' => $socio_id], [
      	'class' => ' btn btn-default glyphicon glyphicon-print',      	 
      	'target'=>'_blank',
      ])
    ?>

</div>


