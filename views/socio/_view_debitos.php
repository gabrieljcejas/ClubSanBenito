<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<br>
<div class="col-md-6">    
	<?=
	GridView::widget([
		'dataProvider' => $dataProviderSocioDebito,
		'summary' => '',
		'columns' => [
			'debito.concepto',
			'debito.importe',		
		], //end column
	])
	?>
</div>