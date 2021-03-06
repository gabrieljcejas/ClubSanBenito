<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cuenta".
 *
 * @property integer $id
 * @property string $codigo
 * @property string $concepto
 * @property integer $tipo_cuenta
 */
class Cuenta extends \yii\db\ActiveRecord {
	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'cuenta';
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['codigo', 'concepto'], 'required'],
			[['tipo_cuenta'], 'integer'],
			[['codigo'], 'string', 'max' => 15],
			[['concepto'], 'string', 'max' => 60],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'id' => 'ID',
			'codigo' => 'Codigo',
			'concepto' => 'Concepto',
			'tipo_cuenta' => 'Tipo Cuenta',
		];
	}

	public function getLastId() {

		$query = self::find()
			->select('codigo')
			->orderBy('codigo DESC')->one();

		return $query;

	}
}
