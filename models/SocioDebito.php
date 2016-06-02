<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "socio_debito".
 *
 * @property integer $id
 * @property integer $id_socio
 * @property integer $id_debito
 * @property integer $debito.concepto
 * @property integer $debito.importe
 * @property integer $debito.subcuenta_id
 * @property integer $socio.fecha_baja
 */
class SocioDebito extends \yii\db\ActiveRecord {
	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'socio_debito';
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['id_socio', 'id_debito'], 'required'],
			[['id_socio', 'id_debito'], 'integer'],
		];
	}

	public function getDebito() {
		return $this->hasOne(Debito::className(), ['id' => 'id_debito']);
	}

	public function getSocio() {
		return $this->hasOne(Socio::className(), ['id' => 'id_socio']);
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'id' => 'ID',
			'id_socio' => '',
			'id_debito' => 'Debito',
			'debito.concepto' => ' Concepto',
			'debito.importe' => 'Importe',
			'debito.subcuenta_id' => 'Debito Subcuenta_id',
			'socio.fecha_baja' => 'Socio Fecha Baja',
		];
	}

}
