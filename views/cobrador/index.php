<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CobradorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cobradors';
$this->params['breadcrumbs'][] = ['label' => 'Socios', 'url' => ['socio/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cobrador-index">

    <h1><?=Html::encode($this->title)?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?=Html::a('Create Cobrador', ['create'], ['class' => 'btn btn-success'])?>
    </p>

    <?=GridView::widget([
'dataProvider' => $dataProvider,
'filterModel' => $searchModel,
'columns' => [
['class' => 'yii\grid\SerialColumn'],

'id',
'descripcion',
'comision',

['class' => 'yii\grid\ActionColumn'],
],
]);?>

</div>
