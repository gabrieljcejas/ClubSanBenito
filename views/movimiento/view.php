<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use app\models\MovimientoDetalle;

if ($v == "i") {
	$this->title = "Ingreso";
} else {
	$this->title = "Egreso";
}
//$this->params['breadcrumbs'][] = ['label' => 'Tesoreria', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Tesoreria";
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = "Listado";
?>
<div class="movimiento-view">

    <h1><?=Html::encode($this->title)?></h1><br>
    <?=Html::a("Nuevo " . $this->title, ['index', 'v' => $v], [
	'class' => ' btn btn-success',
])?>
            <br><br>
<?php Pjax::begin(['id' => 'grd_view', 'timeout' => false]);?>

    <?php if ($v=='i'){ ?>
	    
	    <?=GridView::widget([
				'dataProvider' => $dataProvider,
				//'model' => $model,
				'summary' => '',
				'columns' => [		
					'nro_recibo',
					[
						'attribute' => 'Socio/Cliente',
						'value' => function ($model) {
							 if ($model->fk_cliente!=""){
								return $model->socio->apellido_nombre;
							}else{
								return $model->cliente->razon_social;
							}
						}
					],
					[
						'attribute' => 'Concepto',
						'value' => function ($model) {
							$movmd = MovimientoDetalle::find()->where(['movimiento_id'=>$model->id])->all();							
							if (!empty($movmd)){
								foreach ($movmd as $md ) {
									$conceptos = $md->subCuenta->concepto . "-". $conceptos;
								}
								return $conceptos;
							}else{
								//return "-";
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
						'value' => function ($model) {
							return "$".$model->getImporteTotal($model->id);
						},
					],						
					[
						'attribute' => 'Fecha',
						'value' => function ($model) {
							return date("d-m-Y", strtotime($model->fecha_pago));
						},
					],	
					[
			            'attribute' => 'Estado',
			            'format' => 'raw',
			            'value' => function ($model) {
			                
			                if ($model->obs != null) {
			                    return "ANULADO";
			                }else{
			                    return "Pagado";
			                }

			            },
			        ],
												
					[
						'class' => 'yii\grid\ActionColumn',
						'header' => 'Actions',
						'template' => '{imprimir} {anular}',
						'buttons' => [				
							'imprimir' => function ($url, $model) {
								return Html::a('<span class="btn btn-default glyphicon glyphicon-print"> Imprimir</span>', $url, [
									'data-confirm' => Yii::t('yii', 'Imprimir el Recibo?'),

								]);
							},
							'delete' => function ($url, $model) {
								return Html::a('<span class="btn btn-default glyphicon glyphicon-trash"> Eliminar</span>', $url, [
									'title' => Yii::t('app', 'Eliminar'),
									'data-confirm' => Yii::t('yii', 'Seguro que desea eliminar?'),
									//'data-method' => 'post',

								]);
							},
							'anular' => function ($url, $model) {
			                    if ($model->obs == null) {
			                        return Html::a('<span class="btn btn-danger glyphicon glyphicon-remove-sign"> Anular</span>', $url, [
			                            'title'=>"Anular",
			                            'name'=>'anular',
			                            'value'=>$model->id
			                        ]);
			                    }else{
			                         return Html::a('<span class="btn btn-danger glyphicon glyphicon-remove-sign disabled"> Anular</span>', null, [
			                            //'data-confirm' => Yii::t('yii', 'Seguro que desea ANULAR?'),
			                            'title'=>"Anular"                           
			                        ]);
			                    }
			                },
						],
						'urlCreator' => function ($action, $model, $key, $index) {
							if ($action === 'imprimir') {
								if ($model->fk_cliente || $model->cliente_id ) {
									$url = Url::to(['movimiento/imprimir-recibo-ingreso', 'id' => $model->id]);
									return $url;
								} else {
									$url = Url::to(['movimiento/imprimir-recibo-egreso', 'id' => $model->id]);
									return $url;
								}
							}
							if ($action === 'delete') {
								$url = Url::to(['movimiento/delete', 'id' => $model->id]);
								return $url;
							}							
						},
					],
				],
			]);
		?>

	<?php } ?>

	 <?php if ($v=='e'){ ?>
	    
	    <?=GridView::widget([
				'dataProvider' => $dataProvider,
				//'model' => $model,
				'summary' => '',
				'columns' => [		
					'nro_recibo',							
					'proveedor.nombre',		
					[
						'attribute' => 'Concepto',
						'value' => function ($model) {
							$movmd = MovimientoDetalle::find()->where(['movimiento_id'=>$model->id])->all();							
							if (!empty($movmd)){
								foreach ($movmd as $md ) {
									$conceptos = $md->subCuenta->concepto . "-". $conceptos;
								}
								return $conceptos;
							}else{
								//return "-";
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
						'value' => function ($model) {
							return "$".$model->getImporteTotal($model->id);
						},
					],						
					[
						'attribute' => 'Fecha',
						'value' => function ($model) {
							return date("d-m-Y", strtotime($model->fecha_pago));
						},
					],	
					[
			            'attribute' => 'Estado',
			            'format' => 'raw',
			            'value' => function ($model) {
			                
			                if ($model->obs != null) {
			                    return "ANULADO";
			                }else{
			                    return "Pagado";
			                }

			            },
			        ],
					
					[
						'class' => 'yii\grid\ActionColumn',
						'header' => 'Actions',
						'template' => '{imprimir} {anular}',
						'buttons' => [				
							'imprimir' => function ($url, $model) {
								return Html::a('<span class="btn btn-default glyphicon glyphicon-print"> Imprimir</span>', $url, [
									'data-confirm' => Yii::t('yii', 'Imprimir el Recibo?'),

								]);
							},
							'delete' => function ($url, $model) {
								return Html::a('<span class="btn btn-default glyphicon glyphicon-trash"></span>', $url, [
									'title' => Yii::t('app', 'Eliminar'),
									'data-confirm' => Yii::t('yii', 'Seguro que desea eliminar?'),
									//'data-method' => 'post',

								]);
							},
							'anular' => function ($url, $model) {
			                    if ($model->obs == null) {
			                        return Html::a('<span class="btn btn-danger glyphicon glyphicon-remove-sign"> Anular</span>', $url, [
			                            'title'=>"Anular",
			                            'name'=>'anular',
			                            'value'=>$model->id
			                        ]);
			                    }else{
			                         return Html::a('<span class="btn btn-danger glyphicon glyphicon-remove-sign disabled"> Anular</span>', null, [
			                            //'data-confirm' => Yii::t('yii', 'Seguro que desea ANULAR?'),
			                            'title'=>"Anular"                           
			                        ]);
			                    }
			                },
						],
						'urlCreator' => function ($action, $model, $key, $index) {
							if ($action === 'imprimir') {
								if ($model->fk_cliente || $model->cliente_id ) {
									$url = Url::to(['movimiento/imprimir-recibo-ingreso', 'id' => $model->id]);
									return $url;
								} else {
									$url = Url::to(['movimiento/imprimir-recibo-egreso', 'id' => $model->id]);
									return $url;
								}
							}
							if ($action === 'delete') {
								$url = Url::to(['movimiento/delete', 'id' => $model->id]);
								return $url;
							}							
						},
					],
				],
			]);
		?>

	<?php } ?>


<!-- Funciones Ajax -->
<script type="text/javascript" src="<?=Yii::$app->request->baseUrl?>/js/jquery.min.js"></script>
<script >

$(function () {     

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
            	$.pjax.reload({container: '#grd_view'});
                
            }
        });

    });


});

</script>

<?php Pjax::end();?>

</div>
