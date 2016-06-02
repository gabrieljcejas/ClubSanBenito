<?php

namespace app\controllers;

use app\models\Cuenta;
use app\models\SubCuenta;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;

/**
 * CuentaController implements the CRUD actions for Cuenta model.
 */
class CuentaController extends Controller {
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
	 * Lists all Cuenta models.
	 * @return mixed
	 */
	public function actionIndex() {
		$cuenta = Cuenta::find()->all();
		$subcuenta = SubCuenta::find()->all();

		$mCuenta = new Cuenta();
		$mSubCuenta = new SubCuenta();

		return $this->render('index', [
			'cuenta' => $cuenta,
			'subcuenta' => $subcuenta,
			'mCuenta' => $mCuenta,
			'mSubCuenta' => $mSubCuenta,
		]);
	}

	/**
	 * Displays a single Cuenta model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id) {
		return $this->render('view', [
			'model' => $this->findModel($id),
		]);
	}

	/**
	 * Creates a new Cuenta model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate() {

		$model = new Cuenta();

		if (Yii::$app->request->post()) {
			//return $this->redirect(['index', 'id' => $model->id]);
			$post = $post = Yii::$app->request->post();
			$model->codigo = $post['codigo'];
			$model->concepto = $post['concepto'];
			if (!$model->save()) {
				throw new \yii\web\HttpException(400, 'Wrong method', 405);
			}

		}

	}

	public function actionCreateSc() {
		//var_dump("finnn");die;
		$model = new SubCuenta();
		$post = $post = Yii::$app->request->post();
		$model->codigo = $post['codigo'];
		$model->concepto = $post['concepto'];

		$codigo = $post['codigo'];
		$idsubcuenta = $post['idsubcuenta'];
		$id_cuenta = $post['id_cuenta'];

		// si la cantidad es 1 guardo la subcuenta en la tabla subcuenta con id_cuenta de la cuenta principal
		if (strlen($id_cuenta) == 1) {
			$model->id_cuenta = $id_cuenta;
			// GUARDO
			if (!$model->save()) {
				throw new \yii\web\HttpException(400, 'Wrong method a', 405);
			}
		} else {
			//si es mas de uno ej: 1.1 guardo el la tabla subcuenta en el campo nsubcuenta
			//guardo cero por q no correspond a una cuenta principal si no a una subcuenta
			$model->id_cuenta = "0";
			// GUARDO
			if (!$model->save()) {
				throw new \yii\web\HttpException(400, 'Wrong method b', 405);
			} else {
				//grabo y busco la subcuenta con el codigo para agregar al campo nsubcuenta el id de la nueva subcuenta para poder relacionarla/*
				$modelo = SubCuenta::find()
					->where(['=', 'codigo', $id_cuenta])
					->one();
				//verifico si nsubcuenta es vacio
				if ($modelo->nsubcuenta == "") {
					//guardo el id de la nueva subcuenta sin el guion, si no quedaria asi ej: -7
					$modelo->nsubcuenta = strval($model->id);
				} else {
					$modelo->nsubcuenta = strval($modelo->nsubcuenta . "-" . $model->id);
				}
				if (!$modelo->save()) {
					throw new \yii\web\HttpException(400, 'Wrong method c', 405);
				}
			}

		};

	}

	public function actionUltimaSc() {

		try {
			$post = $post = Yii::$app->request->post();
			$codigo = $post['codigo_sc'];
			// busco la subcuenta
			$model = SubCuenta::find()->where(['=', 'codigo', $codigo])->one();
			
			// verifico que tenga subcuentas
			if ($model->nsubcuenta != null) {
				$id = explode("-", $model->nsubcuenta);
				$count = count($id);
				//busco ese id "3" el codigo para poder devolverlo, sumarle 1  y mostrarlo
				$modelo = SubCuenta::find()->where(['=', 'id', $id[$count - 1]])->one();
				//extraigo el codigo
				$idsc = explode(".", $modelo->codigo);
				//cuento cuantos nros son
				$countsc = count($idsc);
				// si tiene nros que es obvio pero igual :)
				if ($countsc > 0) {
					//extraigo todo el codigo menos el utlimo nro para despues sumarle uno y obtener el codigo siguiente
					$cantidad = strlen($modelo->codigo);
					$extcod = substr($modelo->codigo, 0, $cantidad - 1);
					//formo el nuevo numero
					$nuevo_nro = $extcod . ($idsc[$countsc - 1] + 1);
					echo $nuevo_nro;
				}
			} else {
				// si es null busco en el campo id_cuenta
				$mo = SubCuenta::find()->where(['=', 'id_cuenta', $codigo])->orderBy('codigo DESC')->limit(1)->one();
				//var_dump($mo);die;
				if ($mo != null) {
					$idsc = explode(".", $mo->codigo);
					//cuento cuantos nros son
					$countsc = count($idsc);

					// si tiene nros que es obvio pero igual :)
					if ($countsc > 0) {
						//extraigo todo el codigo menos el utlimo nro para despues sumarle uno y obtener el codigo siguiente
						$cantidad = strlen($mo->codigo);
						$extcod = substr($mo->codigo, 0, $cantidad - 1);
						//formo el nuevo numero
						$nuevo_nro = $extcod . ($idsc[$countsc - 1] + 1);
						echo $nuevo_nro;
					}
				} else {
					//si no tiene nsubcuenta la subcuenta
					$cantidad = strlen($codigo);
					$extcod = substr($codigo, 0, $cantidad);
					//formo el nuevo numero
					$nuevo_nro = $extcod . "." . ($idsc[$countsc - 1] + 1);
					echo $nuevo_nro;
				}

			}

		} catch (Exception $e) {
			echo "Error function cuenta/controller" . $e;
		}

	}

	public function actionEliminarSC() {
		
		try{			
			$post = $post = Yii::$app->request->post();
			$subcuenta_codigo = $post['subcuenta_codigo'];			
			$model = SubCuenta::find()->where(['=', 'codigo', $subcuenta_codigo])->one();			
			// si encuentra subcuenta con ese codigo , ej: 1.1.2
			if ($model!=null){				
				$model->delete();
			}
		} catch (Exception $e) {
			echo "Error al Eliminar Cuenta/Subcuenta" . $e;
		}
	}



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
	 * Deletes an existing Cuenta model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id) {
		$this->findModel($id)->delete();

		return $this->redirect(['index']);
	}

	/**
	 * Finds the Cuenta model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Cuenta the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = Cuenta::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
