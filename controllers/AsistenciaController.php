<?php

namespace app\controllers;

use Yii;
use app\models\AsistenciaSearch;
use yii\data\ActiveDataProvider;
use app\models\Asistencia;
use yii\web\Controller;
use app\models\Socio;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class AsistenciaController extends \yii\web\Controller
{
    public function behaviors() {
        return [ 
            'access' => [
                'class' => AccessControl::className(),
                //'only' => ['logout'],
                'rules' => [
                    [
                        //'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],                 
            'verbs' => [
                'class' => VerbFilter::className(),
                /*'actions' => [
                    'delete' => ['post'],
                */
            ],
        ];
    }


     public function actionIndex(){
        
        $searchModel= new AsistenciaSearch();
        $dataProvider= $searchModel->search(Yii::$app->request->queryParams);
        
            
        return $this->render('index', [
                    //'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
        
    }
    
  
    
    public function actionSearch(){
        
        //$msj="";
        $post = Yii::$app->request->post();        
        $dni_codigo=$post['dni_codigo'];
        
        $query=Socio::find()->where(['dni'=>'31724990'])->one();
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        
        if (!empty($query)){

            $model= new Asistencia();

            foreach ($dataProvider as $q){                
                $model->id_socio= $q->id;
                $model->fecha_hora= date("Y-m-d H:i:s");
                $model->save();
                break;
            }

        }
        else{

            $msj="No existe Socio con ese Codigo/DNI";
        }
        
       
        
        
    }
}
