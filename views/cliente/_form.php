<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Cliente */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cliente-form">

    <?php $form = ActiveForm::begin([
        'id'=>$model->formName()        
        ]);?>

    <?= $form->field($model, 'razon_social')->textInput() ?>

    <?= $form->field($model, 'telefono')->textInput() ?>

    <?= $form->field($model, 'domicilio')->textInput() ?>

    <?= $form->field($model, 'rubro')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'obs')->textArea(['rows' => '4']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <!--<?= Html::submitButton('Guardar',['class' =>'btn btn-success'])?>-->

     

    
<?php ActiveForm::end(); ?>


</div>
<script type="text/javascript" src="<?=Yii::$app->request->baseUrl?>/js/jquery.min.js"></script>

<script>
    $(document).ready(function () {
        $( "form" ).submit(function(e) { 
            var form = $(this);
            // return false if form still have some validation errors
            if (form.find('.has-error').length) 
            {
                return false;
            }
            // submit form
            $.ajax({
                url    : form.attr('action'),
                type   : form.attr('method'),
                data   : form.serialize(),
                success: function (data) 
                {
                   $(document).find('#modal').modal('hide');
                    //alert('Grabo! '+ data.id);
                    $(form).trigger('reset');  
                    $.pjax.reload({container: '#s2_cliente'});
                },
                error  : function () 
                {
                    console.log('internal server error');
                }
            });
            
            return false;
         });
    });
</script>
