<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Socio */

$this->title = 'Agregar Socio';
$this->params['breadcrumbs'][] = ['label' => 'Socios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="socio-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <br>
    <?= $this->render('_form', [
        'model' => $model,
        'modelSD'=>$modelSD,
        'proximoIDSocio'=>$proximoIDSocio,
        'dataProviderSocioDebito'=>$dataProviderSocioDebito,      
    ]) ?>

</div>
