<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DebitoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Debitos';
$this->params['breadcrumbs'][] = ['label' => 'Socios', 'url' => ['socio/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="debito-index">

    <h1><?=Html::encode($this->title)?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?=Html::a('Agregar Debito', ['create'], ['class' => 'btn btn-success'])?>
    </p>

    <?=GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			//['class' => 'yii\grid\SerialColumn'],

			'id',
			'concepto',
			'importe',
			'subCuenta.concepto',

			['class' => 'yii\grid\ActionColumn'],
		],
	]);?>

</div>
