<?php
namespace app\controllers;

use Yii;
use app\models\GenerarDeudaForm;

class GenerarDeudaController extends \yii\web\Controller
{


	public function actionIndex()
    {
    	$model = new GenerarDeudaForm();

    	if ($model->load(Yii::$app->request->post())) {
    		
			$model->fecha_vencimiento = date('Y-m-d', strtotime($model->fecha));


		}

        return $this->render('index',[
        	'model'=>$model,
        	]);
    }








}