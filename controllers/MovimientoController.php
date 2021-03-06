<?php

namespace app\controllers;

use app\models\Movimiento;
use app\models\MovimientoDetalle;
use app\models\Proveedor;
use app\models\Debito;
use app\models\CategoriaSocial;
use app\models\Recibo;
use app\models\Socio;
use app\models\Cliente;
use app\models\SocioDebito;
use app\models\SubCuenta;
use mPDF;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;

ini_set('memory_limit', '-1');
/**
 * MovimientoController implements the CRUD actions for Movimiento model.
 */
class MovimientoController extends BaseController {
	
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

	/**
	 * Lists all Movimiento models.
	 * @return mixed
	 */
	public function actionIndex($v) {

		$model = new Movimiento();

		/***************  POST  ****************/
		if ($model->load(Yii::$app->request->post())) {

			$fecha_pago = date('Y-m-d', strtotime($model->fecha_pago));
			$periodo_mes = $model->periodo_mes;
			$periodo_anio = $model->periodo_anio;
			$model->fecha_pago = date('Y-m-d', strtotime($model->fecha_pago));
			$post = Yii::$app->request->post();
			
			if ($v == 'i') {
			 # SI ES INRESO--------------------------------------------------------------	
				$title = "Ingreso";

				// Genero Nuevo Nro de Recibo
				$modelR = Recibo::find()->where(['id' => 1])->one();
				$nro_recibo = $modelR->i;					
				$modelR->i = $modelR->i + 1;
				if (!$modelR->save()) {
					throw new \yii\web\HttpException(400, 'Error al guardar el ingreso');
				}
				
				// Set Datos
				$model->nro_recibo = $nro_recibo;								
				$socio = $model->fk_cliente;
				$cliente_id = $model->cliente_id;					
				$counter = 0;
				$count = 0;
				
				//Recorro todos los items del  array
				foreach ($post['importe'] as $key => $value) {
					
					// VERIFICAR SI EL INGRESO YA EXISTE.
					$modelmd = MovimientoDetalle::find() 
						->joinWith('movimiento')
						->where(['periodo_mes' => $model->periodo_mes])
						->andWhere(['periodo_anio' => $model->periodo_anio])
						->andWhere(['subcuenta_id' => $post['debito_sc_id'][$key]])
						->andWhere(['movimiento.fk_cliente' => $socio])->one();		
					//var_dump($modelmd);die;				
					
					# SI EXISTE un registro con la fecha vacia es por es un debito, no hay otra. Lo borro!
					if (!empty($modelmd) && $modelmd->movimiento->fecha_pago === null && $modelmd->movimiento->obs === null ) {						
						// borro solo una vez
						if ($counter == 0){
							$movimiento = Movimiento::findOne($modelmd->movimiento_id);
							if (!$movimiento->delete()) {
								throw new \yii\web\HttpException(400, 'Error al guardar el ingreso 1');
							}
							MovimientoDetalle::deleteAll(["movimiento_id"=>$modelmd->movimiento_id]);							
							$counter = 1;
						}
					} 
				

					// creo todo de nuevo
					if ($count == 0){
						$model = new Movimiento();
						$model->nro_recibo = $nro_recibo;
						$model->fecha_pago = $fecha_pago;
						$model->fk_cliente = $socio;
						$model->cliente_id = $cliente_id;
						$count = 1;
						if (!$model->save()) {
							throw new \yii\web\HttpException(400, 'Error al guardar el ingreso 1');
						}
						$model_id = $model->id;
					}
				
					$mMD = new MovimientoDetalle();
					$mMD->movimiento_id = $model_id;
					$mMD->subcuenta_id_fp = $post['forma_pago'][$key];
					$mMD->subcuenta_id = $post['debito_sc_id'][$key];
					$mMD->importe = $post['importe'][$key];
					$mMD->periodo_mes = $periodo_mes;
					$mMD->periodo_anio = $periodo_anio;
					$mMD->tipo = strval($v);
					if (!$mMD->save()) {
						throw new \yii\web\HttpException(400, 'Error al guardar el ingreso 2');
					}			
	
				} // foreach
			

			} else {		
				 # SI ES EGRESO--------------------------------------------------------------		
				$title = "Engreso";
				
				$modelR = Recibo::find()->where(['id' => 1])->one();
				$nroRecibo = $modelR->e;
				$modelR->e = $nroRecibo + 1;
				if (!$modelR->save()) {
					throw new \yii\web\HttpException(400, 'Error al guardar el nro de recibo egreso');
				}
				$model->nro_recibo = $nroRecibo;

				if (!$model->save()) {
					throw new \yii\web\HttpException(400, 'Error al guardar el egreso');
				} else {
					//recorro el array para guardar los detalles
					foreach ($post['importe'] as $key => $value) {
						// GUARDO LOS DETALLES
						$mMD = new MovimientoDetalle();
						$mMD->movimiento_id = $model->id;
						$mMD->subcuenta_id_fp = $post['forma_pago'][$key];
						$mMD->subcuenta_id = $post['debito_sc_id'][$key];
						$mMD->importe = $post['importe'][$key];
						$mMD->periodo_mes = $periodo_mes;
						$mMD->periodo_anio = $periodo_anio;
						$mMD->tipo = strval($v);
						if (!$mMD->save()) {
							throw new \yii\web\HttpException(400, 'Error al guardar el ingreso 2');
						}
					} // end for

				}

			}

			return $this->redirect(['view', 'v' => $v]);

		}
		/*************** END POST  ****************/

		$modelR = new Recibo();
		if ($v == 'i') {
			$nroRecibo = $modelR->getLastNroRecibo('i');
			$title = "Ingreso";
		} else {
			// si es egreso
			$nroRecibo = $modelR->getLastNroRecibo('e');
			$title = "Engreso";
		}

		// paso fecha actual
        date_default_timezone_set('America/Buenos_Aires');
        $model->fecha_pago = date('d-m-Y',time());
        $listC = ArrayHelper::map(Cliente::find()->orderBy('razon_social')->all(), 'id', 'razon_social');
		
		return $this->render('index', [
			'model' => $model,
			'nroRecibo' => $nroRecibo,
			'title' => $title,
			'v' => $v,
			'tipo' => $v,
			'listC' => $listC
		]);

	}

