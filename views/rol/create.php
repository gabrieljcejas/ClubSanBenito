<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\Models\Rol */

$this->title = 'Agregar Roles';
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rol-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
	 
		'model' => $model,
		 
		'tipoOperaciones' => $tipoOperaciones
	 
	]) ?>

</div>
