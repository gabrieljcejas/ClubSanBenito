<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\Models\Operacion */

$this->title = 'Modificar Permisos: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Permisos', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Modificar';
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];
?>
<div class="operacion-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
