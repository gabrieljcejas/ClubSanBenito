<?php

use app\models\SubCuenta;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Imprimir Cuotas Anticipadas';
$this->params['breadcrumbs'][] = ['label' => 'Socios', 'url' => ['socio/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?=Html::encode($this->title)?></h1><br>

<div class="deuda-form">

    <?php $form = ActiveForm::begin();?>
    

    <div class="row">
        <div class="col-md-2">
             <?=$form->field($model, 'periodo_mes_desde')->dropDownList([
	'1' => 'Enero',
	'2' => 'Febrero',
	'3' => 'Marzo',
	'4' => 'Abril',
	'5' => 'Mayo',
	'6' => 'Junio',
	'7' => 'Julio',
	'8' => 'Agosto',
	'9' => 'Septiembre',
	'10' => 'Octubre',
	'11' => 'Noviembre',
	'12' => 'Diciembre',
],
	['prompt' => 'Selecione un Mes..'])
?>
        </div>
        <div class="col-md-2">
             <?=$form->field($model, 'periodo_mes_hasta')->dropDownList([
	'1' => 'Enero',
	'2' => 'Febrero',
	'3' => 'Marzo',
	'4' => 'Abril',
	'5' => 'Mayo',
	'6' => 'Junio',
	'7' => 'Julio',
	'8' => 'Agosto',
	'9' => 'Septiembre',
	'10' => 'Octubre',
	'11' => 'Noviembre',
	'12' => 'Diciembre',
],
	['prompt' => 'Selecione un Mes..'])
?>
        </div>

    </div>

    <div class="row">

         <div class="col-md-2"><?=$form->field($model, 'periodo_anio')->textInput(['maxlength' => 4, 'placeHolder' => 'año', 'value' => date('Y')])?></div>

    </div>

    <div class="row">
        <div class="col-md-2"><?=$form->field($model, 'socio_desde')->textInput(['value' => 1])?></div>

        <div class="col-md-2"><?=$form->field($model, 'socio_hasta')->textInput(['value' => 99999999])?></div>
    </div>
	<?php $list = ArrayHelper::map(SubCuenta::find()->select('id,concepto')->where(['<', 'codigo', '4.2'])->andWhere(['>', 'codigo', '4.1'])->all(), 'id', 'concepto')?>

    <div class="row">
        <div class="col-md-3"><?=$form->field($model, 'subc_id')->dropDownList($list, ['prompt' => 'Todos'])?></div>
    </div>

    <?=$form->field($model, 'subcuenta_id')->textInput(['value' => 0, 'type' => 'hidden'])?>

    <div class="form-group">
        <?=Html::submitButton($model->isNewRecord ? 'Generar Cuotas' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])?>
        <?php if ($msj != "") {
	?>
        <?=Html::a(' Imprimir', ['imprimir-g-d',		
		'socio_desde' => $model->socio_desde,
		'socio_hasta' => $model->socio_hasta,
		'periodo_mes_desde' => $model->periodo_mes_desde,
		'periodo_mes_hasta' => $model->periodo_mes_hasta,
		'subcuenta_id' => $model->subcuenta_id,
	],
		['class' => 'btn btn-default glyphicon glyphicon-print'])
	?>
         <div class="alert alert-success" role="alert"><?=$msj?></div>
        <?php }
?>
    </div>


    <?php ActiveForm::end();?>

</div>
<!-- Funciones Ajax -->
<script type="text/javascript" src="<?=Yii::$app->request->baseUrl?>/js/jquery.min.js"></script>
<script >

    $(function () {

        $("#estadocuenta-subc_id").change(function () {
            $("#estadocuenta-subcuenta_id").val($(this).val());
        });


    });

</script>