<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
date_default_timezone_set('America/Buenos_Aires');  

$this->title = 'Estado de Cuenta';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="estado-cuenta-index">

    <h1><?=Html::encode($this->title)?></h1>

    <?php $form = ActiveForm::begin(); ?>

          
        <div class="row">

            <div class="col-md-3">
                <label>Nombre</label>
                <?= Html::input('text','nombre',$aSearch['nombre'],['class'=>'form-control','id'=>'nombre']) ?>
            </div>
           
            <div class="col-md-1"> <br>              
                <?= Html::submitButton('BUSCAR',['class'=>'btn btn-success'])?>
            </div>
        </div>
        <br>

    <?php $form = ActiveForm::end(); ?> 

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
        'movimiento.socio.apellido_nombre',
        'subCuenta.concepto',
        [
            'attribute' => 'Periodo',
            'value' => function ($model) {
                return $model->getMes($model->periodo_mes) . "-" . $model->periodo_anio;
            },
        ],      
        [           'attribute' => 'Cuota',
            'value' => function ($model) {
                return "$ " . $model->importe;
            },
        ],
        [
            'attribute' => 'movimiento.fecha_pago',
            'format' => 'raw',
            'value' => function ($model) {
                if ($model->movimiento->fecha_pago == "") {
                    //return "<input type='text' id='fecha_pago" . $model->id . "' class='form-control' value='" . date("d-m-Y") . "'>";
                    return html::input("text", '', date("d-m-Y"), ['id' => 'fecha_pago' . $model->id, 'class' => 'form-control']);
                } else {
                    return date("d-m-Y", strtotime($model->movimiento->fecha_pago));
                }
            },
        ],
        [
            'attribute' => 'Pago',
            'format' => 'raw',
            'value' => function ($model) {

                if ($model->movimiento->fecha_pago == "") {
                    return html::input("text", '', $model->importe, ['id' => 'importe_pago' . $model->id, 'class' => 'form-control']);
                } else {
                    return "$ " . $model->importe;
                }
            },
        ],
        [
            'attribute' => '',
            'format' => 'raw',
            'value' => function ($model) {
                if ($model->movimiento->fecha_pago == "") {
                    //return html::button(' Pagar', ['class' => ' btn btn-success glyphicon glyphicon-ok', 'id' => 'btn_pagar', 'value' => $model->id]);
                    return html::button(' Pagar', ['class' => ' btn btn-success glyphicon glyphicon-ok', 'name' => 'pagar', 'value' => $model->id]);
                    //return Html::a('<span class="btn btn-success glyphicon glyphicon-ok"> Pagar</span>', Url::to(['movimiento/pagar', 'id' => $model->id]),['value'=>$model->id,'name'=>'pagar','id'=>'a-' . $model->id]);
                } else {
                    return "";
                }

            },
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Actions',
            'template' => '{imprimir} {deleted}',
            'buttons' => [
                'imprimir' => function ($url, $model) {          
                    if ($model->movimiento->fecha_pago != "") {
                        return Html::a('<span class="btn btn-default glyphicon glyphicon-print"></span>', $url, [
                            'data-confirm' => Yii::t('yii', 'Imprimir el Recibo?'),
                        ]);
                    }else{
                        return Html::a('<span class="btn btn-default glyphicon glyphicon-print" disabled="disabled"></span>', $url, [
                            'data-confirm' => Yii::t('yii', 'Imprimir el Recibo?'),
                        ]);
                    }
                },
                'deleted' => function ($url, $model) {
                    return Html::a('<span class="btn btn-default glyphicon glyphicon-trash"></span>', $url, [
                        'data-confirm' => Yii::t('yii', 'Seguro que desea Eliminar?'),
                    ]);
                },
            ],
            'urlCreator' => function ($action, $model, $key, $index) {
                if ($action === 'imprimir') {
                    $url = Url::to(['movimiento/imprimir-recibo-ingreso', 'id' => $model->movimiento->id]);
                    return $url;
                }
                if ($action === 'deleted') {
                    $url = Url::to(['movimiento/deleted', 'id' => $model->id]);
                    return $url;
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


   