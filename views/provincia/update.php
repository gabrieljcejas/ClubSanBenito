<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Provincia */

$this->title = 'Update Provincia: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Socios', 'url' => ['socio/index']];
$this->params['breadcrumbs'][] = ['label' => 'Provincias', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
?>
<div class="provincia-update">

    <h1><?=Html::encode($this->title)?></h1>

    <?=$this->render('_form', [
'model' => $model,
])?>

</div>
