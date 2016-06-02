<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SocioDebitoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Socio Debitos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="socio-debito-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Socio Debito', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_socio',
            'id_debito',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
