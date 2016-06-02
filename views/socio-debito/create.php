<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SocioDebito */

$this->title = 'Create Socio Debito';
$this->params['breadcrumbs'][] = ['label' => 'Socio Debitos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="socio-debito-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
