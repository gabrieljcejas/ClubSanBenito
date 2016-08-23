<?php

use yii\bootstrap\Tabs;
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);?>

<div class="socio-view">
	<?=
Tabs::widget([
	'items' => [
		[
			'label' => 'General',
			'content' => $this->render('detail_form', ['model' => $model, 'form' => $form, 'proximoIDSocio' => $proximoIDSocio]),
			//IMPORTANTE SI NO ESTA BIEN EL HTML, NO RENDERISA BIEN, ES DECIR, NO CAMBIA EL TAB
			'active' => true,
		],
		[
			'label' => 'Mas Datos',
			'content' => $this->render('debito_form', ['model' => $modelSD, 'form' => $form, 'dataProviderSocioDebito' => $dataProviderSocioDebito, 'proximoIDSocio' => $proximoIDSocio]),

		],
	],

]);
?>

</div>
<?php ActiveForm::end();?>
