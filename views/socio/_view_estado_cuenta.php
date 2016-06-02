<?php
use yii\grid\GridView;
?>
    <br>
   <?php \yii\widgets\Pjax::begin(['id' => 'grd_ec', 'timeout' => false]);?>
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
		//'movimiento.socio.apellido_nombre',
		'subCuenta.concepto',
		[
			'attribute' => 'periodo_mes',
			'value' => function ($model) {
				return $model->getMes($model->periodo_mes);
			},
		],
		'periodo_anio',
		[
			'attribute' => 'importe',
			'value' => function ($model) {
				return "$ " . $model->importe;
			},
		],
		[
			'attribute' => 'movimiento.fecha_pago',
			'value' => function ($model) {
				if ($model->movimiento->fecha_pago != '') {
					return date("d-m-Y", strtotime($model->movimiento->fecha_pago));
				} else {
					return "-";
				}
			},
		],
		[
			'attribute' => 'Pago',
			'format' => 'raw',
			'value' => function ($model) {
				if ($model->movimiento->fecha_pago != '') {
					return "$ " . $model->importe;
				} else {
					return "$ 0.00";
				}

			},
		],

	],

]);
?>
    <div align="left"><strong>Deuda Total: $
    <?php if ($deuda->importe == null) {
	echo "0.00";
} else {
	echo $deuda->importe;
}
?></strong></div>
    </div>

