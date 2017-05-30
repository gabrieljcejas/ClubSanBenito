<?php

use app\models\Proveedor;
use app\models\Socio;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\select2\Select2;

$this->title = $title;
$this->params['breadcrumbs'][] = "Tesoreria";
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' =>['view', 'v' => $v]];

?>


<h1><?=Html::encode($this->title)?></h1><br>

<div class="movimiento-form">

    <?php $form = ActiveForm::begin();?>

    <div class="row">          
          
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
                    //'readOnly'=>'readOnly'            
                   ],               
                ]);
              ?>
        </div>

  
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

        <div class="col-md-2">

            <?=$form->field($model, 'periodo_anio')->textInput(['value' => date('Y')])?>
                
        </div>

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
            <?php Pjax::begin(['id' => 's2_cliente']);?>
                <div class="col-md-4">
                    <?=$form->field($model, 'cliente_id')->widget(Select2::classname(), [
                        'data' => $listC,
                        //'language' => 'de',
                        'options' => ['placeholder' => 'Selecione un Cliente ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);?>
                </div>
            <?php Pjax::end();?>

            <div class="col-md-1"><br>
                    <?=html::button('', ['value'=>Url::to('index.php?r=cliente/create'),'class' => 'btn glyphicon glyphicon-plus', 'id' => 'agregarcliente'])?>  
                    <?php 
                        Modal::begin([
                            //'header'=>'<h4>Agregar Cliente</h4>',
                            'id'=> 'modal',
                            'size'=>'modal-lg',
                        ]);
                        echo "<div id='modalContent'></div>";

                        Modal::end();
                    ?>     

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
                    'options' => ['placeholder' => 'Selecione un Proveedor ...'],
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
                        <th>F.Pago</th>
                        <th>Importe</th>
                        <th>                            
                        </th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <div class="col-md-1">
            
             <?=Html::a('+', null, [
               'class' => 'btn btn-default',
               'id' => 'btn_agregar_cuenta',
               'value' => $v,        
            ])?>

        </div>

               
    </div>
    
    <h3><p><?=Html::label("TOTAL: ","total",["id"=>"total"])?></p></h3>    
     
    
    <div id="table_dinamic"></div>
      
      <div class="form-group">
        <input type="button" id="Guardar" name="Guardar" value="Guardar" class="btn btn-success"/>
    </div>
    <?=$form->field($model, 'tipo')->textInput(['value' => $tipo, 'type' => 'hidden'])?>

    <?php ActiveForm::end();?>

</div>




<script type="text/javascript" src="<?=Yii::$app->request->baseUrl?>/js/jquery.min.js"></script>

<script>



function borrarfila(i){
    //alert("hola"+ i);
    $("#del-"+i).remove();
    calculartotal();

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

        //Modal Button Agregar Cliente
        $("#agregarcliente").on( "click", function() {
           $( "#modal").modal('show').find('#modalContent').load($(this).attr('value'));            
        }); 

        $('#movimiento-fk_cliente').change(function () {
            
            $.ajax({
                type: "POST",
                url: "../web/index.php?r=movimiento/get-all-debitos-by-socio",
                data: {id: $(this).val()},
                dataType: "json",
                success: function (data) {                                        
                    $("#tabla_debitos tr").remove();
                    var html='';
                    html+="<tr><th>Concepto</th><th>F.Pago</th><th>Importe</th><th></th></tr>";
                    $.each(data, function(i, debito) {                        
                        html+="<tr id='del-" + i + "'><td><input type='hidden' name='debito_sc_id[]' value='" + debito.subcuenta_id + "'>" + debito.concepto + "</td>";
                        html+="<td><select name='forma_pago[]' class='form-control'>";
                        html+="<option value='4'>Efectivo</option>";                       
                        html+="<option value='1'>Debito</option>";                       
                        html+="<option value='2'>Credito</option>";                       
                        html+="<option value='3'>Cheque</option>";                       
                        html+="</select></td>";
                        html+="<td><input type='text' name='importe[]' value='" + debito.importe + "' class='form-control' onkeyup='calculartotal()'></td>";
                        html+="<td><a id='btn_borrar_cuenta' onClick='borrarfila(" + i + ");' class='btn btn-default glyphicon glyphicon-trash'></a></td></tr>";
                    })
                    $("#tabla_debitos").append(html);
                    calculartotal();   
               },
               
            });

            
        });

        $("#Guardar").click(function(){
            
            var nro_fila = $('#tabla_debitos >tbody >tr').length;
             
            if ( $( "#movimiento-periodo_mes" ).val() < 1 ){
                alert("Debe Ingresar PERIODO MES");
                $( "#movimiento-periodo_mes" ).focus();
                return false;
            }

            if ( $( "#movimiento-periodo_anio" ).val() < 1 ){
                alert("Debe Ingresar PERIODO AÑO");
                $( "#movimiento-periodo_anio" ).focus();
                return false;
            }            

            if( $('#select2-movimiento-fk_cliente-container').length>0 ){                

                if ($('#movimiento-fk_cliente').val() == "" && $('#movimiento-cliente_id').val() == ""){
                    alert("Debe Selecionar un Socio o un Cliente");
                    return false;
                }
            }

         
            if( $('#select2-movimiento-fk_prov-container').length>0 ){   

                if ($('#movimiento-fk_prov').val() == ""){
                    alert("Debe Selecionar un Proveedor");
                    return false;
                }             
               
            }
            
            // si agrego una fila a la tabla 
            if($("input[name='importe[]']").length>0){ 

                var flag = false;
                   
                // recorro para ver si agrego un concepto                
                if ($("select[name='debito_sc_id[]']").val() == 0) {
                    alert("Debe seleccionar un concepto");
                    return false;                        
                }   

                 // recorro para saber si ingreso algun importe o no
                $( "input[name='importe[]']" ).each(function() {                
                    if ($(this).val()==""){                        
                        flag = true;                        
                    }      
                });                 
                
                if (flag == true){
                    alert("Debe ingresar un importe mayor o igual a cero.");                
                    return false;
                }
              

            }else{
                alert("Debe agregar un concepto");
                return false;   
            }
        
            $("#Guardar").submit();

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
                    html+="<option value='0'>...</option>";
                    $.each(data, function(i, sc) {

                        html+="<option value='" + sc.id + "''>" + sc.concepto + "</option>";

                    })
                    html+="</select></td><td><select name='forma_pago[]' class='form-control'>";
                    html+="<option value='4'>Efectivo</option>";                       
                    html+="<option value='1'>Debito</option>";                       
                    html+="<option value='2'>Credito</option>";                       
                    html+="<option value='3'>Cheque</option>";                     
                    html+="</select></td>";
                    html+="<td><input type='text' name='importe[]' value='' class='form-control' onkeyup='calculartotal()'></td>";
                    html+="<td><a id='btn_borrar_cuenta' onClick='borrarfila(" + nro_fila + ");' class='btn btn-default glyphicon glyphicon-trash'></a></td></tr>";
                    $("#tabla_debitos").append(html);
               }

            });

         });



    });

</script>
