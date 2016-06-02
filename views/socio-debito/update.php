<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SocioDebito */

$this->title = 'Update Socio Debito: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Socio Debitos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="socio-debito-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
