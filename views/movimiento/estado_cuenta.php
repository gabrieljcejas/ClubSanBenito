<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\MovimientoDetalle;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

date_default_timezone_set('America/Buenos_Aires');  
$this->title = 'Estado de Cuenta';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="estado-cuenta-index">

    <h1><?=Html::encode($this->title)?></h1><br>

    <?php $form = ActiveForm::begin();?>
        <div class="row">
            <div class="col-md-5">
                <label>Buscar por Socio:</label>
                    <?=
                        Select2::widget([
                            'name' => 'socio',
                            'data' => $listSocios,
                            'value'=> $idSocio,                                                
                            'options' => ['placeholder' => 'Selecione un Socio ...','id'=>'socio'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],

                        ]);
                    ?>        
            </div>
            <div class="col-md-2"><br>
                <?= Html::submitButton(' BUSCAR',['class'=>'btn btn-default glyphicon glyphicon-search'])?>
            </div>
        </div><br>

    
   
   
   <?php \yii\widgets\Pjax::begin(['id' => 'grd_ec', 'timeout' => false]);?>
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
                    return html::button(' Pagar', ['class' => ' btn btn-success glyphicon glyphicon-ok', 'name' => 'pagar', 'value' => $model->id]);
                }elseif ($model->obs != null) {
                    return "ANULADO";
                }else{
                    return "Pagado";
                }

            },
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Actions',
            'template' => '{imprimir} {anular} {deleted}',
            'buttons' => [
                'imprimir' => function ($url, $model) {          
                    if ($model->fecha_pago != "" || $model->obs!=null) {
                        return Html::a('<span class="btn btn-default glyphicon glyphicon-print"> Imprimir</span>', $url, [
                            'data-confirm' => Yii::t('yii', 'Imprimir el Recibo?'),
                            'title'=>"Imprimir"
                        ]);
                    }
                },
                'deleted' => function ($url, $model) {
                    return Html::a('<span class="btn btn-default glyphicon glyphicon-trash"> Eliminar</span>', $url, [
                        'data-confirm' => Yii::t('yii', 'Seguro que desea Eliminar?'),
                        'title'=>"Eliminar"
                    ]);
                },
                'anular' => function ($url, $model) {
                    if ($model->fecha_pago != "" && $model->obs == null) {
                        return Html::a('<span class="btn btn-danger glyphicon glyphicon-remove-sign"> Anular</span>', $url, [
                            'title'=>"Anular",
                            'name'=>'anular',
                            'value'=>$model->id
                        ]);
                    }
                },
            ],
            'urlCreator' => function ($action, $model, $key, $index) {
                if ($action === 'imprimir') {
                    $url = Url::to(['movimiento/imprimir-recibo-ingreso', 'id' => $model->id]);
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


<!-- Funciones Ajax -->
<script type="text/javascript" src="<?=Yii::$app->request->baseUrl?>/js/jquery.min.js"></script>
<script >

$(function () {     
    
    $("button[name='pagar']").click(function () {

        var id = $(this).attr('value');
        
        if (confirm("¿Seguro que desea PAGAR?") == false) {
            return false;
        }          
        
        $(this).prop('disabled', true); 

        $.ajax({
            type: "POST",
            url: "../web/index.php?r=movimiento/pagar",
            data: {
                id: id ,                
            },
            success: function (data) {  
                if ($("select[name='socio']").val()!=""){
                    $(':input[type="submit"]').submit();
                }else{
                    $.pjax.reload({container: '#grd_ec'});
                }

                
            }
        });

    });

     $("a[name='anular']").click(function () {

        var id = $(this).attr('value');
        $(this).prop('disabled', true); 
        if (confirm("¿Seguro que desea ANULAR?") == true) {
            
        } else {
            return false;
        }                 

        $.ajax({
            type: "POST",
            url: "../web/index.php?r=movimiento/anular",
            data: {
                id: id ,                
            },
            success: function (data) {  
                if ($("select[name='socio']").val()!=""){
                    $(':input[type="submit"]').submit();
                }else{
                    $.pjax.reload({container: '#grd_ec'});
                }
            }
        });

    });


});

</script>
    <?php \yii\widgets\Pjax::end();?>
<?php $form = ActiveForm::end();?>