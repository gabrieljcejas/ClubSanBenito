<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProveedorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Proveedores';
$this->params['breadcrumbs'][] = "Tesoreria";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proveedor-index">

    <h1><?=Html::encode($this->title)?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?=Html::a('Crear Proveedor', ['create'], ['class' => 'btn btn-success'])?>
    </p>

    <?=GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			//['class' => 'yii\grid\SerialColumn'],

			'id',
			'nombre',
			'cuit',
			'cond_iva',			

			['class' => 'yii\grid\ActionColumn'],
		],
	]);?>

</div>
