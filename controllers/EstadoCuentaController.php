<?php

namespace app\controllers;

use app\models\EstadoCuenta;
use app\models\EstadoCuentaSearch;
use app\models\Recibo;
use app\models\SocioDebito;
use mPDF;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
/**
 * EstadoCuentaController implements the CRUD actions for EstadoCuenta model.
 */
class EstadoCuentaController extends BaseController {
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

	/**
	 * Lists all EstadoCuenta models.
	 * @return mixed
	 */
	public function actionIndex() {
		$searchModel = new EstadoCuentaSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		//model estado_cuenta
		//$model = new EstadoCuenta();

		//$dataProvider = $model->getEstadoCuenta();

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single EstadoCuenta model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id) {
		return $this->render('view', [
			'model' => $this->findModel($id),
		]);
	}

	public function actionGenerarDebito() {

		$model = new EstadoCuenta(['scenario' => 'generardebito']);

		if ($model->load(Yii::$app->request->post())) {
			//var_dump($model);die;
			// obtengo todos los registro de la tabla socio_debito con los parametros socio_desde y socio_hasta
			// para luego consultar con el campo id_debito en la tabla "debito" obtener datos de la tabla.
			$modelSD = SocioDebito::find()->where(['>=', 'id_socio', $model->socio_desde])->andWhere(['<=', 'id_socio', $model->socio_hasta])->orderBy('id_socio ASC')->all();			
			// verifico que no se haya generado anteriormente el mismo debito para el mismo cliente
			//$fecha_vencimiento = date('Y-m-d', strtotime($model->fecha_vencimiento));
			$i = 0;
			foreach ($modelSD as $msd) {

				if ($i == 0) {
					$idSocio = $msd->id_socio;
					$i = $i + 1;
				}
				//traigo todos los registro de la tabla estado de cuenta con la fecha de vencimietno para luego comparar si se repite los datos
				$tablaEC = EstadoCuenta::find()->select('id')->where(['socio_id' => $msd->id_socio])->andWhere(['subcuenta_id' => $msd->debito->subcuenta_id])->one();
				// si es vacio es por que no existe generado un registro en estado de cuenta con esa fecha de vencimiento para dicho socio y subcuenta
				if ($tablaEC->id == null) {
					//Verifico que el socio sea activo comparado la fecha de baja sea igual null (que no este dado de baja)
					if ($msd->socio->fecha_baja == null) {
						//si el input con id subcuenta_id es cero es por que eligio la opcion  "todos" (todas las cuentas) del select
						if ($model->subcuenta_id == 0) {

							for ($f=$model->periodo_mes_desde; $f <=$model->periodo_mes_hasta ; $f++) {
								
								$modelEC = new EstadoCuenta();
								$modelEC->fecha_vencimiento = date('Y-m-d', strtotime($model->fecha_vencimiento));
								$modelEC->periodo_mes = strval($f);
								$modelEC->periodo_anio = $model->periodo_anio;
								$modelEC->subcuenta_id = $msd->debito->subcuenta_id;
								$modelEC->socio_id = $msd->id_socio;
								$modelEC->importe_apagar = $msd->debito->importe;							

								if (!$modelEC->save()) {
									throw new \yii\web\HttpException(400, 'Wrong method save 1', 405);
								} else {
									$msj = "Se generaron los debitos con existo";
								}

							}// end for $f

							// si elige del html select una sbvuenta en particular,genera el debito para esa subcuenta
						} elseif ($model->subcuenta_id == $msd->debito->subcuenta_id) {
							
							for ($f=$model->periodo_mes_desde; $f <=$model->periodo_mes_desde ; $f++) {
							
								$modelEC = new EstadoCuenta();
								$modelEC->fecha_vencimiento = date('Y-m-d', strtotime($model->fecha_vencimiento));
								$modelEC->periodo_mes = strval($f);
								$modelEC->periodo_anio = $model->periodo_anio;
								$modelEC->subcuenta_id = $msd->debito->subcuenta_id;
								$modelEC->socio_id = $msd->id_socio;
								$modelEC->importe_apagar = $msd->debito->importe;						

								if (!$modelEC->save()) {
									throw new \yii\web\HttpException(400, 'Wrong method save 2', 405);
								} else {
									$msj = "Se generaron los debitos con existo";
								}

							}// end for $f

						}// else 

					}

				} // end if tablaEC

			}// end for
				
			return $this->render('generar_debito', [
				'model' => $model,
				'msj' => $msj,
			]);

		} // Post
			

		return $this->render('generar_debito', [
			'model' => $model,
		]);
	}

	/*** IMPIRMIR DEBITOS GENERADOS ***/
	public function actionImprimirGD($socio_desde, $socio_hasta,$periodo_mes_desde,$periodo_mes_hasta, $subcuenta_id) {
		//var_dump($periodo_mes_desde);die;
		$anio_actual= date("Y");
		if ($subcuenta_id == 0) {
			$socio = EstadoCuenta::find()->where(['>=', 'socio_id', $socio_desde])->andWhere(['<=', 'socio_id', $socio_hasta])->andWhere(['periodo_anio'=>$anio_actual])->orderBy('socio_id,periodo_mes ASC')->all();
			//$model = EstadoCuenta::find()->where(['>=', 'socio_id', $socio_desde])->andWhere(['<=', 'socio_id', $socio_hasta])->orderBy('socio_id ASC')->all();
			//var_dump($socio);die;
		} else {
			$socio = EstadoCuenta::find()->where(['>=', 'socio_id', $socio_desde])->andWhere(['<=', 'socio_id', $socio_hasta])->andWhere(['subcuenta_id' => $subcuenta_id])->andWhere(['periodo_anio'=>$anio_actual])->orderBy('socio_id,periodo_mes ASC')->all();
			//$model = EstadoCuenta::find()->where(['>=', 'socio_id', $socio_desde])->andWhere(['<=', 'socio_id', $socio_hasta])->andWhere(['subcuenta_id' => $subcuenta_id])->orderBy('socio_id ASC')->all();
		}

		$mpdf = new mPDF('utf-8', 'A4');
		$mpdf->WriteHTML($this->renderPartial('_imprimir_estado_cuenta', [
			//'model' => $model,
			'socio' => $socio,
			'mes_desde'=> $periodo_mes_desde,
			'mes_hasta'=>$periodo_mes_hasta,
		]));

		$mpdf->Output();
		exit;

	}

	public function actionEstadoCuentaPdf($id) {

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

	/**
	 * Creates a new EstadoCuenta model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate() {
		$model = new EstadoCuenta();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
		} else {
			return $this->render('create', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Updates an existing EstadoCuenta model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id) {
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Deletes an existing EstadoCuenta model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id) {

		$this->findModel($id)->delete();

		return $this->redirect(['index']);
	}

	/**
	 * Finds the EstadoCuenta model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return EstadoCuenta the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = EstadoCuenta::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
