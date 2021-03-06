<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\SubCuenta;

$this->title = 'Generar Deuda';
$this->params['breadcrumbs'][] = ['label' => 'Socios', 'url' => ['socio/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?=Html::encode($this->title)?></h1>

<div class="deuda-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fecha_vencimiento')->textInput() ?>

    <?= $form->field($model, 'periodo_mes')->dropDownList([
        'enero'     => 'Enero',
        'febrero'   => 'febrero',
        'marzo'     => 'Marzo',
        'abril'     => 'Abril',
        'mayo'      => 'Mayo',
        'junio'     => 'Junio',
        'julio'     => 'Julio',
        'agosto'    => 'Agosto',
        'septiembre'=> 'Septiembre',
        'octubre'   => 'Octubre',
        'noviembre' => 'Noviembre',
        'diciembre' => 'Diciembre',
        ],
        ['prompt'=>'Selecione un Mes..']) ?>
    
    <?= $form->field($model, 'periodo_anio')->textInput(['maxlength'=>4,'placeHolder'=>'año','value'=>date('Y')]) ?>
    
    <?= $form->field($model, 'socio_desde')->textInput(['value'=>1]) ?>

    <?= $form->field($model, 'socio_hasta')->textInput(['value'=>99999999]) ?>
	
	<?php $list = ArrayHelper::map(SubCuenta::find()->select('id,concepto')->where(['<', 'codigo', '4.2'])->andWhere(['>', 'codigo', '4.1'])->all(), 'id', 'concepto');?>
    
    <?=$form->field($model, 'subcuenta_id')->dropDownList($list, ['prompt' => '--Todos--'])?>

    <div class="form-group">
        <?= Html::submitButton('Generar Deuda', ['class' => 'btn btn-success', 'name' => 'deuda-button']) ?>       
    </div>

    <?php ActiveForm::end(); ?>

</div>
