<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
?>

<div class="socio-detail">
    <br>
    <div class="col-md-6">    
        <?=
        DetailView::widget([
          'model' => $model,
          'attributes' => [
            'id',
            'fecha_alta',
            'fecha_baja',            
            'obs',
            'matricula',
            //'apellido_nombre',                                    
            'fecha_nacimiento',
            'dni',
            'edad',
            'antiguedad',
            'direccion',
            'cp',
            'email:email',
            'provincia.descripcion',
            'ciudad.descripcion',
            'categoriaSocial.descripcion',
            'cobrador.descripcion',
            'sexo',
            'telefono',
            'telefono2',
          ],
        ])
        ?>
    </div>
</div>