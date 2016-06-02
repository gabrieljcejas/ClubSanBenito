<?php

use app\models\SubCuenta;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PlanCuentaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Plan Cuentas';
$this->params['breadcrumbs'][] = "Tesoreria";
$this->params['breadcrumbs'][] = $this->title;
?>
<!--<link rel="stylesheet" src="<?=Yii::$app->request->baseUrl?>/css/treeview.css"/>-->
<head>
        <meta charset="utf-8" />
        <title>CSS3 Treeview. No JavaScript by Martin Ivanov</title>
        <style>
        /*
         * CSS3 Treeview. No JavaScript
         * @version 1.0
         * @author Martin Ivanov
         * @url developer's website: http://wemakesites.net/
         * @url developer's twitter: https://twitter.com/#!/wemakesitesnet
         * @url developer's blog http://acidmartin.wordpress.com/
         **/

        /*
         * This solution works with all modern browsers and Internet Explorer 9+.
         * If you are interested in purchasing a JavaScript enabler for IE8
         * for the CSS3 Treeview, please, check this link:
         * http://experiments.wemakesites.net/miscellaneous/acidjs-css3-treeview/
         **/

        .css-treeview ul,
        .css-treeview li
        {
            padding: 0;
            margin: 0;
            list-style: none;
        }

        .css-treeview input
        {
            position: absolute;
            opacity: 0;
        }

        .css-treeview
        {
            font: normal 14px "Helvetica Neue", Helvetica, Arial, sans-serif;
            -moz-user-select: none;
            -webkit-user-select: none;
            user-select: none;
        }

        .css-treeview a
        {
            color: #00f;
            text-decoration: none;
        }

        .css-treeview a:hover
        {
            text-decoration: underline;
        }

        .css-treeview input + label + ul
        {
            margin: 0 0 0 22px;
        }

        .css-treeview input ~ ul
        {
            display: none;
        }

        .css-treeview label,
        .css-treeview label::before
        {
            cursor: pointer;
        }

        .css-treeview input:disabled + label
        {
            cursor: default;
            opacity: .6;
        }

        .css-treeview input:checked:not(:disabled) ~ ul
        {
            display: block;
        }

        .css-treeview label,
        .css-treeview label::before
        {
            background: url("/club/web/img/icons.png") no-repeat;
        }

        .css-treeview label,
        .css-treeview a,
        .css-treeview label::before
        {
            display: inline-block;
            height: 16px;
            line-height: 16px;,
            vertical-align: middle;
        }

        .css-treeview label
        {
            background-position: 18px 0;
        }

        .css-treeview label::before
        {
            content: "";
            width: 16px;
            margin: 0 22px 0 0;
            vertical-align: middle;
            background-position: 0 -32px;
        }

        .css-treeview input:checked + label::before
        {
            background-position: 0 -16px;
        }

        /* webkit adjacent element selector bugfix */
        @media screen and (-webkit-min-device-pixel-ratio:0)
        {
            .css-treeview
            {
                -webkit-animation: webkit-adjacent-element-selector-bugfix infinite 1s;
            }

            @-webkit-keyframes webkit-adjacent-element-selector-bugfix
            {
                from
                {
                    padding: 0;
                }
                to
                {
                    padding: 0;
                }
            }
        }
        </style>
    </head>

<div class="plan-cuenta-index">

    <h1><?=Html::encode($this->title)?></h1>
    <?=Html::a('Agregar Cuenta', ['#'], ['class' => 'btn btn-info', 'data-toggle' => 'modal', 'data-target' => '#myModalCuenta'])?>&nbsp;&nbsp;&nbsp;
    <?=Html::a('Agregar SubCuenta', ['#'], ['class' => 'btn btn-primary', 'data-toggle' => 'modal', 'data-target' => '#myModalSubCuenta'])?>&nbsp;&nbsp;&nbsp;
    <?=html::button('Eliminar SubCuenta', ['class' => 'btn btn-danger', 'id' => 'btnEliminarSC'])?>
    <br><br>
    <div class="css-treeview">
    <ul>
    <?php foreach ($cuenta as $c) {
	//RECORRE LAS CUENTAS ?>

        <li>
            <input type="checkbox" id="item-<?=$c->codigo?>" value="<?=$c->codigo?>" />
            <label id="<?=$c->codigo?>" for="item-<?=$c->codigo?>"><?=$c->codigo . " " . $c->concepto?> </label>
            <ul>
            <?php
$subCuentas = SubCuenta::find()->where(['=', 'id_cuenta', $c->id])->all();

	foreach ($subCuentas as $sc) {
		$mSubCuenta->recursividad($sc);
	}
	?>
            </ul>
        </li>

    <?php }
