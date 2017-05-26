<?php

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Cobradores';
$this->params['breadcrumbs'][] = ['label' => 'Socios', 'url' => ['socio/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cobrador-index">

    <h1><?=Html::encode($this->title)?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?=Html::a('Crear Cobrador', ['create'], ['class' => 'btn btn-success'])?>
    </p>

    <?=GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			//['class' => 'yii\grid\SerialColumn'],

			'id',
			'descripcion',
			'comision',

			['class' => 'yii\grid\ActionColumn'],
		],
	]);?>

</div>
