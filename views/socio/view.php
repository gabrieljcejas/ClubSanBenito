<?php

use yii\bootstrap\Tabs;
//use yii\widgets\DetailView;
use yii\helpers\Html;

//use app\models\CategoriaSocial;
/* @var $this yii\web\View */
/* @var $model app\models\Socio */

$this->title = $model->apellido_nombre;
$this->params['breadcrumbs'][] = ['label' => 'Socios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="socio-view">
    <div class="row">
        <div class="col-md-6"><h1><?=Html::encode($this->title)?></h1></div>
    </div><br>

    <div class="row">
        <div class="col-md-3">
          <div>
              <?php if (empty($model->nombre_foto)) {?>
                  <br>
                    <div class="col-md-6" id="foto_perfil"><?=Html::img(yii::$app->urlManager->baseUrl . '/fotos/sin_foto.png', ['width' => 200])?></div>
                <?php } else {?>
                    <div class="col-md-6" id="foto_perfil"><?=Html::img(yii::$app->urlManager->baseUrl . '/fotos/' . $model->nombre_foto, ['width' => 200])?></div>
                <?php }?>
          </div>
        </div>
        <div class="col-md-6">
          <div class="row">
          <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary'])?>          
          <?=
            Html::a('Eliminar', ['delete', 'id' => $model->id], [
            	'class' => 'btn btn-danger',
            	'data' => [
            		'confirm' => 'Are you sure you want to delete this item?',
            		'method' => 'post',
            	],
            ])
          ?>
          </div><br>
          <div class="row">
            <?=
              Html::a(' Ficha Personal', ['ficha-socio-pdf', 'id' => $model->id], [
                'class' => ' btn btn-default glyphicon glyphicon-print',
              ])
            ?>        
          </div><p></p>
          <div class="row">
            <?=
              Html::a(' Estado Cuenta', ['imprimir-estado-cuenta', 'id' => $model->id], [
              	'class' => ' btn btn-default glyphicon glyphicon-print',
              ])
            ?>
          </div>
        </div>

    </div><br>
    <?=
Tabs::widget([
	'items' => [
		[
			'label' => 'Datos',
			'content' => $this->render('_view_datos', ['model' => $model, 'form' => $form]),
			'active' => true,
		],
		[
			'label' => 'Debitos',
			'content' => $this->render('_view_debitos', ['model' => $model, 'form' => $form, 'dataProviderSocioDebito' => $dataProviderSocioDebito]),
		],
		[
			'label' => 'Estado de Cuenta',
			'content' => $this->render('_view_estado_cuenta', ['model' => $model, 'form' => $form, 'dataProvider' => $dataProvider, 'deuda' => $deuda]),
		],
	],
]);
?>

</div>
