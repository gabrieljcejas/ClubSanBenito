<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Debito */

$this->title = 'Agregar Debito';
$this->params['breadcrumbs'][] = ['label' => 'Socios', 'url' => ['socio/index']];
$this->params['breadcrumbs'][] = ['label' => 'Debitos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="debito-create">

    <h1><?=Html::encode($this->title)?></h1>

    <?=$this->render('_form', [
'model' => $model,
])?>

</div>
