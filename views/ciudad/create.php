<?php

use yii\helpers\Html;

$this->title = 'Crear Ciudad';
$this->params['breadcrumbs'][] = ['label' => 'Socios', 'url' => ['socio/index']];
$this->params['breadcrumbs'][] = ['label' => 'Ciudads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ciudad-create">

    <h1><?=Html::encode($this->title)?></h1>

    <?=$this->render('_form', [
		'model' => $model,
	])?>
	
</div>
