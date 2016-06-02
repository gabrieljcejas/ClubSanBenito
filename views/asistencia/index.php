<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SocioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Asistencia';
$this->params['breadcrumbs'][] = ['label' => 'Socios', 'url' => ['socio/index']];
$this->params['breadcrumbs'][] = 'Asistencia';
?>
<script type="text/javascript" src="<?=Yii::$app->request->baseUrl?>/js/jquery.min.js"></script>
<div>


    <h1><?=Html::encode($this->title)?></h1>

    <div class="row">
        <div class="col-md-2">Codigo/Dni: <?=Html::input('text', 'dni_codigo', '', ['class' => 'form-control', 'id' => 'dni_codigo'])?></div>
    </div>
    <br>
    <div><?=html::button('Buscar', ['class' => 'btn btn-success', 'id' => 'btn_search'])?></div>
    <br>
    <label id="lb_msj"></label>
    <br>

    <?=

GridView::widget([
'dataProvider' => $dataProvider,
'summary' => '',
'columns' => [
'id',
'socio.apellido_nombre',
  [
    'attribute' => 'fecha_hora',
    'value'     => function ($model) {
        return date("d-m-Y", strtotime($model->fecha_hora));
    },
  ],
],

])
?>

</div>
<script>

    $(function () {
        $('#btn_search').click(function () {
            var dnicodigo = $("#dni_codigo").val();
            //var id_socio = $("#socio-id_socio").val();
            if (dnicodigo == 0) {
                alert("Ingrese un Codigo o Dni");
                $("#dni_codigo").focus();
                return;
            }

            $.ajax({
                type: "POST",
                url: "../web/index.php?r=asistencia/search",
                data: {dni_codigo: $("#dni_codigo").val()},
                success: function (data) {
                     window.location.reload();
                    //$(#lb_msj).val(data.msj);

                    //$.pjax.reload({container: '#grd_asistencia'});
                }
            });


        });
    });

</script>