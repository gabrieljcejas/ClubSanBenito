 <?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
date_default_timezone_set('America/Buenos_Aires');        
?>

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
		[			'attribute' => 'Cuota',
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






<!-- Funciones Ajax -->
<script type="text/javascript" src="<?=Yii::$app->request->baseUrl?>/js/jquery.min.js"></script>
<script >

    $(function () {

        /*********** FILTRAR POR ************/
        $('#codigo').bind('keypress', function(e) {
            if(e.keyCode==13){
                $.ajax({
                    type: "POST",
                    url: "../web/index.php?r=movimiento/estado-cuenta-by-codigo",
                    data: {codigo: $("#codigo").val()},
                    success: function (data) {
                        $('#resultado').html(data);
                    }
                });
            }
        });


        $('#nombre').bind('keypress', function(e) {
            if(e.keyCode==13){
                $.ajax({
                    type: "POST",
                    url: "../web/index.php?r=movimiento/estado-cuenta-by-nombre",
                    data: {nombre: $("#nombre").val()},
                    success: function (data) {
                        $('#resultado').html(data);
                    }
                });
            }
        });

        $('#codigo_socio').bind('keypress', function(e) {
            if(e.keyCode==13){
                $.ajax({
                    type: "POST",
                    url: "../web/index.php?r=movimiento/estado-cuenta-by-codigo-socio",
                    data: {codigo_socio: $("#codigo_socio").val()},
                    success: function (data) {
                        $('#resultado').html(data);
                    }
                });
            }
        });

        $('#deuda').click(function () {
            $.ajax({
                type: "POST",
                url: "../web/index.php?r=movimiento/estado-cuenta-deuda",
                //data: {},
                success: function (data) {
                    $('#resultado').html(data);
                }
            });

        });

        $('#todos').click(function () {
            $.ajax({
                type: "POST",
                url: "../web/index.php?r=movimiento/estado-cuenta-todos",
                //data: {},
                success: function (data) {
                    $('#resultado').html(data);
                }
            });

        });

        /*********** FIN FILTRAR POR ************/
        $("button[name='pagar']").click(function () {

            var id = $(this).attr('value');

            $.ajax({
                type: "POST",
                url: "../web/index.php?r=movimiento/pagar",
                data: {
                    id: id ,
                    fecha_pago: $("#fecha_pago"+id).val(),
                    importe_pago: $("#importe_pago"+id).val(),
                },
                success: function (data) {
                    $.pjax.reload({container: '#grd_ec'});
                    //location.reload()
                }
            });

        });


        $('#btn_imprimir').click(function () {

            var myObj = [];

            $(":checkbox:checked").each(function () {
                    myObj.push({
                    id:$(this).val()
                    });
            });
            var json = JSON.stringify(myObj);
            if (json == "[]"){
                alert("Selecione lo que va a imprimir");
                return;
            }
            $.ajax({
                type: "POST",
                url: "../web/index.php?r=movimiento/imprimir-e-c",
                data: { arr : json },//JSON.stringify(myObj),
                dataType: "json",
                success: function (data) {
                     //$.pjax.reload({container: '#grd_ec'});
                }
            });

        });




    });

</script>
 <?php \yii\widgets\Pjax::end();?>