	public function actionGenerarDebito() {

		$model = new Movimiento(['scenario' => 'generardebito']);

		if ($model->load(Yii::$app->request->post())) {
			
			//traigo todos los socios
			$modelS = Socio::find()
			->where(['>=', 'id', $model->socio_desde])
			->andWhere(['<=', 'id', $model->socio_hasta])
			->andWhere(['fecha_baja'=> null])
			->orderBy('id ASC')
			->all();
			
			// por cada socio
			foreach ($modelS as $s) {
						
				// busco los debitos que tiene el socio
				$modelSD = SocioDebito::findAll(['id_socio' => $s->id]);
				
				if (!empty($modelSD)){

					for ($f = $model->periodo_mes_desde; $f <= $model->periodo_mes_hasta; $f++) 
					{
						
						
							// si inserto en movimiento.
							// Ahora tengo q insertar los debitos del socio en movimiento_detalle
							//por cada debito del socio
							foreach ($modelSD as $sd) {
								//verificar si ya se genero esa cuota
								$verificar = MovimientoDetalle::find()
									->joinWith('movimiento')
									->where(['movimiento.fk_cliente' => $s->id])
									->andWhere(['subcuenta_id' => $sd->debito->subcuenta_id])
									->andWhere(['periodo_mes' => $f])
									->andWhere(['periodo_anio' => $model->periodo_anio])->one();
								// si no se repite la cuota generada,genero la cuota si no no hace nada
								if ($verificar == null) {
									$mMovimiento = new Movimiento();
									$mMovimiento->fk_cliente = $s->id;

									if (!$mMovimiento->save()) {
										throw new \yii\web\HttpException(400, 'Error al insertar en movimiento', 405);
									}
									//si el select con id subcuenta_id es cero es por que eligio la opcion  "todos" (todas las cuentas) del select
									if ($model->subcuenta_id == 0) {
										//var_dump("etro cero");die;
										// inserto
										$modelMovDetalle = new MovimientoDetalle();
										$modelMovDetalle->tipo = 'i';
										$modelMovDetalle->movimiento_id = $mMovimiento->id;
										$modelMovDetalle->periodo_mes = $f;
										$modelMovDetalle->periodo_anio = $model->periodo_anio;
										$modelMovDetalle->subcuenta_id = $sd->debito->subcuenta_id;
										$modelMovDetalle->importe = $sd->debito->importe;

										if (!$modelMovDetalle->save()) {
											throw new \yii\web\HttpException(400, 'Error al insertar movimiento_detalle 1', 405);
										} else {
											$msj = "Se generaron los debitos con existo";
										}
										// si elige del html select una sbvuenta en particular,genera el debito para esa subcuenta
									} elseif ($model->subcuenta_id == $sd->debito->subcuenta_id) {

										$modelMovDetalle = new MovimientoDetalle();
										$modelMovDetalle->tipo = 'i';
										$modelMovDetalle->movimiento_id = $mMovimiento->id;
										$modelMovDetalle->periodo_mes = $f;
										$modelMovDetalle->periodo_anio = $model->periodo_anio;
										$modelMovDetalle->subcuenta_id = $sd->debito->subcuenta_id;
										$modelMovDetalle->importe = $sd->debito->importe;

										if (!$modelMovDetalle->save()) {
											throw new \yii\web\HttpException(400, 'Error al insertar movimiento_detalle 2', 405);
										} else {
											$msj = "Se generaron los debitos con existo";
										}

									}

								

							} // end foreach ($modelSD as $sd) {

						} // end else si inserto en tabla movimiento

					}// for i <=	
				}	

			} // FOR END

			return $this->render('generar_debito', [
				'model' => $model,
				'msj' => $msj,
			]);

		}

		return $this->render('generar_debito', [
			'model' => $model,
		]);

	}

