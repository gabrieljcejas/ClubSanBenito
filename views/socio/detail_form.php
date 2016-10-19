<?php

use app\models\CategoriaSocial;
use app\models\Ciudad;
use app\models\Cobrador;
use app\models\Provincia;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
?>
<script type="text/javascript" src="<?=Yii::$app->request->baseUrl?>/js/jquery.min.js"></script>

<br>
<div class="container">

    <div class="row">

        <div class="col-md-6">

            <div class="row">
            
                <div class="col-md-6"><?=$form->field($model, 'matricula')->textInput(['type' => 'text', 'readOnly' => 'readOnly'])?></div>
                
                <div class="col-md-6">
                    <label>Fecha Alta</label>      
                     <div class="input-group">   
                      <?= 
                        DatePicker::widget([
                          'model' => $model,
                          'attribute' => 'fecha_alta',                          
                          'dateFormat' => 'php:d-m-Y',
                          'options'=>[
                            'class'=>'form-control',            
                           ],               
                        ]);
                      ?>
                      <span class="input-group-addon glyphicon glyphicon-calendar"></span>
                </div>
                </div>

            </div>

            <div class="row">

                <div class="col-md-12"><?=$form->field($model, 'apellido_nombre')->textInput(['maxlength' => 80])?></div>

            </div>

             <div class="row">

                <div class="col-md-6"><?=$form->field($model, 'dni')->textInput()?></div>

                <div class="col-md-6"><?=$form->field($model, 'sexo')->dropDownList(['m' => 'M', 'f' => 'F'], ['prompt' => '...'])?></div>

            </div>

            <div class="row">              
                 
                <div class="col-md-6"> 
                 <label>Fecha Nacimiento</label>                                        
                 <div class="input-group">   
                      <?= 
                        DatePicker::widget([
                          'model' => $model,
                          'attribute' => 'fecha_nacimiento',                          
                          'dateFormat' => 'php:d-m-Y',
                          'options'=>[
                            'class'=>'form-control',            
                           ],               
                        ]);
                      ?>
                      <span class="input-group-addon glyphicon glyphicon-calendar"></span>
                </div>
                </div>      

                <div class="col-md-6">Edad:<div class="alert alert-success" role="alert"><?=$model->edad;?></div></div>

            </div>

            <div class="row">

                <div class="col-md-12"><?=$form->field($model, 'direccion')->textInput(['maxlength' => 60])?></div>

            </div>

            <div class="row">

                <?php $listDataP = ArrayHelper::map(Provincia::find()->all(), 'id', 'descripcion');?>
                <div class="col-md-4"><?=$form->field($model, 'id_provincia')->dropDownList($listDataP, ['prompt' => '...'])?></div>

                <?php $listDataC = ArrayHelper::map(Ciudad::find()->all(), 'id', 'descripcion');?>
                <div class="col-md-4"><?=$form->field($model, 'id_ciudad')->dropDownList($listDataC, ['prompt' => '...'])?></div>

                <div class="col-md-4"><?=$form->field($model, 'cp')->textInput(['maxlength' => 15])?></div>

            </div>

            <div class="row">

                <div class="col-md-12"><?=$form->field($model, 'email')->textInput(['maxlength' => 30])?></div>

            </div>

            <div class="row">

                <div class="col-md-6"><?=$form->field($model, 'telefono')->textInput(['maxlength' => 15])?></div>

                <div class="col-md-6"><?=$form->field($model, 'telefono2')->textInput(['maxlength' => 15])?></div>

            </div>

           

            <div class="row">

                <?php $listCategoria = ArrayHelper::map(CategoriaSocial::find()->all(), 'id', 'descripcion');?>
                <div class="col-md-6"><?=$form->field($model, 'id_categoria_social')->dropDownList($listCategoria, ['prompt' => '...'])?></div>

                <?php $listCobrador = ArrayHelper::map(Cobrador::find()->all(), 'id', 'descripcion');?>
                <div class="col-md-6"><?=$form->field($model, 'id_cobrador')->dropDownList($listCobrador, ['prompt' => '...'])?></div>

            </div>

        </div>

        <div class="col-md-6">

            <div class="row">
                <div class="col-md-6">Antiguedad:<div class="alert alert-success" role="alert"><?=$model->antiguedad;?></div></div>

            </div>

            <div class="row">

                <?php if (empty($model->nombre_foto)) {?>
                    <div class="col-md-6" id="foto_perfil"><?=Html::img(yii::$app->urlManager->baseUrl . '/fotos/sin_foto.png', ['width' => 200])?></div>
                <?php } else {?>
                    <div class="col-md-6" id="foto_perfil"><?=Html::img(yii::$app->urlManager->baseUrl . '/fotos/' . $model->nombre_foto, ['width' => 200])?></div>
                <?php }?>

                <div class="col-md-1">

                    <div class="row">

                        <?=$form->field($model, 'file')->fileInput()?>

                    </div>

                    <div class="row">

                        <a class="btn btn-default" href="#" role="button" ><?=Html::img(yii::$app->urlManager->baseUrl . '/fotos/btn_cam.png', ['width' => 70])?></a>

                    </div>

                </div>

            </div>

            <br>



            <div class="row">
                 <div class="col-md-6">
                    <label>Fecha Baja</label>      
                     <div class="input-group">   
                      <?= 
                        DatePicker::widget([
                          'model' => $model,
                          'attribute' => 'fecha_baja',                          
                          'dateFormat' => 'php:d-m-Y',
                          'options'=>[
                            'class'=>'form-control',            
                           ],               
                        ]);
                      ?>
                      <span class="input-group-addon glyphicon glyphicon-calendar"></span>
                </div>
                </div>
            </div>

            <div class="row">
              <div class="col-md-12"><?=$form->field($model, 'obs')->textarea()?></div>
            </div>

          </div>

    </div>
   
</div>






