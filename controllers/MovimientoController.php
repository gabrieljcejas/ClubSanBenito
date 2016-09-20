<?php

namespace app\controllers;

use app\models\Movimiento;
use app\models\MovimientoDetalle;
use app\models\Proveedor;
use app\models\Debito;
use app\models\CategoriaSocial;
use app\models\Recibo;
use app\models\Socio;
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

/**
 * MovimientoController implements the CRUD actions for Movimiento model.
 */
class MovimientoController extends Controller {
	
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

			$model->fecha_pago = date('Y-m-d', strtotime($model->fecha_pago));
			$post = Yii::$app->request->post();
			
			if ($v == 'i') {
				$title = "Ingresos";
				$modelR = Recibo::find()->where(['id' => 1])->one();
				$modelR->i = $model->nro_recibo;
				//actualizo nro recibo tabla recibo
				if (!$modelR->save()) {
					throw new \yii\web\HttpException(400, 'Error al guardar el ingreso');
				}
				$nro_recibo = $model->nro_recibo;
				$periodo_mes = $model->periodo_mes;
				$periodo_anio = $model->periodo_anio;
				$socio = $model->fk_cliente;
				// guardo por cada debito un registro en la tabla moviemietp de talle
				foreach ($post['importe'] as $key => $value) {

					// VERIFICAR SI EL INGRESO YA EXISTE. SI EXISTE LO ACTUALIZO , SI NO LO AGREGO
					$modelmd = MovimientoDetalle::find() // es mas simple usando hasmany, pero bue..me la mande :)
						->joinWith('movimiento')
						->where(['periodo_mes' => $model->periodo_mes])
						->andWhere(['periodo_anio' => $model->periodo_anio])
						->andWhere(['subcuenta_id' => $post['debito_sc_id'][$key]])
						->andWhere(['movimiento.fk_cliente' => $socio])->one();
					// si no existe registro con ese periodo y cuenta
					if ($modelmd == null) {
						// creo el ingreso, guardo en tabla movimiento
						if (!$model->save()) {
							throw new \yii\web\HttpException(400, 'Error al guardar el ingreso 1');
						} else {
							// una vez que guardo, inserto los detalles de los debitos/cuentas en movimiento detalle
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
						}
						// si encuentra un registro con el mismo periodo y cuenta, me fijo si la fecha de pago es vacia (por que no pago todavia esa "cuota generada")
					} elseif ($modelmd->movimiento->fecha_pago == "") {
						// busco en la tabla de movimiento el registro (cuando genero las cuotas anticipada creo un registro en la tabla movimiento y los otros registro en movimiento_detalle POR CADA PERIODO MES Y AÑO!!! )
						$mMov = Movimiento::findOne($modelmd->movimiento_id);
						$modelR = Recibo::find()->where(['id' => 1])->one();
						$mMov->nro_recibo = $modelR->e;
						//actualizo nro recibo tabla recibo
						if (!$modelR->save()) {
							throw new \yii\web\HttpException(400, 'Error al guardar el ingreso');
						}
						// pongo la fecha de pago
						$mMov->fecha_pago = date('Y-m-d', strtotime($model->fecha_pago));
						// actualizo la tabla movimiento
						if ($mMov->save()) {
							// luuego actualizo la tabla movimiento_detalle con los correspondientes
							$modelmd->subcuenta_id_fp = $post['forma_pago'][$key];
							$modelmd->subcuenta_id = $post['debito_sc_id'][$key];
							$modelmd->importe = $post['importe'][$key];
							$modelmd->periodo_mes = $periodo_mes;
							$modelmd->periodo_anio = $periodo_anio;
							$modelmd->tipo = strval($v);
							if (!$modelmd->save()) {
								throw new \yii\web\HttpException(400, 'Error al guardar el ingreso 3');
							}
						} else {
							throw new \yii\web\HttpException(400, 'Error al guardar el ingreso 4');
						}
					}

					//echo "nrorecibo= ".$model->nro_recibo."forma pago= ".$post['forma_pago'][$key]."cuenta= ".$post['debito_sc_id'][$key]." ".$v."<br>";
				}
				//die;

			} else {
				// si es egreso
				//guardo el nuevo nro de recibo
				$title = "Engresos";
				$modelR = Recibo::find()->where(['id' => 1])->one();
				$nroRecibo = $modelR->e;
				$modelR->e = $nroRecibo + 1;
				if (!$modelR->save()) {
					throw new \yii\web\HttpException(400, 'Error al guardar el nro de recibo egreso');
				}

				$periodo_mes = $model->periodo_mes;
				$periodo_anio = $model->periodo_anio;

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
			$title = "Ingresos";
		} else {
			// si es egreso
			$nroRecibo = $modelR->getLastNroRecibo('e');
			$title = "Engresos";
		}

