<?php

use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\Debito;
use yii\helpers\Url;
?>
<?php $form = ActiveForm::begin(); ?>
<div class="socio-view">


    <?= $form->field($model, 'id_socio')->textInput(array('value' => $proximoIDSocio, 'type' => 'hidden')) ?>

    <div class="row">
        <?php
        $debito = new Debito();

        $listado = $debito->getListConceptoImporte();

        foreach ($listado as $li) {
            $listDebito[$li['id']] = $li['concepto'] . '....$' . $li['importe'];
        }
        ?> 
        <div class="col-md-4"><?= $form->field($model, 'id_debito')->dropDownList($listDebito, ['prompt' => '...']) ?></div>           

    </div>
    <div class="row">           
        <div class="col-md-1"><?= html::button('Agregar Debitos', ['class' => 'btn btn-success', 'id' => 'btn_agregar_debito']) ?></div>
    </div>
    <br>
    <?php \yii\widgets\Pjax::begin(['id' => 'grd_socio', 'timeout' => false]); ?>           

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
              'deleted' => function ($url, $model) {
                return html::button('', ['class' => ' btn btn-default glyphicon glyphicon-trash', 'name' => 'eliminar', 'value' => $model->id]);                     
              },
            ],
            'urlCreator' => function ($action, $model, $key, $index) {              
              if ($action === 'deleted') {
                $url = Url::to(['<socio></socio>/delete-debito', 'id' => $model->id]);
                return $url;
              }   
            },
          ],
       ]//end column
    ])
    ?>
   
 </div>

<script>

    $(function () {
        
        $('#btn_agregar_debito').click(function () {
            
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
                  id_socio: $("#sociodebito-id_socio").val()
                },
                success: function (data) {              
                  window.location.reload(); 
                   //$.pjax.reload({container: '#grd_socio'});
                }
            });


        });        

       $("button[name='eliminar']").click(function () {
          if (confirm('Seguro que desea Eliminar?')) {
            var id = $(this).attr('value');            
            $.ajax({
              type: "POST",
              url: "../web/index.php?r=socio/delete-debito",
              data: {
                id: id ,                
              },
              success: function (data) {
                $.pjax.reload({container: '#grd_socio'});                    
              }
            });                                        
          }
        });

    });

</script>
<?php \yii\widgets\Pjax::end(); ?>
<?php ActiveForm::end(); ?>    