	public function actionGetAllDebitosBySocio() {
		$post = Yii::$app->request->post();

		$id = $post['id'];

		$query = SocioDebito::find()->where(['id_socio' => $id])->all();
		$i = 0;
		$debitos = array();
		foreach ($query as $q) {
			$debitos[] = array('concepto' => $q->debito->concepto, 'importe' => $q->debito->importe, 'subcuenta_id' => $q->debito->subcuenta_id);
		}
		echo json_encode($debitos);

	}

	

	/*** IMPIRMIR RECIBO INGRESO ***/
	public function actionImprimirReciboIngreso($id) {

		$m = Movimiento::find()->where(['id' => $id])->one();
		$modelDetalle = MovimientoDetalle::find()->where(['movimiento_id' => $m->id])->all();
		$mod = new MovimientoDetalle();		
		$mpdf = new mPDF('utf-8', 'A4');
		$mpdf->WriteHTML($this->renderPartial('_imprimir_recibo_ingreso', [
			'm' => $m,
			'modelDetalle' => $modelDetalle,
			'mod'=>$mod,
		]));
		$mpdf->Output();
		exit;

	}

	/*** IMPIRMIR RECIBO EGRESO ***/
	public function actionImprimirReciboEgreso($id) {

		$m = Movimiento::find()->where(['id' => $id])->one();
		$modelDetalle = MovimientoDetalle::find()->where(['movimiento_id' => $m->id])->all();
		$mpdf = new mPDF('utf-8', 'A4');
		$mpdf->WriteHTML($this->renderPartial('_imprimir_recibo_egreso', [
			'm' => $m,
			'modelDetalle' => $modelDetalle,			
		]));
		$mpdf->Output();
		exit;

	}

	/*** IMPIRMIR RECIBO FORM ESTADO CUENTA***/
	public function actionImprimirReciboEC($id) {

		$modelDetalle = MovimientoDetalle::findOne($id);
		$m = Movimiento::findOne(['id' => $modelDetalle->movimiento_id]);
		//$nro_recibo = $m->nro_recibo;
		
		$mpdf = new mPDF('utf-8', 'A4');
		$mpdf->WriteHTML($this->renderPartial('_imprimir_recibo_individual', [
			'm' => $m,
			'modelDetalle' => $modelDetalle,	
			//'nro_recibo' => $nro_recibo,		
		]));
		$mpdf->Output();
		exit;

	}

	/*** IMPIRMIR DEBITOS GENERADOS ***/
	public function actionImprimirGD($periodo_mes_desde, $periodo_mes_hasta, $socio_desde, $socio_hasta, $subcuenta_id, $periodo_anio) {

		$sql = "SELECT m.id,m.fk_cliente FROM `movimiento` m
				JOIN movimiento_detalle md ON m.id=md.movimiento_id
				WHERE `fk_cliente`>=" . $socio_desde . " AND `fk_cliente`<=" . $socio_hasta . " AND md.periodo_mes>=" . $periodo_mes_desde . " AND md.periodo_mes<=" . $periodo_mes_hasta . " AND md.periodo_anio=" . $periodo_anio . " GROUP BY m.id,m.fk_cliente";
		$movimiento = Movimiento::findBySql($sql)->all();
		//var_dump($movimiento);die;
		if ($subcuenta_id == 0) {
			$movimiento_detalle = MovimientoDetalle::find()->where(['>=', 'periodo_mes', $periodo_mes_desde])->andWhere(['<=', 'periodo_mes', $periodo_mes_hasta])->andWhere(['periodo_anio' => $periodo_anio])->all();
		} else {
			$movimiento_detalle = MovimientoDetalle::find()->where(['>=', 'periodo_mes', $periodo_mes_desde])->andWhere(['<=', 'periodo_mes', $periodo_mes_hasta])->andWhere(['periodo_anio' => $periodo_anio])->andWhere(['subcuenta_id' => $subcuenta_id])->all();
		}
		//var_dump($movimiento_detalle);die;
		$mpdf = new mPDF('utf-8', 'A4');
		$mpdf->WriteHTML($this->renderPartial('_imprimir_debitos', [
			'movimiento' => $movimiento,
			'movimiento_detalle' => $movimiento_detalle,
		]));

		$mpdf->Output();
		exit;

	}

	public function actionGetListSubCuenta() {

		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$post = Yii::$app->request->post();
		$tipo = $post['tipo'];

		if ($tipo == 'i') {
			$query = SubCuenta::find()->where(['>=', 'codigo', '4.1.1'])->andWhere(['<', 'codigo', '4.2'])->all();
			//$query = Debito::find()->all();
		} else {
			$query = SubCuenta::find()->where(['>=', 'codigo', '4.2.1'])->andWhere(['<', 'codigo', '5.1'])->all();
		}

		return $query;
	}

	public function actionView($v) {

		$model = new Movimiento();
		
		$dataProvider = $model->getListMov($v);		
		
		$model->tipo = $v;
		
		return $this->render('view', [
			'model' => $model,
			'dataProvider' => $dataProvider,
			'v' => $v,
		]);
	}