?>

    </ul>
    </div>
    <br><br>




</div>


<!-- Modal Cuenta -->
<div id="myModalCuenta" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content -->
    <div class="modal-content">
    <?php $form = ActiveForm::begin();?>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Agregar Cuenta</h4>
      </div>
      <div class="modal-body">
        <?php
$c = $mCuenta->getLastId();
$proximoId = $c->codigo + 1;
?>
        <?=$form->field($mCuenta, 'codigo')->textInput(['value' => $proximoId, 'readOnly' => 'readOnly'])?>
        <?=$form->field($mCuenta, 'concepto')->textInput()?>
        <!--<?=$form->field($mCuenta, 'tipo_cuenta')->textInput()?>-->
      </div>
      <div class="modal-footer">
        <?=html::button('Aceptar', ['class' => 'btn btn-success', 'id' => 'btnAgregarCuenta'])?>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>

  </div>
</div>


<!-- Modal SubCuenta -->
<div id="myModalSubCuenta" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content -->
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Agregar SubCuenta</h4>
      </div>
      <div class="modal-body">

        <label>Cuenta</label><input class="form-control" id="vdesc" readonly="readOnly" />

        <?=$form->field($mSubCuenta, 'codigo')->textInput(); //->textInput(['readOnly' => 'readOnly'])?>

        <?=$form->field($mSubCuenta, 'concepto')->textInput()?>

        <?=$form->field($mSubCuenta, 'id_cuenta')->textInput(['type' => 'hidden'])?>

      </div>
      <div class="modal-footer">
        <?=html::button('Aceptar', ['class' => 'btn btn-success', 'id' => 'btnAgregarSubCuenta'])?>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
    <?php $form = ActiveForm::end();?>
  </div>
</div>

<!-- Funciones Ajax -->
<script type="text/javascript" src="<?=Yii::$app->request->baseUrl?>/js/jquery.min.js"></script>
<script >

    $(function () {

        $("label").css("background","#ffffff");

        $("label").click(function () {
          $("label").css("background","#ffffff");
          $(this).css("background","#337AB7");
        });

        $("input[type=checkbox]").click(function () {

                $("#vdesc").val($("label[for='item-" + $(this).val() + "']").text());
                $("#subcuenta-id_cuenta").val($(this).val());
                $("#subcuenta-codigo").val("");
                $.ajax({
                type: "POST",
                url: "../web/index.php?r=cuenta/ultima-sc",
                data: {codigo_sc: $(this).val()},
                success: function (data) {
                    //window.location.reload();
                    $("#subcuenta-codigo").val(data);
                }
            });
            });


        $('#btnAgregarCuenta').click(function () {

            $.ajax({
                type: "POST",
                url: "../web/index.php?r=cuenta/create",
                data: {codigo: $("#cuenta-codigo").val(), concepto: $("#cuenta-concepto").val()},
                success: function (data) {
                    window.location.reload();
                }
            });

        });

        $('#btnAgregarSubCuenta').click(function () {

            if  ($("#subcuenta-id_cuenta").val()==""){
                alert("Seleccione un Cuenta o SubCuenta antes de Agregar");
            }

            $.ajax({
                type: "POST",
                url: "../web/index.php?r=cuenta/create-sc",
                data: {codigo: $("#subcuenta-codigo").val(), concepto: $("#subcuenta-concepto").val(),id_cuenta: $("#subcuenta-id_cuenta").val()},
                success: function (data) {
                    window.location.reload();
                }
            });

        });

        $('#btnEliminarSC').click(function () {
            if  ($("#subcuenta-id_cuenta").val()==""){
                alert("Seleccione una Cuenta o SubCuenta antes de Eliminar");
            }
            $.ajax({
                type: "POST",
                url: "../web/index.php?r=cuenta/eliminar-s-c",
                data: {subcuenta_codigo: $("#subcuenta-id_cuenta").val() },
                success: function (data) {
                    window.location.reload();
                    alert("La Cuenta/SubCuenta fue Eliminada con exito");
                }
            });

        });

        $(".acidjs-css3-treeview").delegate("label input:checkbox", "change", function() {
            var
                checkbox = $(this),
                nestedList = checkbox.parent().next().next(),
                selectNestedListCheckbox = nestedList.find("label:not([for]) input:checkbox");

            if(checkbox.is(":checked")) {
                return selectNestedListCheckbox.prop("checked", true);
            }
            selectNestedListCheckbox.prop("checked", false);
        });



    });

</script>
