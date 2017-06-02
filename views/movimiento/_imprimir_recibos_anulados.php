<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\MovimientoDetalle;
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
?>

<div>
	<h1>Recibos Anulados</h1>
	<label>Fecha desde: <?=date("d-m-Y", strtotime($fecha_desde)) . " hasta " . date("d-m-Y", strtotime($fecha_hasta))?></label>
</div>
<hr><br>
<?=GridView::widget([
		'dataProvider' => $dataProvider,		
		'summary' => '',
		'columns' => [				
			[
				'attribute' => 'Fecha',				
				'value' => function ($model) {
					return date("d-m-Y", strtotime($model->fecha_pago));
				},
			],		
			'nro_recibo',
			[
				'attribute' => 'Razon Social',				
				'value' => function ($model) {
					 if ($model->fk_cliente!=""){
						return $model->socio->apellido_nombre;
					}elseif ($model->cliente_id!=""){
						return $model->cliente->razon_social;
					}else{
						return $model->proveedor->nombre;
					}
				}
			],
			[
				'attribute' => 'Concepto',
				'value' => function ($model) {
					$movmd = MovimientoDetalle::find()->where(['movimiento_id'=>$model->id])->all();							
					if (!empty($movmd)){
						foreach ($movmd as $md ) {
							$conceptos = $md->subCuenta->concepto . "-". $conceptos;
						}
						return $conceptos;
					}else{
						//return "-";
					}
				},
			],
			[
				'attribute' => 'Periodo',
				'value' => function ($model) {
					return $model->getPeriodo($model->id);
				},
			],	
			[
				'attribute' => 'Imp. Total',				
				'value' => function ($model) {
					return "$".$model->getImporteTotal($model->id);
				},
			],			
		],
	]);
?>


