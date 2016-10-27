<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\Models\Rol */

$this->title = 'Modificar Rol: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Rols', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Modificar';
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];

?>
<div class="rol-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
	 
		'model' => $model,
		 
		'tipoOperaciones' => $tipoOperaciones
	 
	]) ?>

</div>
