<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Ciudad */

$this->title = 'Update Ciudad: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Socios', 'url' => ['socio/index']];
$this->params['breadcrumbs'][] = ['label' => 'Ciudads', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];

?>
<div class="ciudad-update">

    <h1><?=Html::encode($this->title)?></h1>

    <?=$this->render('_form', [
'model' => $model,
])?>

</div>
