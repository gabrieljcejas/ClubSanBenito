<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Debito */

$this->title = $model->concepto;
$this->params['breadcrumbs'][] = ['label' => 'Socios', 'url' => ['socio/index']];
$this->params['breadcrumbs'][] = ['label' => 'Debitos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="debito-view">

    <h1><?=Html::encode($this->title)?></h1>

    <p>
        <?=Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary'])?>
        <?=Html::a('Eliminar', ['delete', 'id' => $model->id], [
'class' => 'btn btn-danger',
'data' => [
'confirm' => 'Are you sure you want to delete this item?',
'method' => 'post',
],
])?>
    </p>

    <?=DetailView::widget([
'model' => $model,
'attributes' => [
'id',
'concepto',
'importe',
'subCuenta.concepto',
],
])?>

</div>
