<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProvinciaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Provincias';
$this->params['breadcrumbs'][] = ['label' => 'Socios', 'url' => ['socio/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="provincia-index">

    <h1><?=Html::encode($this->title)?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?=Html::a('Create Provincia', ['create'], ['class' => 'btn btn-success'])?>
    </p>

    <?=GridView::widget([
'dataProvider' => $dataProvider,
'filterModel' => $searchModel,
'columns' => [
['class' => 'yii\grid\SerialColumn'],

'id',
'descripcion',

['class' => 'yii\grid\ActionColumn'],
],
]);?>

</div>
