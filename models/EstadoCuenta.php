<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estado_cuenta".
 *
 * @property integer $id
 * @property string $fecha_vencimiento
 * @property integer $periodo_mes
 * @property integer $periodo_anio
 * @property string $subcuenta_id
 * @property string $socio_id
 * @property string $fecha_pago
 * @property string $importe_apagar
 * @property string $importe_pagado
 * @property integer $nro_recibo
 * @property integer $socio_desde
 * @property integer $socio_hasta
 * @property integer $subc_id
 * @property string socio.apellido_nombre
 * @property string subCuenta.concepto
 * @property string periodo_mes_desde
 * @property string periodo_mes_hasta
 */
class EstadoCuenta extends \yii\db\ActiveRecord {
	public $socio_desde;
	public $socio_hasta;
	public $subc_id;
	public $periodo_mes_desde;
	public $periodo_mes_hasta;

	public static function tableName() {
		return 'estado_cuenta';
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['periodo_mes', 'periodo_anio', 'subcuenta_id'], 'required'],
			[['fecha_vencimiento', 'fecha_pago'], 'safe'],
			[['subcuenta_id', 'periodo_anio', 'periodo_mes', 'nro_recibo', 'periodo_mes_desde', 'periodo_mes_hasta'], 'integer'],
			[['importe_apagar', 'importe_pagado'], 'number'],
			[['fecha_vencimiento','periodo_mes', 'periodo_anio', 'socio_desde', 'socio_hasta', 'periodo_mes_desde', 'periodo_mes_hasta'], 'required', 'on' => 'generardebito'],

		];
	}

	public function scenarios() {
		$scenarios = parent::scenarios();
		$scenarios['generardebito'] = ['periodo_mes', 'periodo_anio', 'socio_desde', 'socio_hasta', 'subcuenta_id', 'periodo_mes_desde', 'periodo_mes_hasta']; //Scenario Values Only Accepted
		return $scenarios;
	}

	public function getSubCuenta() {
		return $this->hasOne(SubCuenta::className(), ['id' => 'subcuenta_id']);
	}

	public function getSocio() {
		return $this->hasOne(Socio::className(), ['id' => 'socio_id']);
	}

	public function attributeLabels() {
		return [
			'id' => 'ID',
			'fecha_vencimiento' => 'Fecha Vencimiento',
			'periodo_mes' => 'Perido Mes',
			'periodo_anio' => 'Periodo Año',
			'subcuenta_id' => '',
			'socio_id' => 'Socio',
			'fecha_pago' => 'Fecha Pago',
			'importe_apagar' => 'Importe',
			'importe_pagado' => 'Importe Pagado',
			'nro_recibo' => '',
			'subc_id' => 'Concepto a Debitar',
			'socio.apellido_nombre' => 'Socio Nombre',
			'subCuenta.concepto' => 'SubCuenta Concepto',
			'periodo_mes_hasta' => 'Mes Hasta',
			'periodo_mes_desde' => 'Mes Desde',
		];
	}

	public function getEstadoCuenta() {
		// busco en estado de cuenta todos los registros hasta el mes actual
		$mes_actual = date('m');
		$anio_actual = date('Y');
		$mEC = self::find()->where(['<=', 'periodo_mes', $mes_actual])->andWhere(['=', 'periodo_anio', $anio_actual])->all();

	}

	public function getMes($mes) {

		switch ($mes) {
		case "1":
			$m = "Enero";
			break;
		case "2":
			$m = "Febrero";
			break;
		case "3":
			$m = "Marzo";
			break;
		case "4":
			$m = "Abril";
			break;
		case "5":
			$m = "Mayo";
			break;
		case "6":
			$m = "Junio";
			break;
		case "7":
			$m = "Julio";
			break;
		case "8":
			$m = "Agosto";
			break;
		case "9":
			$m = "Septiembre";
			break;
		case "10":
			$m = "Octubre";
			break;
		case "11":
			$m = "Noviembre";
			break;
		case "12":
			$m = "Diciembre";
			break;
		}

		return $m;
	}

}
