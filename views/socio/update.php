<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Socio */

$this->title = 'Modificar: ' . ' ' . $model->apellido_nombre;
$this->params['breadcrumbs'][] = ['label' => 'Socios', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Modificar';
$this->params['breadcrumbs'][] = ['label' => $model->apellido_nombre, 'url' => ['view', 'id' => $model->id]];

?>
<div class="socio-update">

    <div class="row">
      <!--<div class="col-md-2">
          <?php if (isset($model->nombre_foto)) {?>
              <?=Html::img(yii::$app->urlManager->baseUrl . '/fotos/' . $model->nombre_foto, ['width' => 150])?>
          <?php }?>
      </div>-->
      <div class="col-md-6"><h1><?=Html::encode($this->title)?></h1></div>        
    </div>
    <br>
    <?=
      $this->render('_form', [
      'model' => $model,
      'modelSD' => $modelSD,
      'nombre_img' => $nombre_img,
      'dataProviderSocioDebito' => $dataProviderSocioDebito,
      'proximoIDSocio' => $proximoIDSocio,
      ])
    ?>
</div>
