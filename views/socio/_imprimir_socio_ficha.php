<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;
?>

<html>
    <div style="text-align:center;"><h1>Ficha Personal</h1></div>

    <br>
    <br> 
    <table>
        <tr>
            <td>Apellido y Nombre:</td><td><b><?= $model->apellido_nombre ?></b></td><td></td><td></td>
            <td colspan="2" rowspan="9">
                <?php if (isset($model->nombre_foto)) { ?>
                    <?=Html::img(yii::$app->urlManager->baseUrl . '/fotos/' . $model->nombre_foto, ['width' => 150, 'align' => 'right']) ?>
                <?php } ?>
            </td>
        </tr>
        <tr>
            <td></td><td></td><td></td><td></td>
        </tr>
        <tr>
            <td>D.N.I.:</td><td><b><?= $model->dni ?></b></td><td></td><td></td>
        </tr>
        <tr>
            <td></td><td></td><td></td><td></td>
        </tr>
        <tr>
            <td>Fecha Nacimiento:</td><td><b><?= $model->fecha_nacimiento ?></b></td><td>Edad:</td><td><b><?= $model->edad ?><b></td>
        </tr>
        <tr>
            <td></td><td></td><td></td><td></td>
        </tr>
        <tr>
            <td>Direccion:</td><td><b><?= $model->direccion ?></b></td><td></td><td></td>
        </tr>
        <tr>
            <td></td><td></td><td></td><td></td>
        </tr>
        <tr>
            <td>Provincia:</td><td><b><?= $model->provincia->descripcion ?></b></td><td>Ciudad:</td><td><b><?= $model->ciudad->descripcion ?></b></td>
        </tr>
        <tr>
            <td></td><td></td><td></td><td></td>
        </tr>
        <tr>
            <td>Codigo Postal:</td><td><b><?= $model->cp ?></b></td><td></td><td></td><td>Codigo</td><td><b><?= $model->id ?></b></td>
        </tr>
        <tr>
            <td></td><td></td><td></td><td></td><td></td><td></td>
        </tr>
        <tr>
            <td>Email:</td><td><b><?= $model->email ?></b></td><td></td><td></td><td>Matricula</td><td><b><?= $model->matricula ?></b></td>
        </tr>
        <tr>
            <td></td><td></td><td></td><td></td><td></td><td></td>
        </tr>
        <tr>
            <td>Telefono:</td><td><b><?= $model->telefono ?></b></td><td>Telefono:</td><td><b><?= $model->telefono2 ?></b></td><td>Fecha Alta:</td><td><b><?= $model->fecha_alta ?></b></td>
        </tr>
        <tr>
            <td></td><td></td><td></td><td></td><td></td><td></td>
        </tr>
        <tr>
            <td>Categoria Social:</td><td><b><?= $model->categoriaSocial->descripcion ?></b></td><td>Cobrador:</td><td><b><?= $model->cobrador->descripcion ?></b></td><td>Antiguedad:</td><td><b><?= $model->antiguedad ?></b></td>
        </tr>
        
    </table>
    
    <br>
    
    <h2>Debitos Aplicados</h2>
    <?=
    GridView::widget([
      'dataProvider' => $dataProviderSocioDebito,
      'summary' => '',
      'columns' => [
        'debito.concepto',
        'debito.importe',        
      ], 
    ])
    ?>
    
</html>    

