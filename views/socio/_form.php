<?php

use yii\bootstrap\Tabs;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);?> 
<?=Html::submitButton($model->isNewRecord ? 'Guardar Socio' : 'Modificar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])?><br></br> 	
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
				'content' => $this->render('debito_form', ['modelSD' => $modelSD, 'form' => $form, 'dataProviderSocioDebito' => $dataProviderSocioDebito, 'proximoIDSocio' => $proximoIDSocio,'model'=>$model]),

			],
		],

	]);
?>

</div>



<?php ActiveForm::end();?>
