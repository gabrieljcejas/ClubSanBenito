<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use app\models\MovimientoDetalle;

if ($v == "i") {
	$this->title = "Ingresos";
} else {
	$this->title = "Egresos";
}
//$this->params['breadcrumbs'][] = ['label' => 'Tesoreria', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Tesoreria";
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = "Listado";
?>
<div class="movimiento-view">

    <h1><?=Html::encode($this->title)?></h1><br>
    <?=Html::a("Agregar " . $this->title, ['index', 'v' => $v], [
	'class' => ' btn btn-success',
])?>
            <br><br>
<?php Pjax::begin();?>

    <?php if ($v=='i'){ ?>
	    
	    <?=GridView::widget([
				'dataProvider' => $dataProvider,
				//'model' => $model,
				'summary' => '',
				'columns' => [		
					'nro_recibo',
					[
						'attribute' => 'Socio/Cliente',
						'value' => function ($model) {
							 if ($model->fk_cliente!=""){
								return $model->socio->apellido_nombre;
							}else{
								return $model->cliente->razon_social;
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
						'attribute' => 'fecha_pago',
						'value' => function ($model) {
							return date("d-m-Y", strtotime($model->fecha_pago));
						},
					],	
					[
						'attribute' => 'Importe',
						'value' => function ($model) {
							return "$".$model->getImporteTotal($model->id);
						},
					],	
					[
						'attribute' => 'Periodo',
						'value' => function ($model) {
							return $model->getPeriodo($model->id);
						},
					],								
					[
						'class' => 'yii\grid\ActionColumn',
						'header' => 'Actions',
						'template' => '{imprimir} {delete}',
						'buttons' => [				
							'imprimir' => function ($url, $model) {
								return Html::a('<span class="btn btn-default glyphicon glyphicon-print"></span>', $url, [
									'data-confirm' => Yii::t('yii', 'Imprimir el Recibo?'),

								]);
							},
							'delete' => function ($url, $model) {
								return Html::a('<span class="btn btn-default glyphicon glyphicon-trash"></span>', $url, [
									'title' => Yii::t('app', 'Eliminar'),
									'data-confirm' => Yii::t('yii', 'Seguro que desea eliminar?'),
									//'data-method' => 'post',

								]);
							},
						],
						'urlCreator' => function ($action, $model, $key, $index) {
							if ($action === 'imprimir') {
								if ($model->fk_cliente || $model->cliente_id ) {
									$url = Url::to(['movimiento/imprimir-recibo-ingreso', 'id' => $model->id]);
									return $url;
								} else {
									$url = Url::to(['movimiento/imprimir-recibo-egreso', 'id' => $model->id]);
									return $url;
								}
							}
							if ($action === 'delete') {
								$url = Url::to(['movimiento/delete', 'id' => $model->id]);
								return $url;
							}
						},
					],
				],
			]);
		?>

	<?php } ?>

	 <?php if ($v=='e'){ ?>
	    
	    <?=GridView::widget([
				'dataProvider' => $dataProvider,
				//'model' => $model,
				'summary' => '',
				'columns' => [		
					'nro_recibo',							
					'proveedor.nombre',		
					[
						'attribute' => 'fecha_pago',
						'value' => function ($model) {
							return date("d-m-Y", strtotime($model->fecha_pago));
						},
					],
					[
						'attribute' => 'Importe',
						'value' => function ($model) {
							return "$".$model->getImporteTotal($model->id);
						},
					],	
					[
						'attribute' => 'Periodo',
						'value' => function ($model) {
							return $model->getPeriodo($model->id);
						},
					],	
					[
						'class' => 'yii\grid\ActionColumn',
						'header' => 'Actions',
						'template' => '{imprimir} {delete}',
						'buttons' => [				
							'imprimir' => function ($url, $model) {
								return Html::a('<span class="btn btn-default glyphicon glyphicon-print"></span>', $url, [
									'data-confirm' => Yii::t('yii', 'Imprimir el Recibo?'),

								]);
							},
							'delete' => function ($url, $model) {
								return Html::a('<span class="btn btn-default glyphicon glyphicon-trash"></span>', $url, [
									'title' => Yii::t('app', 'Eliminar'),
									'data-confirm' => Yii::t('yii', 'Seguro que desea eliminar?'),
									//'data-method' => 'post',

								]);
							},
						],
						'urlCreator' => function ($action, $model, $key, $index) {
							if ($action === 'imprimir') {
								if ($model->fk_cliente || $model->cliente_id ) {
									$url = Url::to(['movimiento/imprimir-recibo-ingreso', 'id' => $model->id]);
									return $url;
								} else {
									$url = Url::to(['movimiento/imprimir-recibo-egreso', 'id' => $model->id]);
									return $url;
								}
							}
							if ($action === 'delete') {
								$url = Url::to(['movimiento/delete', 'id' => $model->id]);
								return $url;
							}
						},
					],
				],
			]);
		?>

	<?php } ?>
<?php Pjax::end();?>

</div>
