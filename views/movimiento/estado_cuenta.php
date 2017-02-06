<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EstadoCuentaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
//var_dump($dataProvider);die;
$this->title = 'Estado de Cuenta';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estado-cuenta-index">

    <h1><?=Html::encode($this->title)?></h1>

    <p>FILTRAR POR:<p>
    <div class="row">
        <div class="col-md-3"><input type="text" id="codigo" class="form-control" placeholder="Codigo Barra o Dni"></div>
        <div class="col-md-3"><input type="text" id="nombre" class="form-control" placeholder="Nombre"></div>        
        <div class="col-sm-2"><input type="radio" id="todos" name="sex" value="male" >Todos los Socios</div>
        <div class="col-sm-2"><input type="radio" id="deuda" name="sex" value="male" >Socios con Deuda</div>
    </div><br>
    <div id="resultado">
        <?=$this->render('_gridview_estado_cuenta', [
            'dataProvider' => $dataProvider,
            'deuda'=>$deuda
        ])?>
    </div>