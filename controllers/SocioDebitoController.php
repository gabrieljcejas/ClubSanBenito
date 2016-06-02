<?php

namespace app\controllers;

use app\models\SocioDebito;
use app\models\SocioDebitoSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * SocioDebitoController implements the CRUD actions for SocioDebito model.
 */
class SocioDebitoController extends Controller {
	public function behaviors() {
		return [
			'verbs' => [
				'class' => VerbFilter::className(),
				/*'actions' => [
			'delete' => ['post'],
			],*/
			],
		];
	}

	/**
	 * Lists all SocioDebito models.
	 * @return mixed
	 */
	public function actionIndex() {
		$searchModel = new SocioDebitoSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single SocioDebito model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id) {
		return $this->render('view', [
			'model' => $this->findModel($id),
		]);
	}

	/**
	 * Creates a new SocioDebito model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate() {
		$model = new SocioDebito();

		if ($model->load(Yii::$app->request->post())) {
			$post = Yii::$app->request->post();
			echo $post['id_debito'];die;
			$model->save();
			return $this->redirect(['view', 'id' => $model->id]);
			//return $this->redirect(Yii::$app->request->referrer);
		} else {
			return $this->renderAjax('create', [
				'model' => $model,
			]);
		}
	}
	public function actionAgregar() {

		$post = Yii::$app->request->post();

		$model = new SocioDebito();

		$model->id_debito = $post['id_debito'];
		$model->id_socio = $post['id_socio'];
		$model->save();
	}

	/**
	 * Updates an existing SocioDebito model.
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
	 * Deletes an existing SocioDebito model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id) {
		$this->findModel($id)->delete();

		return $this->redirect(['index']);
	}

	/**
	 * Finds the SocioDebito model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return SocioDebito the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = SocioDebito::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