	public function actionCreate() {
		
		$model = new Movimiento();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
		} else {
			return $this->render('create', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Updates an existing Movimiento model.
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
	 * Deletes an existing Movimiento model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id) {

		//$post = Yii::$app->request->post();
		//$id = $post['id'];
		$model = $this->findModel($id);
		if ($model->fk_cliente == null && $model->cliente_id == null ) {
			$v = 'e';
		} else {
			$v = 'i';
		}
		$model->delete();
		return $this->redirect(['view', 'v' => $v]);
	}

	/**
	 * ANULAR RECIBO	
	 */
	public function actionAnular() {

				
		$model = $this->findModel($_POST['id']);

		if ($model->fk_cliente == null && $model->cliente_id == null ) {
			$v = 'e';
		} else {
			$v = 'i';
		}
		
		$model->obs = "Anulado" ;
		
		if (!$model->save()){
			throw new \yii\web\HttpException(400, 'Error al anular');
		}
	}

	
	public function actionDeleted($id) {

		$model = Movimiento::findOne(['id' => $id]);
		MovimientoDetalle::deleteAll(["movimiento_id"=>$id]);

		if (!$model->delete()) {
			throw new \yii\web\HttpException(400, 'Error al borrar');
		} else {			
			return $this->redirect(['estado-cuenta']);
		}

	}

	public function actionEstadoCuenta() {

		if (Yii::$app->request->post()) {

            $post = Yii::$app->request->post();            
            $idSocio = $post['socio'];            

            $aSearch = array(
                'idSocio' => $idSocio,
            );

            $model = new Movimiento();

            if ($idSocio!=""){
            	$dataProvider = $model->buscarSocio($aSearch);
            	$deuda = $model->getDeudaTotalBySocio($idSocio,"codigo_socio");
        	}
        	else{
        		$dataProvider = $model->getAllEstadoCuenta();
				$deuda = $model->getDeudaTotal();
        	}

            $listSocios = ArrayHelper::map(Socio::find()->orderBy('apellido_nombre')->all(), 'id', 'apellido_nombre');

            

            return $this->render('estado_cuenta', [
				'dataProvider' => $dataProvider,
				'deuda' => $deuda,
				'listSocios'=> $listSocios,
				'idSocio'=> $idSocio
			]);
        }    

		$model = new Movimiento();
		$dataProvider = $model->getAllEstadoCuenta();
		$deuda = $model->getDeudaTotal();
		$listSocios = ArrayHelper::map(Socio::find()->orderBy('apellido_nombre')->all(), 'id', 'apellido_nombre');
		$idSocio = null;

		
		return $this->render('estado_cuenta', [
			'dataProvider' => $dataProvider,
			'deuda' => $deuda,
			'listSocios'=> $listSocios,
			'idSocio'=> $idSocio,
		]);

	}

	public function actionPagar() {

		try {
			
			$post = Yii::$app->request->post();
			$id = $post['id'];
			// set fecha actual
	        date_default_timezone_set('America/Buenos_Aires');
	        $fecha = date('Y-m-d');
		
			$modelR = Recibo::findOne(1);
			$nro_recibo = $modelR->i;
			$modelR->i = $nro_recibo + 1;
			$modelR->save();

			$modelM = Movimiento::findOne($id);
			$modelM->fecha_pago = date('Y-m-d', strtotime($fecha));
			$modelM->nro_recibo = $nro_recibo;
			if (!$modelM->save()) {
				throw new \yii\web\HttpException(400, 'Error al guardar pago');
			}
			

		} catch (Exception $e) {
			echo "Error function pagar" . $e;
		}

	}

	
	public function actionEstadoCuentaTodos() {

		$model = new Movimiento();

		$dataProvider = $model->getAllEstadoCuentaTodos();

		$deuda = $model->getDeudaTotal();

		return $this->render('_gridview_estado_cuenta', [
			'dataProvider' => $dataProvider,
			'deuda' => $deuda,
		]);

	}

	public function actionEstadoCuentaDeuda() {

		$model = new Movimiento();

		$dataProvider = $model->getAllEstadoCuentaDeuda();

		$deuda = $model->getDeudaTotal();

		return $this->render('_gridview_estado_cuenta', [
			'dataProvider' => $dataProvider,
			'deuda' => $deuda,
		]);

	}

	/******************************* CONSULTAS *****************************************/

	public function actionConsultaRecibosAnulados() {

		
		if (Yii::$app->request->post()) {

			$post = Yii::$app->request->post();
			$fecha_desde = date('Y-m-d', strtotime($post['fecha_desde']));
			$fecha_hasta = date('Y-m-d', strtotime($post['fecha_hasta']));

			$model = new Movimiento();
			//$dataProvider = Movimiento::find()->where(['not','obs',null]);
			$dataProvider = $model->getRecibosAnulados();	
			
			$mpdf = new mPDF('utf-8', 'A4');
			$mpdf->WriteHTML($this->renderPartial('_imprimir_recibos_anulados', [
				'dataProvider' => $dataProvider,
				'fecha_desde' => $fecha_desde,
				'fecha_hasta' => $fecha_hasta,	
				'model'=>$model,				
			]));
			$mpdf->Output();
			exit;
		}

		return $this->render('_consulta', [
			'accion' => "Recibos Anulados",
		]);

	}

	public function actionConsultaLibroSocio() {

		if (Yii::$app->request->post()) {
			
			$post = Yii::$app->request->post();
			$categoria_desde = $post['categoria_desde'];
			$categoria_hasta = $post['categoria_hasta'];
			$anio = $post['anio'];

			$sql = "SELECT s.id,s.apellido_nombre,s.fecha_nacimiento,s.matricula,s.fecha_baja,s.obs FROM socio s
					JOIN socio_debito sd ON sd.id_socio = s.id
					WHERE YEAR(fecha_nacimiento) >= '". $categoria_desde ."' AND YEAR(fecha_nacimiento) <= '". $categoria_hasta ."' AND (sd.id_debito = 19 OR sd.id_debito = 22 OR sd.id_debito = 23) ORDER BY s.matricula ASC" ;

			$socio = Socio::findBySql($sql)->all();
			
			$query = "SELECT * FROM `movimiento_detalle` md 
				JOIN movimiento m on  md.movimiento_id = m.id
				where md.periodo_mes>=1 AND md.periodo_mes<=12 AND md.periodo_anio=". $anio ." AND m.obs is null AND (md.subcuenta_id=38 OR md.subcuenta_id=50 OR md.subcuenta_id=51) 
				ORDER BY m.fk_cliente,md.periodo_mes";
			
			$movimientoDetalle = MovimientoDetalle::findBySql($query)->all();

			/****** IMPRIMIR ****/
			$mpdf = new mPDF('utf-8', 'A4-L');
			$mpdf->WriteHTML($this->renderPartial('_imprimir_libro_socio', [
				'socio' => $socio,
				'movimientoDetalle' => $movimientoDetalle,				
				'anio' => $anio,
				'categoria_desde'=>$categoria_desde,
				'categoria_hasta'=>$categoria_hasta
			]));
			$mpdf->Output();
			exit;
		}

		return $this->render('_consulta_libro_socio', [
			
		]);

	}

	public function actionConsultaMovimientoCaja() {

		if (Yii::$app->request->post()) {

			$post = Yii::$app->request->post();
			
			$caja_inicial = $post['caja_inicial'];
			if ($caja_inicial == ""){
				$caja_inicial=0;
			}


			$fecha_desde = date('Y-m-d', strtotime($post['fecha_desde']));
			$fecha_hasta = date('Y-m-d', strtotime($post['fecha_hasta']));

			$movimiento = Movimiento::find()->where(['>=', 'fecha_pago', $fecha_desde])->andWhere(['<=', 'fecha_pago', $fecha_hasta])->andWhere(['not', ['fecha_pago' => null]])->andWhere(['obs'=> null])->orderBy('nro_recibo ASC')->all();

			$mpdf = new mPDF('utf-8', 'A4');
			$mpdf->WriteHTML($this->renderPartial('_imprimir_saldo_caja', [
				'movimiento' => $movimiento,
				'fecha_desde' => $fecha_desde,
				'fecha_hasta' => $fecha_hasta,
				'caja_inicial'=>$caja_inicial
			]));
			$mpdf->Output();
			exit;
		}

		return $this->render('_consulta_mc', [
			'accion' => "Movimientos de Caja",
		]);

	}

	public function actionConsultaBalance() {

		if (Yii::$app->request->post()) {

			$post = Yii::$app->request->post();
			$fecha_desde = date('Y-m-d', strtotime($post['fecha_desde']));
			$fecha_hasta = date('Y-m-d', strtotime($post['fecha_hasta']));

			$sql = "SELECT sum(`importe`) as 'importe',`tipo`,`subcuenta_id` FROM `movimiento_detalle`md
					JOIN movimiento m on md.movimiento_id=m.id
					WHERE m.fecha_pago>='".$fecha_desde."' AND m.fecha_pago<='".$fecha_hasta."' AND m.obs is NULL group by `subcuenta_id` order by tipo DESC" ;

			$query = MovimientoDetalle::findBySql($sql)->all();
			
			$mpdf = new mPDF('utf-8', 'A4');
			$mpdf->WriteHTML($this->renderPartial('_imprimir_balance', [
				'query' => $query,
				'fecha_desde' => $fecha_desde,
				'fecha_hasta' => $fecha_hasta,					
			]));
			$mpdf->Output();
			exit;
		}

		return $this->render('_consulta', [
			'accion' => "Balance",
		]);

	}

	public function actionConsultaMovimientoCuenta() {

		//$model = new Movimiento();

		if (Yii::$app->request->post()) {

			$post = Yii::$app->request->post();

			$fecha_desde = date('Y-m-d', strtotime($post['fecha_desde']));
			$fecha_hasta = date('Y-m-d', strtotime($post['fecha_hasta']));

			$movimiento = Movimiento::find()->where(['>=', 'fecha_pago', $fecha_desde])->andWhere(['<=', 'fecha_pago', $fecha_hasta])->andWhere(['obs'=> null])->andWhere(['not', ['fecha_pago' => null]])->all();

			$mpdf = new mPDF('utf-8', 'A4');
			$mpdf->WriteHTML($this->renderPartial('_imprimir_movimiento_cuenta', [
				'movimiento' => $movimiento,
				'fecha_desde' => $fecha_desde,
				'fecha_hasta' => $fecha_hasta,
			]));
			$mpdf->Output();
			exit;

		}


		return $this->render('_consulta', [
			'accion' => "Movimiento de caja agrupado por cuenta",
		]);

	}

	public function actionConsultaIngresos() {

		$model = new Movimiento();

		if (Yii::$app->request->post()) {

			$post = Yii::$app->request->post();

			// PARAMETROS	
			$fecha_desde = date('Y-m-d', strtotime($post['fecha_desde']));
			
			$fecha_hasta = date('Y-m-d', strtotime($post['fecha_hasta']));	
			
			$deporte = $post['deportes'];
			
			$categoria_desde = $post['categoria_desde'];
			
			$categoria_hasta = $post['categoria_hasta'];	

			$socio = "";	

			$titulo = "DETALLE DE INGRESOS";

			$this->imprimirDetalleIngreso($fecha_desde,$fecha_hasta,$deporte,$categoria_desde,$categoria_hasta,$titulo);
		}

		$consultaDebitos = Debito::find()->asArray()->all();
		
		$deportes = ArrayHelper::map($consultaDebitos, 'id', 'concepto');
        
		return $this->render('_consulta_ingreso', [
			'socios' => $socios,			
			'deportes' => $deportes,	
			'accion' => "Detalle Ingresos",
		]);

	}

	public function actionConsultaEgresos() {

		//$model = new Movimiento();

		if (Yii::$app->request->post()) {

			$post = Yii::$app->request->post();

			$fecha_desde = date('Y-m-d', strtotime($post['fecha_desde']));
			$fecha_hasta = date('Y-m-d', strtotime($post['fecha_hasta']));

			$movimiento = Movimiento::find()->where(['>=', 'fecha_pago', $fecha_desde])->andWhere(['<=', 'fecha_pago', $fecha_hasta])->andWhere(['not', ['fecha_pago' => null]])->all();

			$mpdf = new mPDF('utf-8', 'A4');
			$mpdf->WriteHTML($this->renderPartial('_imprimir_egresos', [
				'movimiento' => $movimiento,
				'fecha_desde' => $fecha_desde,
				'fecha_hasta' => $fecha_hasta,
			]));
			$mpdf->Output();
			exit;

		}

		return $this->render('_consulta', [
			'accion' => "Detalle Egresos",
		]);

	}

	/*
	**** Consulta Estado de cuenta por socio, diciplina y categoria entre fechas
	*/
	public function actionConsultaEstadoCuenta() {

		
		if (Yii::$app->request->post()) {

			$post = Yii::$app->request->post();
						
			// PARAMETROS	
			$fecha_desde = date('Y-m-d', strtotime($post['fecha_desde']));
			$fecha_hasta = date('Y-m-d', strtotime($post['fecha_hasta']));
			$deporte = $post['deportes'];
			$categoria_desde = $post['categoria_desde'];
			$categoria_hasta = $post['categoria_hasta'];
			$socio = $post['socio'];
			$anio = 2017;	
			
			if ($socio == ""){
				$sql = "SELECT s.id,s.apellido_nombre,s.fecha_nacimiento,s.matricula,s.fecha_baja,s.obs FROM socio s
						JOIN socio_debito sd ON sd.id_socio = s.id
						WHERE YEAR(fecha_nacimiento) >= '". $categoria_desde ."' AND YEAR(fecha_nacimiento) <= '". $categoria_hasta ."' AND sd.id_debito > 19 group by s.apellido_nombre ASC" ;
				$socio = Socio::findBySql($sql)->all();
			}else{
				$sql = "SELECT s.id,s.apellido_nombre,s.fecha_nacimiento,s.matricula,s.fecha_baja,s.obs FROM socio s
						JOIN socio_debito sd ON sd.id_socio = s.id
						WHERE YEAR(fecha_nacimiento) >= '". $categoria_desde ."' AND YEAR(fecha_nacimiento) <= '". $categoria_hasta
						 ."' AND sd.id_debito > 19 AND s.id=".$socio." group by s.apellido_nombre ASC" ;
				$socio = Socio::findBySql($sql)->all();
			}


			$dep = Debito::findOne($deporte);

			if ($deporte == ""){ // si no seleciona un deporte 
				$query = "SELECT * FROM `movimiento_detalle` md 
					JOIN movimiento m on  md.movimiento_id = m.id
					where md.periodo_mes>=1 AND md.periodo_mes<=12 AND md.periodo_anio=". $anio ." AND m.obs is null
					ORDER BY m.fk_cliente,md.periodo_mes";
								
			}else{ // si selecciona un deporte 
				$query = "SELECT * FROM `movimiento_detalle` md 
					JOIN movimiento m on  md.movimiento_id = m.id
					where md.periodo_mes>=1 AND md.periodo_mes<=12 AND md.periodo_anio=". $anio ." AND m.obs is null
					 AND md.subcuenta_id = " . $dep->subcuenta_id . "
					ORDER BY m.fk_cliente,md.periodo_mes";
			}
			
			$movimientoDetalle = MovimientoDetalle::findBySql($query)->all();
			
			
			/****** IMPRIMIR ****/
			$mpdf = new mPDF('utf-8', 'A4-L');
			$mpdf->WriteHTML($this->renderPartial('_imprimir_ec', [
				'socio' => $socio,
				'movimientoDetalle' => $movimientoDetalle,				
				'anio' => $anio,
				'categoria_desde'=>$categoria_desde,
				'categoria_hasta'=>$categoria_hasta
			]));
			$mpdf->Output();
			exit;


			
		}


		$consultaSocios = Socio::find()->all();	
		// formo el array socio con el dni concatenado ;)
	 	foreach ($consultaSocios as $cs) {
            $socios[$cs['id']] = $cs['apellido_nombre'] . "  - Dni:  ". $cs['dni'] ;
        }
				
	 	$consultaDebitos = Debito::find()
	 	->where(['<>','subcuenta_id','38'])
	 	->andWhere(['<>','subcuenta_id','36'])
	 	->andWhere(['<>','subcuenta_id','50'])
	 	->andWhere(['<>','subcuenta_id','51'])
	 	->asArray()
	 	->all();
		
		$deportes = ArrayHelper::map($consultaDebitos, 'id', 'concepto');
        
		return $this->render('_consulta_ec', [
			'socios' => $socios,			
			'deportes' => $deportes,			
			'accion' => "Estado de Cuenta",
		]);

	}

	/*	
	**	CONSULTAS DE ESTADO DE CUENTA 
	*/
	private function imprimirEstadoCuenta($fecha_desde,$fecha_hasta,$deporte,$categoria_desde,$categoria_hasta,$ss,$titulo){
			
			$mes_desde   = date('m', strtotime($fecha_desde));
			
			$anio_desde  = date('Y', strtotime($fecha_desde));

			$mes_hasta   = date('m', strtotime($fecha_hasta));
			
			$anio_hasta  = date('Y', strtotime($fecha_hasta));

			if ($ss == ""){
			
				if ($deporte!=""){ // si seleciona un deporte

					$dep = Debito::findOne($deporte);
				
					$sql = "SELECT s.id,s.apellido_nombre,s.fecha_nacimiento,s.matricula,s.fecha_baja FROM socio  s
							JOIN socio_debito sd ON sd.id_socio = s.id
							WHERE YEAR(fecha_nacimiento) >= '".$categoria_desde."' AND YEAR(fecha_nacimiento) <= '".$categoria_hasta."' AND sd.id_debito = ". $deporte ." ORDER BY s.id DESC" ;

					$socio = Socio::findBySql($sql)->all();
				
					$movimientoDetalle = MovimientoDetalle::find()
						->joinWith('movimiento')						
						->where(['>=', 'periodo_mes', $mes_desde])
						->andWhere(['>=', 'periodo_anio', $anio_desde])
						->andWhere(['<=', 'periodo_mes', $mes_hasta])
						->andWhere(['<=', 'periodo_anio', $anio_hasta])
						->andWhere(['subcuenta_id'=>$dep->subcuenta_id])
						->andWhere(['movimiento.obs'=>null])
						->all();
				}			
				else{
					
						$sql = "SELECT s.id,s.apellido_nombre,s.fecha_nacimiento,s.matricula,s.fecha_baja FROM socio  s						
							WHERE YEAR(fecha_nacimiento) >= '".$categoria_desde."' AND YEAR(fecha_nacimiento) <= '".$categoria_hasta."' ORDER BY s.id DESC" ;
						$socio = Socio::findBySql($sql)->all();
				
						$movimientoDetalle = MovimientoDetalle::find()
							->joinWith('movimiento')							
							->where(['>=', 'periodo_mes', $mes_desde])
							->andWhere(['>=', 'periodo_anio', $anio_desde])
							->andWhere(['<=', 'periodo_mes', $mes_hasta])
							->andWhere(['<=', 'periodo_anio', $anio_hasta])
							->andWhere(['movimiento.obs'=>null])
							->all();							
				}
				
			}else{

				$socio = Socio::find()->where(['id'=>$ss])->one();
								
				$movimientoDetalle = MovimientoDetalle::find()
					->joinWith('movimiento')					
					->andWhere(['movimiento.fk_cliente' => $ss])
					->where(['>=', 'periodo_mes', $mes_desde])
					->andWhere(['>=', 'periodo_anio', $anio_desde])
					->andWhere(['<=', 'periodo_mes', $mes_hasta])
					->andWhere(['<=', 'periodo_anio', $anio_hasta])
					->andWhere(['movimiento.obs'=>null])
					->all();
					
			}
			
			/**
			****** IMPRIMIR 
			**/
			$mpdf = new mPDF('utf-8', 'A4');
			$mpdf->WriteHTML($this->renderPartial('_imprimir_consulta_estado_cuenta', [				
				'fecha_desde' => $fecha_desde,
				'fecha_hasta' => $fecha_hasta,	
				'deporte' => $deporte,
				'ss' => $ss,
				'socio' => $socio,
				'movimientoDetalle' => $movimientoDetalle,				
				'dep' => $dep,
				'titulo' => $titulo,
			]));
			$mpdf->Output();
			exit;
	
	}

	/*	
	**	CONSULTAS INGRESOS
	*/
	private function imprimirDetalleIngreso($fecha_desde,$fecha_hasta,$deporte,$categoria_desde,$categoria_hasta,$titulo){
			
					
			if ($deporte!=""){ // si seleciona un deporte

				$dep = Debito::findOne($deporte);
			
				$sql = "SELECT s.id,s.apellido_nombre,s.fecha_nacimiento FROM socio  s
						JOIN socio_debito sd ON sd.id_socio = s.id
						WHERE YEAR(fecha_nacimiento) >= '".$categoria_desde."' AND YEAR(fecha_nacimiento) <= '".$categoria_hasta."' AND sd.id_debito = ". $deporte ." ORDER BY s.id DESC" ;

				$socio = Socio::findBySql($sql)->all();
		
				$movimientoDetalle = MovimientoDetalle::find()
					->joinWith('movimiento')					
					->where(['>=', 'fecha_pago', $fecha_desde])
					->andWhere(['<=', 'fecha_pago', $fecha_hasta])
					->andWhere(['movimiento.obs' => null])
					->andWhere(['subcuenta_id'=>$dep->subcuenta_id])
					->all();
			}			
			else{
				
					$sql = "SELECT s.id,s.apellido_nombre,s.fecha_nacimiento FROM socio  s						
						WHERE YEAR(fecha_nacimiento) >= '".$categoria_desde."' AND YEAR(fecha_nacimiento) <= '".$categoria_hasta."' ORDER BY s.id DESC" ;
					$socio = Socio::findBySql($sql)->all();
			
					$movimientoDetalle = MovimientoDetalle::find()
						->joinWith('movimiento')
						->where(['>=', 'fecha_pago', $fecha_desde])
						->andWhere(['<=', 'fecha_pago', $fecha_hasta])		
						->andWhere(['movimiento.obs' => null])				
						->all();							
			}
				
		
			/**
			****** IMPRIMIR 
			**/
			$mpdf = new mPDF('utf-8', 'A4');
			$mpdf->WriteHTML($this->renderPartial('_imprimir_consulta_estado_cuenta', [				
				'fecha_desde' => $fecha_desde,
				'fecha_hasta' => $fecha_hasta,	
				'deporte' => $deporte,
				'ss' => $ss,
				'socio' => $socio,
				'movimientoDetalle' => $movimientoDetalle,				
				'dep' => $dep,
				'titulo' => $titulo,
			]));
			$mpdf->Output();
			exit;
	
	}


	public function actionConsultaProveedor() {

		if (Yii::$app->request->post()) {

			$post = Yii::$app->request->post();

			$fecha_desde = date('Y-m-d', strtotime($post['fecha_desde']));
			$fecha_hasta = date('Y-m-d', strtotime($post['fecha_hasta']));
			$proveedor = $post['proveedor'];

			if ($proveedor == null){
				$movimiento = Movimiento::find()
				->where(['>=', 'fecha_pago', $fecha_desde])
				->andWhere(['<=', 'fecha_pago', $fecha_hasta])
				->andWhere(['obs' => null])
				->andWhere(['not', ['fk_prov' => null]])->all();				
			} else{
				$movimiento = Movimiento::find()
				->where(['>=', 'fecha_pago', $fecha_desde])
				->andWhere(['<=', 'fecha_pago', $fecha_hasta])
				->andWhere(['obs' => null])
				->andWhere(['fk_prov' => $proveedor])->all();				
			}

			$mpdf = new mPDF('utf-8', 'A4');
			$mpdf->WriteHTML($this->renderPartial('_imprimir_proveedores', [
				'movimiento' => $movimiento,
				'fecha_desde' => $fecha_desde,
				'fecha_hasta' => $fecha_hasta,
			]));
			$mpdf->Output();
			exit;

		}

		$consulta = Proveedor::find()->all();
		$proveedor = ArrayHelper::map($consulta, 'id', 'nombre');		
		return $this->render('_consulta_proveedor', [
			'proveedor' => $proveedor,
		]);

	}

	protected function findModel($id) {
		if (($model = Movimiento::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
