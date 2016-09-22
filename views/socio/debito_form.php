<?php

use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\Debito;
use yii\helpers\Url;
?>
  <br>

  <div class="row">
    <div class="col-md-2"><?=$form->field($model, 'grupo_sanguineo')->textInput()?></div>
  </div>

  <?=$form->field($model, 'antecedentes_medicos')->textarea()?>

  <?=$form->field($model, 'sanciones')->textarea()?>

  <hr>
  
  <h2>Datos del Padre/Madre/Tutor</h2>

  <?=$form->field($model, 'tutor_nombre')->textInput()?>

  <?=$form->field($model, 'tutor_dni')->textInput()?>

  <?=$form->field($model, 'tutor_fn')->textInput()?>

  <?=$form->field($model, 'tutor_tel')->textInput()?> 

  <hr>

<!-- FORMULARIO DE DEBITOS-->

<?php $form = ActiveForm::begin(); ?>

<div class="socio-view">    
    
    <h2>Seleccionar Debitos</h2>

    <div class="row">

        <?php
          $debito = new Debito();
          $listado = $debito->getListConceptoImporte();
          foreach ($listado as $li) {
              $listDebito[$li['id']] = $li['concepto'] . '....$' . $li['importe'];
          }
        ?> 
        <div class="col-md-4">
          <?= $form->field($modelSD, 'id_debito')->dropDownList($listDebito, ['prompt' => '...']) ?>          
        </div>           

        <div class="col-md-4">
        <p></p><p></p>
          <?= html::button('Agregar Debitos', ['class' => 'btn btn-success', 'id' => 'btn_agregar_debito']) ?>          
        </div>

    </div>
              
        
    </div><br>

    <?php \yii\widgets\Pjax::begin(['id' => 'wg_grd_socio','timeout'=>true]); ?>           

    <?=
    GridView::widget([
      'dataProvider' => $dataProviderSocioDebito,
      'columns' => [
        'debito.concepto',
          [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Actions',
            'template' => '{deleted}',
            'buttons' => [             
              'deleted' => function ($url, $modelSD) {
                return html::button('', ['class' => ' btn btn-default glyphicon glyphicon-trash', 'name' => 'eliminar', 'onclick'=>'myFunction('.$modelSD->id.')', 'value' => $modelSD->id]);                     
              },
            ],
            'urlCreator' => function ($action, $modelSD, $key, $index) {              
              if ($action === 'deleted') {
                $url = Url::to(['<socio></socio>/delete-debito', 'id' => $modelSD->id]);
                return $url;
              }   
            },
          ],
       ]//end column
    ])
    ?>
   <?php \yii\widgets\Pjax::end(); ?>

   <?= $form->field($modelSD, 'id_socio')->textInput(array('value' => $proximoIDSocio, 'type' => 'hidden')) ?>

 </div>

<script>

    function myFunction(id){
      if (confirm('Seguro que desea Eliminar?')) {
        var id = id;            
        $.ajax({
          type: "POST",
          url: "../web/index.php?r=socio/delete-debito",
          data: {
            id: id ,                
          },
          success: function (data) {
            $.pjax.reload({container: '#wg_grd_socio'});                    
          }
        });                                        
      }
    }


    $(function () {
        
        $('#btn_agregar_debito').click(function () {

            //$.pjax.reload({container: '#grd_socio'});

            var id_debito = $("#sociodebito-id_debito").val();
           
            if (id_debito == 0) {
                alert("Selecione un debito");
                $("#sociodebito-id_debito").focus();
                return false;
            }

            $.ajax({
                type: "POST",                
                url: "../web/index.php?r=socio/agregar-socio-debito",
                data: {
                  id_debito: $("#sociodebito-id_debito").val(), 
                  id_socio: $("#sociodebito-id_socio").val(),
                },
                success: function (data) {                                                  
                  $.pjax.reload({container: '#wg_grd_socio'});
                  //return false;                  
                }
            });
            
        });        
   
    });

</script>

<?php ActiveForm::end(); ?>    