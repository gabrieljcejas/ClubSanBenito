<?php

use yii\bootstrap\Tabs;

?>

<div class="socio-view">

    <?=
Tabs::widget([
	'items' => [
		[
			'label' => 'Datos',
			'content' => $this->render('detail_form', ['model' => $model, 'form' => $form, 'proximoIDSocio' => $proximoIDSocio]),
			//IMPORTANTE SI NO ESTA BIEN EL HTML, NO RENDERISA BIEN, ES DECIR, NO CAMBIA EL TAB
			'active' => true,
		],
		[
			'label' => 'Debitos',
			'content' => $this->render('debito_form', ['model' => $modelSD, 'form' => $form, 'dataProviderSocioDebito' => $dataProviderSocioDebito, 'proximoIDSocio' => $proximoIDSocio]),

		],
	],

]);
?>

</div>

