<?php

use app\models\Proveedor;
use app\models\Socio;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use kartik\select2\Select2;

$this->title = $title;
$this->params['breadcrumbs'][] = "Tesoreria";
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' =>['view', 'v' => $v]];;

?>


<h1><?=Html::encode($this->title)?></h1><br>

<div class="movimiento-form">

    <?php $form = ActiveForm::begin();?>

    <div class="row">

      <div class="col-md-2"><?=$form->field($model, 'nro_recibo')->textInput(['value' => $nroRecibo, 'readOnly' => 'readOnly'])?></div>
      
      <div class="col-md-2">       
      <label>Fecha</label>      
      <?= 
        DatePicker::widget([
          'model' => $model,
          'attribute' => 'fecha_pago',
          //'language' => 'ru',
          'dateFormat' => 'php:d-m-Y',
          'options'=>[
            'class'=>'form-control',            
           ],               
        ]);
      ?>
      </div>

    </div>

    <div class="row">

        <div class="col-md-2">
            <?=$form->field($model, 'periodo_mes')->dropDownList([
	'1' => 'Enero',
	'2' => 'Febrero',
	'3' => 'Marzo',
	'4' => 'Abril',
	'5' => 'Mayo',
	'6' => 'Junio',
	'7' => 'Julio',
	'8' => 'Agosto',
	'9' => 'Septiembre',
	'10' => 'Octubre',
	'11' => 'Noviembre',
	'12' => 'Diciembre',
],
	['prompt' => 'Selecione un Mes..'])
?>
        </div>

        <div class="col-md-2"><?=$form->field($model, 'periodo_anio')->textInput(['value' => date('Y')])?></div>

    </div>


    <div class="row">

    <?php   if ($tipo == "i") { // si la variable es "i" (ingresos) traigo todos los socios y cuentas de resultado positivo 4.1
            $list = ArrayHelper::map(Socio::find()->orderBy('apellido_nombre')->all(), 'id', 'apellido_nombre');?>
            
            <div class="col-md-4">
                <?=$form->field($model, 'fk_cliente')->widget(Select2::classname(), [
                    'data' => $list,
                    //'language' => 'de',
                    'options' => ['placeholder' => 'Selecione un Socio ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);?>
            </div>
<?php }
// si la variable es "e" (engresos) traigo todos los proveedores y cuentas de resultado negativo 4.2
else {
	       $list = ArrayHelper::map(Proveedor::find()->orderBy('nombre')->all(), 'id', 'nombre');
?>
           <div class="col-md-4">
                <?=$form->field($model, 'fk_prov')->widget(Select2::classname(), [
                    'data' => $list,
                    //'language' => 'de',
                    'options' => ['placeholder' => 'Selecione un Socio ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);?>
            </div>

<?php }?>

        </div><br>



    <div class="row">
        <div class="col-md-8">
            <table class="table table-hover" id="tabla_debitos" border="1">
                <thead>
                    <tr>
                        <th>Concepto</th>
                        <th>Importe</th>
                        <th>Forma de Pago</th>
                        <th>Importe</th>
                        <th>                            
                        </th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        
    </div>

    
     <?=$form->field($model, 'tipo')->textInput(['value' => $tipo, 'type' => 'hidden'])?>

    
    <div id="table_dinamic"></div>
      <div class="form-group">
        
        <h3><p><?=Html::label("TOTAL: ","total",["id"=>"total"])?></p></h3><p></p>
        <?=Html::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success'])?>       

        <?=Html::a('Agregar Cuenta', null, [
           'class' => 'btn btn-primary',
           'id' => 'btn_agregar_cuenta',
           'value' => $v,        
        ])?>
        
        
        
        
            
        
     
    </div>

    <?php ActiveForm::end();?>

</div>




<script type="text/javascript" src="<?=Yii::$app->request->baseUrl?>/js/jquery.min.js"></script>
<script>

function borrarfila(i){
    //alert("hola"+ i);
    $("#del-"+i).remove();
}

function calculartotal(){
    
    var suma = 0;  
    
    $("#total").text("TOTAL: $");
    
    $( "input[name='importe[]']" ).each(function() {        
        suma = parseFloat($(this).val()) + suma;    
        $("#total").text("TOTAL: $" + suma);    
    });  
}

    $(function () {

        $('#movimiento-fk_cliente').change(function () {
            
            $.ajax({
                type: "POST",
                url: "../web/index.php?r=movimiento/get-all-debitos-by-socio",
                data: {id: $(this).val()},
                dataType: "json",
                success: function (data) {
                    var html='';
                    $("#tabla_debitos tr").remove();
                    html+="<tr><th>Concepto</th><th>Importe</th><th>Forma de Pago</th><th>Importe Pagado</th><th></th><tr>";
                    $.each(data, function(i, debito) {
                        html+="<tr id='del-" + i + "'><td><input type='hidden' name='debito_sc_id[]' value='" + debito.subcuenta_id + "'>" + debito.concepto + "</td><td>$" + debito.importe + "</td>";
                        html+="<td><select name='forma_pago[]' class='form-control'>";
                        html+="<option value='4'>Efectivo</option>";
                        html+="<option value='30'>Cheque Propio</option>";
                        html+="<option value='31'>Cheque de Tercero</option>";
                        html+="</select></td>";
                        html+="<td><input type='text' name='importe[]' value='" + debito.importe + "' class='form-control' onkeyup='funcionSumarTotal()'></td>";
                        html+="<td><a id='btn_borrar_cuenta' onClick='borrarfila(" + i + ");' class='btn btn-default glyphicon glyphicon-trash'></a></td></tr>";

                    })
                    $("#tabla_debitos").append(html);
                    calculartotal();   
               },
               
            });

            
        });

         


        $("#btn_agregar_cuenta").click(function(){
           
           $.ajax({
                type: "POST",
                url: "../web/index.php?r=movimiento/get-list-sub-cuenta",
                data: {tipo: $(this).attr("value")},
                dataType: "json",
                success: function (data) {
                    var html='';
                    var nro_fila = $('#tabla_debitos >tbody >tr').length + 1;
                    html+="<tr id='del-" + nro_fila + "'><td><select name='debito_sc_id[]' class='form-control'>";
                    html+="<option value='0'>Selecione una Cuenta</option>";
                    $.each(data, function(i, sc) {

                        html+="<option value='" + sc.id + "''>" + sc.concepto + "</option>";

                    })
                    html+="</select></td><td></td><td><select name='forma_pago[]' class='form-control'>";
                    html+="<option value='4'>Efectivo</option>";
                    html+="<option value='30'>Cheque Propio</option>";
                    html+="<option value='31'>Cheque de Tercero</option>";
                    html+="</select></td>";
                    html+="<td><input type='text' name='importe[]' value='' class='form-control'></td>";
                    html+="<td><a id='btn_borrar_cuenta' onClick='borrarfila(" + nro_fila + ");' class='btn btn-default glyphicon glyphicon-trash'></a></td></tr>";
                    $("#tabla_debitos").append(html);
               }

            });
         });



    });

</script>
