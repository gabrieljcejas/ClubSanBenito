<?php
use yii\grid\GridView;
use app\models\MovimientoDetalle;
use yii\helpers\Html;
?>
   <?=GridView::widget([
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'rowOptions' => function ($model) {
        if ($model->fecha_pago == ""  && $model->obs == null) {
            return ['class' => 'danger'];
        }
        /*if ($model->obs != "") {
            return ['class' => 'warning'];
        }*/
    },
    'summary' => '',
    'columns' => [        
        [
            'attribute' => 'Nro Rec.',            
            'value' => function ($model) {
                if ($model->nro_recibo == "") {                    
                    return "-";
                } else {
                    return $model->nro_recibo;
                }
            },
        ],  
        'socio.apellido_nombre',
        [
            'attribute' => 'Concepto',
            'value' => function ($model) {
                $movmd = MovimientoDetalle::find()->where(['movimiento_id'=>$model->id])->all();
                if (!empty($movmd)){
                    foreach ($movmd as $md ) {
                        $conceptos = $md->subCuenta->concepto . " $". $md->importe . " - ". $conceptos;
                    }
                    return $conceptos;
                }else{
                    return "-";
                }
            },
        ],      
        [
            'attribute' => 'Periodo',
            'value' => function ($model) {
                return $model->getPeriodo($model->id);
            },
        ],                    
        [
            'attribute' => 'Imp. Total',
            'format' => 'raw',
            'value' => function ($model) {
                if ($model->fecha_pago == "") {
                    return "$".$model->getImporteTotal($model->id);
                } else {
                   return "$".$model->getImporteTotal($model->id);
                }
            },
        ],
        [
            'attribute' => 'Fecha',
            'format' => 'raw',
            'value' => function ($model) {
                if ($model->fecha_pago == "") {                    
                    return date("d-m-Y");
                } else {
                    return date("d-m-Y", strtotime($model->fecha_pago));
                }
            },
        ],
        [
            'attribute' => 'Estado',
            'format' => 'raw',
            'value' => function ($model) {
                if ($model->fecha_pago == "" && $model->obs == null) {                    
                    return "-";
                }elseif ($model->obs != null) {
                    return "ANULADO";
                }else{
                    return "Pagado";
                }

            },
        ],        
    ],

]);
?>
    <hr>
    <div align="left">
        <h3><strong>Deuda Total: $
        <?php 
            if ($deuda->importe == null) {
                echo "0,00";
            } else {
                echo number_format($deuda->importe, 2, ',', '.');  ;
            }
        ?>
        </strong></h3>        
    </div>
</div>
