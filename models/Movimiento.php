<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "movimiento".
 *
 * @property integer $id
 * @property integer $nro_recibo
 * @property string $fecha_pago
 * @property integer $fk_prov
 * @property integer $fk_cliente
 * @property integer $cuenta
 * @property integer $forma_pago
 * @property string $importe
 * @property string $obs
 * @property string $tipo
 * @property string $socio.apellido_nombre
 * @property string $proveedor.nombre
 * @property integer $periodo_mes_desde
 * @property integer $periodo_mes_hasta
 * @property integer $periodo_anio
 * @property string $socio_desde
 * @property string $socio_hasta
 * @property string $subc_id
 * @property string $subcuenta_id
 * @property string $fecha_vencimiento
 * @property string $fecha_desde
 * @property string $fecha_hasta
 */
class Movimiento extends \yii\db\ActiveRecord {

	public $cuenta;
	public $forma_pago;
	public $importe;
	public $tipo;
	public $periodo_mes;
	public $periodo_mes_desde;
	public $periodo_mes_hasta;
	public $periodo_anio;
	public $socio_desde;
	public $socio_hasta;
	public $subc_id;
	public $subcuenta_id;
	public $fecha_vencimiento;
	public $fecha_desde;
	public $fecha_hasta;

	public static function tableName() {
		return 'movimiento';
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			//[['nro_recibo', 'fecha_pago'], 'required'],
			[['fk_prov', 'fk_cliente', 'periodo_mes', 'periodo_anio'], 'integer'],
			[['fecha_pago'], 'safe'],
			[['nro_recibo'], 'string', 'max' => 15],
			[['obs'], 'string', 'max' => 150],
			[['tipo'], 'string', 'max' => 1],
			[['fecha_vencimiento', 'periodo_mes_desde', 'periodo_mes_hasta', 'periodo_anio', 'socio_desde', 'socio_hasta'], 'required', 'on' => 'generardebito'],

		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'id' => '',
			'nro_recibo' => 'Nro Recibo',
			'fecha_pago' => 'Fecha Pago',
			'fk_prov' => 'Proveedor',
			'fk_cliente' => 'Socio/Cliente',
			'fk_sc' => 'Cuenta',
			'obs' => 'Nota',
			'cuenta' => 'Cuenta',
			'forma_pago' => 'Forma de Pago',
			'importe' => 'Importe',
			'tipo' => '',
			'socio.apellido_nombre' => 'Cliente / Socio',
			'proveedor.nombre' => 'Proveedor',
			'periodo_mes' => 'Periodo Mes',
			'periodo_mes_desde' => 'Periodo Mes',
			'periodo_mes_hasta' => 'Mes Hasta',
			'periodo_anio' => 'Periodo Año',
			'fecha_vencimiento' => 'Fecha Vencimiento',
			'subc_id' => 'Concepto a Debitar',
			'subcuenta_id' => '',
			'periodo_mes' => 'Periodo Mes',
		];
	}

	public function scenarios() {
		$scenarios = parent::scenarios();
		$scenarios['generardebito'] = ['fecha_vencimiento', 'periodo_mes_desde', 'periodo_mes_hasta', 'periodo_anio', 'socio_desde', 'socio_hasta', 'subcuenta_id']; //Scenario Values Only Accepted
		return $scenarios;
	}

	public function getMovimientoDetalle() {
		return $this->hasMany(MovimientoDetalle::className(), ['movimiento_id' => 'id']);
	}

	public function getSocio() {
		return $this->hasOne(Socio::className(), ['id' => 'fk_cliente']);
	}

	public function getProveedor() {
		return $this->hasOne(Proveedor::className(), ['id' => 'fk_prov']);
	}

	public function getSubCuenta() {
		return $this->hasOne(SubCuenta::className(), ['id' => 'subcuenta_id']);
	}

	public function getLastId() {

		$query = self::find()
			->select('id')
			->orderBy('id DESC')->limit(1)->one();

		return $query;
	}

	public function getListMov($v) {

		// si el parametro es i (ingreso) busco en la tabla movimiento todos los que clientes distinos de null
		if ($v == 'i') {
			$query = self::find()->where(['>', 'fk_cliente', ''])->andWhere(['<>', 'fecha_pago', ''])->orderBy('fecha_pago DESC');
		} else {
			$query = self::find()->where(['>', 'fk_prov', ''])->andWhere(['<>', 'fecha_pago', ''])->orderBy('fecha_pago DESC');
		}

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		return $dataProvider;

	}

	public function getAllEstadoCuenta() {

		$mes_actual = date('m');
		$anio_actual = date('Y');
		
		$query = MovimientoDetalle::find()->where(['>=', 'periodo_mes', 1])->andWhere(['<=', 'periodo_mes', 12])->andWhere(['=', 'periodo_anio', $anio_actual]);

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);
		return $dataProvider;
	}

	public function getAllEstadoCuentaByCodigo($codigo) {

		$mes_actual = date('m');
		$anio_actual = date('Y');
		$socio = Socio::find()->where(['dni' => $codigo])->one();

		$query = MovimientoDetalle::find()
			->joinWith('movimiento')
			->where(['movimiento.fk_cliente' => $socio->id])
		//->where(['id'=>$codigo])
			->andWhere(['>=', 'periodo_mes', 1])->andWhere(['<=', 'periodo_mes', 12])->andWhere(['=', 'periodo_anio', $anio_actual]);

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);
		return $dataProvider;
	}

	public function getAllEstadoCuentaByNombre($nombre) {

		$mes_actual = date('m');
		$anio_actual = date('Y');
		$socio = Socio::find()->where(['like', 'apellido_nombre', $nombre . '%', false])->one();

		$query = MovimientoDetalle::find()
			->joinWith('movimiento')
			->where(['movimiento.fk_cliente' => $socio->id])
			->andWhere(['>=', 'periodo_mes', 1])->andWhere(['<=', 'periodo_mes', 12])->andWhere(['=', 'periodo_anio', $anio_actual]);

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);
		return $dataProvider;
	}

	public function getAllEstadoCuentaByCodigoSocio($codigo_socio) {

		$mes_actual = date('m');
		$anio_actual = date('Y');

		$query = MovimientoDetalle::find()
			->joinWith('movimiento')
			->where(['movimiento.fk_cliente' => $codigo_socio])
			->andWhere(['>=', 'periodo_mes', 1])->andWhere(['<=', 'periodo_mes', 12])->andWhere(['=', 'periodo_anio', $anio_actual]);

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		return $dataProvider;
	}

	public function getAllEstadoCuentaTodos() {

		$mes_actual = date('m');
		$anio_actual = date('Y');

		$query = MovimientoDetalle::find()
			->andWhere(['>=', 'periodo_mes', 1])->andWhere(['<=', 'periodo_mes', 12])->andWhere(['=', 'periodo_anio', $anio_actual]);

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		return $dataProvider;
	}

	public function getAllEstadoCuentaDeuda() {

		$mes_actual = date('m');
		$anio_actual = date('Y');

		$query = MovimientoDetalle::find()
			->joinWith('movimiento')
			->where(['movimiento.fecha_pago' => null])
			->andWhere(['>=', 'periodo_mes', 1])->andWhere(['<=', 'periodo_mes', 12])->andWhere(['=', 'periodo_anio', $anio_actual]);

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		return $dataProvider;
	}

	public function getDeudaTotal() {

		$mes_actual = date('m');
		$anio_actual = date('Y');

		$sql = "SELECT SUM(importe) AS 'importe' FROM movimiento_detalle md JOIN movimiento m ON md.movimiento_id = m.id WHERE m.fecha_pago is null AND md.periodo_mes>=1 AND md.periodo_mes<=12 AND md.periodo_anio=" . $anio_actual;
		$query = MovimientoDetalle::findBySql($sql)->one();

		/*$dataProvider = new ActiveDataProvider([
		'query' => $query,
		]);*/

		return $query;
	}

	public function getDeudaTotalBySocio($dato, $tipo) {

		$mes_actual = date('m');
		$anio_actual = date('Y');

		if ($tipo == 'codigo') {
			$sql = "SELECT SUM(importe) AS 'importe'
			FROM movimiento_detalle md
			JOIN movimiento m ON md.movimiento_id = m.id
			JOIN socio s ON m.fk_cliente=s.id
			WHERE m.fecha_pago is null AND md.periodo_mes>=1 AND md.periodo_mes<=12 AND md.periodo_anio=" . $anio_actual . " AND s.dni=" . $dato;
		}

		if ($tipo == 'nombre') {
			$sql = "SELECT SUM(importe) AS 'importe'
			FROM movimiento_detalle md
			JOIN movimiento m ON md.movimiento_id = m.id
			JOIN socio s ON m.fk_cliente=s.id
			WHERE m.fecha_pago is null AND md.periodo_mes>=1 AND md.periodo_mes<=12 AND md.periodo_anio=" . $anio_actual . " AND s.apellido_nombre LIKE '" . $dato . "%'";
		}

		if ($tipo == 'codigo_socio') {
			$sql = "SELECT SUM(importe) AS 'importe'
			FROM movimiento_detalle md
			JOIN movimiento m ON md.movimiento_id = m.id
			WHERE m.fecha_pago is null AND md.periodo_mes>=1 AND md.periodo_mes<=12 AND md.periodo_anio=" . $anio_actual . " AND m.fk_cliente=" . $dato;
		}

		$query = MovimientoDetalle::findBySql($sql)->one();

		/*$dataProvider = new ActiveDataProvider([
		'query' => $query,
		]);*/

		return $query;
	}

}
