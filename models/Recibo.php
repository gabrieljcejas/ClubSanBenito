<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "recibo".
 *
 * @property integer $id
 * @property integer $i
 * @property integer $e
 */
class Recibo extends \yii\db\ActiveRecord {
	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'recibo';
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['i', 'e'], 'integer'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'id' => 'ID',
			'i' => 'I',
			'e' => 'E',
		];
	}

	public function getLastNroRecibo($v) {

		if ($v == 'i') {

			$query = self::find()->select('i')->where(['id' => 1])->one();

			if ($query == "") {
				$valor = 1;
			} else {
				$valor = $query->i + 1;
			}

		} else {

			$query = self::find()->select('e')->where(['id' => 1])->one();

			if ($query == "") {
				$valor = 1;
			} else {
				$valor = $query->e + 1;
			}

		}

		return $valor;

	}

}