		// paso fecha actual
        date_default_timezone_set('America/Buenos_Aires');
        $model->fecha_pago = date('d-m-Y',time());
		
		return $this->render('index', [
			'model' => $model,
			'nroRecibo' => $nroRecibo,
			'title' => $title,
			'v' => $v,
			'tipo' => $v,
		]);

	}

	public function actionGenerarDebito() {

		$model = new Movimiento(['scenario' => 'generardebito']);

		if ($model->load(Yii::$app->request->post())) {
			// obtengo todos los registro de la tabla socio_debito con los parametros socio_desde y socio_hasta
			// para luego consultar con el campo id_debito en la tabla "debito" obtener datos de la tabla.
			$modelS = Socio::find()->where(['>=', 'id', $model->socio_desde])->andWhere(['<=', 'id', $model->socio_hasta])->orderBy('id ASC')->all();

			$i = 0;
			// por cada socio
			foreach ($modelS as $s) {

				if ($i == 0) {
					$idSocio = $s->id;
					$i = $i + 1;
				}
				//verifico que no este dado de baja
				if ($s->fecha_baja == null) {
					// busco los debitos que tiene el socio
					$modelSD = SocioDebito::findAll(['id_socio' => $s->id]);

					// genero las cuotas a partir de los perido desde hasta del año actual
					//for ($f=$model->periodo_mes_desde; $f <=$model->periodo_mes_desde ; $f++) {
					// doy de alta en movimiento el socio para luego agregar los debitos en la tabla movimiento detalle
					$mMovimiento = new Movimiento();
					$mMovimiento->fk_cliente = $s->id;
					if (!$mMovimiento->save()) {
						throw new \yii\web\HttpException(400, 'Error al insertar en movimiento', 405);
					} else {
						// si inserto en movimiento.
						// Ahora tengo q insertar los debitos del socio en movimiento_detalle
						//por cada debito del socio
						foreach ($modelSD as $sd) {
							//verificar si ya se genero esa cuota
							$verificar = MovimientoDetalle::find()
								->joinWith('movimiento')
								->where(['movimiento.fk_cliente' => $s->id])
								->andWhere(['subcuenta_id' => $sd->debito->subcuenta_id])
								->andWhere(['periodo_mes' => $model->periodo_mes_desde])
								->andWhere(['periodo_anio' => $model->periodo_anio])->one();
							// si no se repite la cuota generada,genero la cuota si no no hace nada
							if ($verificar == null) {
								//si el select con id subcuenta_id es cero es por que eligio la opcion  "todos" (todas las cuentas) del select
								if ($model->subcuenta_id == 0) {
									//var_dump("etro cero");die;
									// inserto
									$modelMovDetalle = new MovimientoDetalle();
									$modelMovDetalle->tipo = 'i';
									$modelMovDetalle->movimiento_id = $mMovimiento->id;
									$modelMovDetalle->periodo_mes = $model->periodo_mes_desde;
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
									$modelMovDetalle->periodo_mes = $model->periodo_mes_desde;
									$modelMovDetalle->periodo_anio = $model->periodo_anio;
									$modelMovDetalle->subcuenta_id = $sd->debito->subcuenta_id;
									$modelMovDetalle->importe = $sd->debito->importe;

									if (!$modelMovDetalle->save()) {
										throw new \yii\web\HttpException(400, 'Error al insertar movimiento_detalle 2', 405);
									} else {
										$msj = "Se generaron los debitos con existo";
									}

								}

							}

						} // end foreach ($modelSD as $sd) {

					} // end else si inserto en tabla movimiento

					//}// for i <=

				} // en if fecha_baja

				$idSocio = $msd->id_socio;

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

	public function actionPagar() {

		try {
			$post = Yii::$app->request->post();
			$id = $post['id'];
			$fecha_pago = $post['fecha_pago'];
			$importe_pago = $post['importe_pago'];
			$modelMD = MovimientoDetalle::findOne($id);
			$modelMD->importe = $importe_pago;
			$modelMD->subcuenta_id_fp = 4;
			$modelMD->tipo = 'i';
			$movimiento_id = $modelMD->movimiento_id;
			if ($modelMD->save()) {
				$modelM = Movimiento::findOne($movimiento_id);
				$modelM->fecha_pago = date('Y-m-d', strtotime($fecha_pago));
				if (!$modelM->save()) {
					throw new \yii\web\HttpException(400, 'Error al guardar pago 2');
				}
			} else {
				throw new \yii\web\HttpException(400, 'Error al guardar pago 1');
			}

		} catch (Exception $e) {
			echo "Error function pagar" . $e;
		}

	}

	/*** IMPIRMIR RECIBO INGRESO ***/
	public function actionImprimirReciboIngreso($id) {

		$m = Movimiento::find()->where(['id' => $id])->one();
		$modelDetalle = MovimientoDetalle::find()->where(['movimiento_id' => $m->id])->all();
		$md = new MovimientoDetalle();		
		$mpdf = new mPDF('utf-8', 'A4');
		$mpdf->WriteHTML($this->renderPartial('_imprimir_recibo_ingreso', [
			'm' => $m,
			'modelDetalle' => $modelDetalle,
			'md'=>$md,
		]));
		$mpdf->Output();
		exit;

	}

	/*** IMPIRMIR RECIBO EGRESO ***/
	public function actionImprimirReciboEgreso($id) {

		$m = Movimiento::find()->where(['id' => $id])->one();
		$modelDetalle = MovimientoDetalle::find()->where(['movimiento_id' => $m->id])->one();
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
		$modelR = Recibo::findOne(1);
		$nro_recibo = $modelR->i;
		$modelR->i = $nro_recibo + 1;
		$modelR->save();

		$mpdf = new mPDF('utf-8', 'A4');
		$mpdf->WriteHTML($this->renderPartial('_imprimir_recibo_individual', [
			'm' => $m,
			'modelDetalle' => $modelDetalle,
			'nro_recibo' => $nro_recibo,
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
		if ($model->fk_cliente == null) {
			$v = 'e';
		} else {
			$v = 'i';
		}
		$model->delete();
		return $this->redirect(['view', 'v' => $v]);
	}

	public function actionDeleted($id) {

		$model = MovimientoDetalle::findOne(['id' => $id]);
		if (!$model->delete()) {
			throw new \yii\web\HttpException(400, 'Error al borrar');
		} else {
			return $this->redirect(['estado-cuenta']);
		}

	}

	public function actionEstadoCuenta() {

		$model = new Movimiento();

		$dataProvider = $model->getAllEstadoCuenta();

		$deuda = $model->getDeudaTotal();
		//var_dump($deuda->importe);
		return $this->render('estado_cuenta', [
			'dataProvider' => $dataProvider,
			'deuda' => $deuda,
		]);

	}

	public function actionEstadoCuentaByCodigo() {

		$post = Yii::$app->request->post();

		$codigo = $post['codigo'];

		$model = new Movimiento();

		$deuda = $model->getDeudaTotalBySocio($codigo, 'codigo');

		$dataProvider = $model->getAllEstadoCuentaByCodigo($codigo);

		return $this->render('_gridview_estado_cuenta', [
			'dataProvider' => $dataProvider,
			'deuda' => $deuda,
		]);

	}

	public function actionEstadoCuentaByNombre() {

		$post = Yii::$app->request->post();

		$nombre = $post['nombre'];

		$model = new Movimiento();

		$deuda = $model->getDeudaTotalBySocio($nombre, 'nombre');

		$dataProvider = $model->getAllEstadoCuentaByNombre($nombre);

		return $this->render('_gridview_estado_cuenta', [
			'dataProvider' => $dataProvider,
			'deuda' => $deuda,
		]);

	}

	public function actionEstadoCuentaByCodigoSocio() {

		$post = Yii::$app->request->post();

		$codigo_socio = $post['codigo_socio'];

		$model = new Movimiento();

		$deuda = $model->getDeudaTotalBySocio($codigo_socio, 'codigo_socio');

		$dataProvider = $model->getAllEstadoCuentaByCodigoSocio($codigo_socio);

		return $this->render('_gridview_estado_cuenta', [
			'dataProvider' => $dataProvider,
			'deuda' => $deuda,
		]);

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

	/************************************************* CONSULTAS *****************************************/

	public function actionConsultaMovimientoCaja() {

		//$model = new Movimiento();

		if (Yii::$app->request->post()) {

			$post = Yii::$app->request->post();

			$fecha_desde = date('Y-m-d', strtotime($post['fecha_desde']));
			$fecha_hasta = date('Y-m-d', strtotime($post['fecha_hasta']));

			$movimiento = Movimiento::find()->where(['>=', 'fecha_pago', $fecha_desde])->andWhere(['<=', 'fecha_pago', $fecha_hasta])->andWhere(['not', ['fecha_pago' => null]])->all();

			$mpdf = new mPDF('utf-8', 'A4');
			$mpdf->WriteHTML($this->renderPartial('_imprimir_saldo_caja', [
				'movimiento' => $movimiento,
				'fecha_desde' => $fecha_desde,
				'fecha_hasta' => $fecha_hasta,
			]));
			$mpdf->Output();
			exit;

		}


		return $this->render('_consulta', [
			'accion' => "Movimientos de Caja",
		]);

	}

	public function actionConsultaIngresos() {

		$model = new Movimiento();

		if (Yii::$app->request->post()) {

			$post = Yii::$app->request->post();

			$fecha_desde = date('Y-m-d', strtotime($post['fecha_desde']));
			$fecha_hasta = date('Y-m-d', strtotime($post['fecha_hasta']));

			$movimiento = Movimiento::find()->where(['>=', 'fecha_pago', $fecha_desde])->andWhere(['<=', 'fecha_pago', $fecha_hasta])->andWhere(['not', ['fecha_pago' => null]])->all();

			$mpdf = new mPDF('utf-8', 'A4');
			$mpdf->WriteHTML($this->renderPartial('_imprimir_ingresos', [
				'movimiento' => $movimiento,
				'fecha_desde' => $fecha_desde,
				'fecha_hasta' => $fecha_hasta,
			]));
			$mpdf->Output();
			exit;

		}

		return $this->render('_consulta', [
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
			$categoria = $post['categorias'];
			$estado_opcion = $post['estado_opcion'];			
						
			$this->imprimirEstadoCuenta($fecha_desde,$fecha_hasta,$deporte,$categoria,$estado_opcion);
		}


		$consultaSocios = Socio::find()->all();	
		// formo el array socio con el dni concatenado ;)
	 	foreach ($consultaSocios as $cs) {
            $socios[$cs['id']] = $cs['apellido_nombre'] . "  - Dni:  ". $cs['dni'] ;
        }	
		
		$consultaCategorias = CategoriaSocial::find()->all();
		$categorias = ArrayHelper::map($consultaCategorias, 'id', 'descripcion');	
		
	 	$consultaDebitos = Debito::find()->asArray()->all();
		$deportes = ArrayHelper::map($consultaDebitos, 'id', 'concepto');
        
		return $this->render('_consulta_estado_cuenta', [
			'socios' => $socios,
			'categorias' => $categorias,
			'deportes' => $deportes,			
			'accion' => "Estado de Cuenta",
		]);

	}

	/*	
	**	CONSULTAS DE ESTADO DE CUENTA 
	*/
	private function imprimirEstadoCuenta($fecha_desde,$fecha_hasta,$deporte,$categoria,$estado_opcion){
			
			$mes_desde   = date('m', strtotime($fecha_desde));
			$mes_hasta   = date('m', strtotime($fecha_desde));
			$anio_desde  = date('Y', strtotime($fecha_hasta));
			$anio_hasta  = date('Y', strtotime($fecha_hasta));

			$cat = CategoriaSocial::findOne($categoria);			
			$dep = Debito::findOne($deporte);
		
			$sql = "SELECT s.id,s.apellido_nombre,s.id_categoria_social FROM socio  s
					JOIN socio_debito sd ON sd.id_socio = s.id
					WHERE s.id_categoria_social = " . $categoria . " AND sd.id_debito = ". $deporte ." ORDER BY s.id DESC" ;
			
			$socio = Socio::findBySql($sql)->all();
			
			$movimientoDetalle = MovimientoDetalle::find()
				->joinWith('movimiento')
				->where(['movimiento.fecha_pago' => null])
				->andWhere(['>=', 'periodo_mes', $mes_desde])
				->andWhere(['>=', 'periodo_anio', $anio_desde])
				->andWhere(['<=', 'periodo_mes', $mes_hasta])
				->andWhere(['<=', 'periodo_anio', $anio_hasta])
				->andWhere(['subcuenta_id'=>$dep->subcuenta_id])
				->all();

			$titulo = " - Deudas";
			
			/**
			****** IMPRIMIR 
			**/
			$mpdf = new mPDF('utf-8', 'A4');
			$mpdf->WriteHTML($this->renderPartial('_imprimir_consulta_estado_cuenta', [				
				'fecha_desde' => $fecha_desde,
				'fecha_hasta' => $fecha_hasta,	
				'deporte' => $deporte,
				'categoria' => $categoria,
				'socio' => $socio,
				'movimientoDetalle' => $movimientoDetalle,
				'cat' => $cat,
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
				$movimiento = Movimiento::find()->where(['>=', 'fecha_pago', $fecha_desde])->andWhere(['<=', 'fecha_pago', $fecha_hasta])->andWhere(['not', ['fk_prov' => null]])->all();				
			} else{
				$movimiento = Movimiento::find()->where(['>=', 'fecha_pago', $fecha_desde])->andWhere(['<=', 'fecha_pago', $fecha_hasta])->andWhere(['fk_prov' => $proveedor])->all();				
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
