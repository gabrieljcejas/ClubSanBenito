<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


$this->title = $model->descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Socios', 'url' => ['socio/index']];
$this->params['breadcrumbs'][] = ['label' => 'Cobradors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cobrador-view">

    <h1><?=Html::encode($this->title)?></h1>

    <p>
        <?=Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary'])?>
        <?=Html::a('Eliminar', ['delete', 'id' => $model->id], [
				'class' => 'btn btn-danger',
				'data' => [
				'confirm' => '¿Seguro que desea eliminar este elemento?',
				'method' => 'post',
			],
		])?>
    </p>

    <?=DetailView::widget([
		'model' => $model,
		'attributes' => [
			'id',
			'descripcion',
			'comision',
		],
	])?>

</div>
