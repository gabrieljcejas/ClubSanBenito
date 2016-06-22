<?php

namespace app\controllers;

use app\components\SocioService;
use app\models\Socio;
use app\models\SocioDebito;
use app\models\Movimiento;
use app\models\SocioSearch;
use mPDF;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\AccessControl;

		
/**
 * SocioController implements the CRUD actions for Socio model.
 */
class SocioController extends Controller {
	

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
				'actions' => [
					'delete' => ['post'],
				],
			],
		];
	}

	public function actionIndex() {
		$searchModel = new SocioSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	public function actionView($id) {

		$model = $this->findModel($id);
		$service = new SocioService();

		//trae todos los debitos de los socios
		$dataProviderSocioDebito = $service->findSocioDebitoById($id);

		//calcular edad
		$model->edad = $service->calcularEdad($model->fecha_nacimiento);
		//calcular antiguedad
		$model->antiguedad = $service->calcularAntiguedad($model->fecha_alta);

		//doy vuelta las fechas
		$model->fecha_nacimiento = date('d-m-Y', strtotime($model->fecha_nacimiento));
		$model->fecha_alta = date('d-m-Y', strtotime($model->fecha_alta));

		//estado de cuenta
		$modelM = new Movimiento();		
		$deuda = $modelM->getDeudaTotalBySocio($id,'codigo_socio');
		$dataProvider = $modelM->getAllEstadoCuentaByCodigoSocio($id);

		return $this->render('view', [
			'model' => $model,
			'dataProviderSocioDebito' => $dataProviderSocioDebito,
			'dataProvider' => $dataProvider,
			'deuda' => $deuda,
		]);
	}

	/**
	 * Creates a new Socio model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate() {

		$model = new Socio();
		$service = new SocioService();

		if ($model->load(Yii::$app->request->post())) {
			
			
			/*** SUBIR FOTO ***/						
			$model->file = UploadedFile::getInstance($model, 'file');
			if ($model->file!=""){
				$model->file->saveAs(Yii::$app->basePath . '/web/fotos/' . $model->dni . '.' . $model->file->extension);
				$model->nombre_foto = $model->dni . '.' . $model->file->extension;
			}
			/*--FIN---*/


			$model->fecha_alta = date('Y-m-d', strtotime($model->fecha_alta)); // da vuelta la fecha a mysql
			$model->fecha_nacimiento = date('Y-m-d', strtotime($model->fecha_nacimiento)); // da vuelta la fecha a mysql
			if (!$model->save()) {
				throw new \yii\web\HttpException(400, 'Error al guardar Socio');
			}
			else{
				return $this->redirect(['view', 'id' => $model->id]);
			}			
			
		} else {

			//obtener el proximo id
			$proximoIDSocio = $service->getProximoId();
			//trae todos los debitos de los socios
			$dataProviderSocioDebito = $service->findSocioDebitoById($proximoIDSocio);

			$modelSD = new SocioDebito();

			//var_dump($listDebito);die;
			return $this->render('create', [
				'model' => $model,
				'modelSD' => $modelSD,
				'proximoIDSocio' => $proximoIDSocio,
				'dataProviderSocioDebito' => $dataProviderSocioDebito,
			]);
		}
	}

	public function actionAgregarSocioDebito() {

		$post = Yii::$app->request->post();

		$model = new SocioDebito();

		$model->id_debito = $post['id_debito'];
		$model->id_socio = $post['id_socio'];

		if (!$model->save()){
			throw new NotFoundHttpException('The requested page does not exist.');
		}		
		return true;
	}

	public function actionDeleteds() {

		$post = Yii::$app->request->post();

		$id = $post['id'];
		SocioDebito::deleteAll(array('id' => $id));

		//return $this->redirect(['create']);
	}

	/**
	 * Updates an existing Socio model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id) {

		$model = $this->findModel($id);

		$service = new SocioService();
		//var_dump($service->calcularEdad($model->fecha_nacimiento));die;
		if ($model->load(Yii::$app->request->post())) {

			/*** SUBIR FOTO ***/						
			$model->file = UploadedFile::getInstance($model, 'file');
			if ($model->file!=""){
				$model->file->saveAs(Yii::$app->basePath . '/web/fotos/' . $model->dni . '.' . $model->file->extension);
				$model->nombre_foto = $model->dni . '.' . $model->file->extension;
			}
			/*--FIN---*/

			$model->fecha_alta = date('Y-m-d', strtotime($model->fecha_alta)); // da vuelta la fecha a mysql
			$model->fecha_baja = date('Y-m-d', strtotime($model->fecha_baja)); // da vuelta la fecha a mysql
			$model->fecha_nacimiento = date('Y-m-d', strtotime($model->fecha_nacimiento)); // da vuelta la fecha a mysql
			$model->save();
			return $this->redirect(['view', 'id' => $model->id]);
		} else {

			$nombre_img = $model->nombre_foto;

			$dataProviderSocioDebito = $service->findSocioDebitoById($id);
			//var_dump($nombre_img);die;
			$proximoIDSocio = $id;

			$modelSD = new SocioDebito();

			//calcular edad
			$model->edad = $service->calcularEdad($model->fecha_nacimiento);
			//calcular antiguedad
			$model->antiguedad = $service->calcularAntiguedad($model->fecha_alta);

			//doy vuelta las fechas
			$model->fecha_nacimiento = date('d-m-Y', strtotime($model->fecha_nacimiento));
			$model->fecha_alta = date('d-m-Y', strtotime($model->fecha_alta));

			return $this->render('update', [
				'model' => $model,
				'nombre_img' => $nombre_img,
				'modelSD' => $modelSD,
				'proximoIDSocio' => $proximoIDSocio,
				'dataProviderSocioDebito' => $dataProviderSocioDebito,
			]);
		}
	}

	/**
	 * Deletes an existing Socio model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id) {

		$this->findModel($id)->delete();

		return $this->redirect(['index']);
	}

	/**
	 * Deletes an existing Socio debito.
	 */
	public function actionDeleteDebito() {

		$post = Yii::$app->request->post();

		$model = SocioDebito::findOne($post['id']);
		
		if (!$model->delete()) {
			throw new \yii\web\HttpException(400, 'Error al borrar debito');
		} 
	}

	/**
	 * Finds the Socio model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Socio the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = Socio::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

	public function actionFichaSocioPdf($id) {

		$service = new SocioService();
		$dataProviderSocioDebito = $service->findSocioDebitoById($id);
		$model = $this->findModel($id);

		//calcular edad
		$model->edad = $service->calcularEdad($model->fecha_nacimiento);

		//calcular antiguedad
		$model->antiguedad = $service->calcularAntiguedad($model->fecha_alta);

		//doy vuelta las fechas
		$model->fecha_nacimiento = date('d-m-Y', strtotime($model->fecha_nacimiento));
		$model->fecha_alta = date('d-m-Y', strtotime($model->fecha_alta));

		$mpdf = new mPDF('utf-8', 'A4');
		$mpdf->WriteHTML($this->renderPartial('_imprimir_socio_ficha', [
			'dataProviderSocioDebito' => $dataProviderSocioDebito,
			'model' => $model,
		]));

		$mpdf->Output();
		exit;
	}

	public function actionCredencial() {

		$model = new Socio();
		
		$service = new SocioService();

		if ($model->load(Yii::$app->request->post())) {

			$codigo_desde = $model->codigo_desde;
		
			$codigo_hasta = $model->codigo_hasta;

			$listSocios = $service->findSocioByCodigo($codigo_desde, $codigo_hasta);

			$mpdf = new mPDF('utf-8', 'A4');
		
			$mpdf->WriteHTML($this->renderPartial('_imprimir_socio_credencial', [
				'listSocios' => $listSocios,
			]));
		
			$mpdf->Output();

			exit;
		}

		return $this->render('credencial', [
			'model' => $model,
		]);

	}

	public function actionImprimirEstadoCuenta($id) {
		//model socio
		$model = $this->findModel($id);
		//model movimiento
		$modelM = new Movimiento();		

		$deuda = $modelM->getDeudaTotalBySocio($id,'codigo_socio');

		$dataProvider = $modelM->getAllEstadoCuentaByCodigoSocio($id);

		$mpdf = new mPDF('utf-8', 'A4');

		$mpdf->WriteHTML($this->renderPartial('_imprimir_estado_cuenta_socio', [			
			'model' => $model,			
			'dataProvider' => $dataProvider,
			'deuda' => $deuda,
		]));

		$mpdf->Output();

		exit;
	}



}
