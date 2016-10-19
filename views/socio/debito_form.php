<?php

//use yii\grid\GridView;
//use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\Debito;
//use yii\helpers\Url;
use yii\helpers\ArrayHelper;

?>
<br>

  <div class="row">
    <div class="col-md-2"><?=$form->field($model, 'grupo_sanguineo')->textInput()?></div>
  </div>

  <?=$form->field($model, 'antecedentes_medicos')->textarea()?>

  <?=$form->field($model, 'sanciones')->textarea()?>

  <hr>
  
  <h2>Datos del Padre/Madre/Tutor</h2><br>

  <?=$form->field($model, 'tutor_nombre')->textInput()?>

  <?=$form->field($model, 'tutor_dni')->textInput()?>

  <?=$form->field($model, 'tutor_fn')->textInput()?>

  <?=$form->field($model, 'tutor_tel')->textInput()?> 

<hr>

<div class="socio-debito">    
    
    <h2>Seleccionar Debitos</h2><br>
  
    <div class="row">

        <div class="col-md-4">
          <?php //listado de debitos          
              $listDebito = ArrayHelper::map(Debito::find()->all(), 'id', 'concepto');
          ?>
          
          <?= html::dropDownList('id_debito',null,$listDebito,['prompt' => '...','class'=>'form-control','id'=>'id_debito']) ?>          
        </div>           

        <div class="col-md-4">
        
          <?= html::button('Agregar Debitos', ['class' => 'btn btn-success', 'id' => 'btn_agregar_debito']) ?>          
        </div>

    </div><br>
              
    <div class="row">                   
                    
      <!-- Tabla Debitos -->
      <div class="col-md-12">
        <table class="table table-hover" id="tabla_debitos" border="1" >
            <thead>
                <tr><th>Concepto</th><th></th></tr>
            </thead>
            <tbody>
            </tbody>
        </table>
      </div>         

    </div>
        
</div><br>

<script>

    function borrarfila(i){    
    
      $("#del-"+i).remove();    

      var nro_fila = $('#tabla_debitos >tbody >tr').length;                   
      
      if (nro_fila==0){
      
          $( "#tabla_debitos" ).val("0");

      }

    }
    $(function () {
        
        $('#btn_agregar_debito').click(function () {

            var id_debito = $("#id_debito").val();

            var concepto = $("#id_debito :selected").text();

           //valido que selecione un debito
            if (id_debito == 0) {
                
                alert("DEBE SELECCIONAR UN DEBITO");
                
                $("#id_debito").focus();
                
                return false;
            }

            //ARMO LAS FILAS DE LA TABLA            
            var html='';                        
            
            var nro_fila = $('#tabla_debitos >tbody >tr').length + 1;

             html+="<tr id='del-" + nro_fila + "'>";
                
                html+="<td><input readOnly='readOnly' name='concepto[]' value='" + concepto + "' class='form-control' ><input type='hidden' name='id[]' value='" + id_debito + "' class='form-control' style='width: 50px;'></td>";                                
                html+="<td><a id='btn_borrar_cuenta' onClick='borrarfila(" + nro_fila + ");' class='btn btn-default glyphicon glyphicon-trash'></a></td>";

            html+="</tr>";

            $("#tabla_debitos").append(html);    

        });        
   
    });

</script>
