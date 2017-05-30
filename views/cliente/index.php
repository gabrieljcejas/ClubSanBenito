<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ClienteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clientes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cliente-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!--<p>
        <?= Html::a('Agregar Cliente', ['create2'], ['class' => 'btn btn-success']) ?>
    </p>-->
    <?=html::button('Agregar Cliente', ['value'=>Url::to('index.php?r=cliente/create'),'class' => 'btn btn-success', 'id' => 'agregarcliente'])?>  
    <?php 
        Modal::begin([
            //'header'=>'<h4>Agregar Cliente</h4>',
            'id'=> 'modal',
            'size'=>'modal-lg',
        ]);
        echo "<div id='modalContent'></div>";

        Modal::end();
    ?>     

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            'razon_social',
            'domicilio',
            'telefono',
            //'mail',
            // 'obs',
            // 'rubro',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
<script type="text/javascript" src="<?=Yii::$app->request->baseUrl?>/js/jquery.min.js"></script>

<script>        
    //Modal Button Agregar Cliente
    $("#agregarcliente").on( "click", function() {
       $( "#modal").modal('show').find('#modalContent').load($(this).attr('value'));            
    }); 
</script>