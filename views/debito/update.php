<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Debito */

$this->title = 'Modificar';
$this->params['breadcrumbs'][] = ['label' => 'Socios', 'url' => ['socio/index']];
$this->params['breadcrumbs'][] = ['label' => 'Debitos', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Modificar';
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
?>
<div class="debito-update">

    <h1><?=Html::encode($this->title)?></h1>

    <?=$this->render('_form', [
'model' => $model,
])?>

</div>
