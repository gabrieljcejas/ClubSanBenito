<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

//$this->title = 'Login';
//$this->params['breadcrumbs'][] = $this->title;
?>

<style type="text/css" media="screen">
.panel-info > .panel-heading {
    color: #ffffff;
    background-color: #222222;
    border-color: #222222;
} 
.panel-info {
    border-color: #222222;
}   
</style>

<div class="site-login">
    
<h1><?= Html::encode($this->title) ?></h1>    

<?php $form = ActiveForm::begin([
    'id' => 'login-form',                
]); ?>
  

 <div class="container">    
        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
            <div class="panel panel-info" >
                    <div class="panel-heading">
                        <div class="panel-title">Iniciar Sesion</div>                        
                    </div>     

                    <div style="padding-top:30px" class="panel-body" >

                        <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                            
                        <form id="loginform" class="form-horizontal" role="form">
                                    
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input id="loginform-username" type="text" class="form-control"  name="LoginForm[username]" value="" placeholder="username or email">                                        
                                    </div>
                                
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input id="loginform-password" type="password" class="form-control" name="LoginForm[password]" placeholder="password">
                                    </div>
                            

                                <div style="margin-top:10px" class="form-group">
                                    <!-- Button -->

                                    <div class="col-sm-12 controls" align="right">
                                       <?= Html::submitButton('Entrar', ['class' => 'btn btn-success', 'name' => 'login-button']) ?>
                                    </div>
                                </div>


                            </form>     



                        </div>                     
                    </div>  
        </div>

<?php ActiveForm::end(); ?>