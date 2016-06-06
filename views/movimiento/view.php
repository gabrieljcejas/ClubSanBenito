<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

if ($v == "i") {
	$this->title = "Ingreso";
} else {
	$this->title = "Egreso";
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
    <?=GridView::widget([
	'dataProvider' => $dataProvider,
	//'model' => $model,
	'summary' => '',
	'columns' => [
		[
			'attribute' => 'fecha_pago',
			'value' => function ($model) {
				return date("d-m-Y", strtotime($model->fecha_pago));
			},
		],
		'nro_recibo',
		'socio.apellido_nombre',
		'proveedor.nombre',
		[
			'class' => 'yii\grid\ActionColumn',
			'header' => 'Actions',
			'template' => ' {delete} {imprimir}',
			'buttons' => [
				'delete' => function ($url, $model) {
					return Html::a('<span class="btn btn-default glyphicon glyphicon-trash"></span>', $url, [
						'title' => Yii::t('app', 'Eliminar'),
						'data-confirm' => Yii::t('yii', 'Seguro que desea eliminar?'),
						//'data-method' => 'post',

					]);
				},
				'imprimir' => function ($url, $model) {
					return Html::a('<span class="btn btn-default glyphicon glyphicon-remove"></span>', $url, [
						'data-confirm' => Yii::t('yii', 'Imprimir el Recibo?'),

					]);
				},
			],
			'urlCreator' => function ($action, $model, $key, $index) {
				if ($action === 'imprimir') {
					if ($model->fk_cliente) {
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
]);?>
    <?php Pjax::end();?>

</div>