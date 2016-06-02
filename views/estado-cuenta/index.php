<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EstadoCuentaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Estado de Cuentas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estado-cuenta-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
   

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'summary'=>'',
         'rowOptions'=>function($model){
            if($model->fecha_pago == ""){
                return ['class' => 'danger'];
            }
        },
        'columns' => [                                    
            [
             'attribute'=>'fecha_vencimiento',   
             'format' =>  ['date', 'php:d-m-Y'],             
            ],            
            [
             'attribute'=>'socio.apellido_nombre',   
             'value'=>'socio.apellido_nombre',  
            ],
            'subCuenta.concepto',
            'periodo_mes',
            'periodo_anio',            
            'importe_apagar',                        
            'fecha_pago',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
