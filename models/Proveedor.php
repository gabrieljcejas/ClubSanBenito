<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "proveedor".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $cuit
 * @property string $cond_iva
 * @property string $direccion
 * @property string $telefono
 * @property string $email
 * @property string $rubro
 */
class Proveedor extends \yii\db\ActiveRecord {
	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'proveedor';
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['nombre','cuit', 'cond_iva', 'direccion' ], 'required'],
			[['nombre', 'direccion', 'rubro'], 'string', 'max' => 80],			
			[['email'], 'string', 'max' => 40],
			[['cuit', 'telefono'], 'string', 'max' => 15],
			[['cond_iva'], 'string', 'max' => 20],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'id' => 'ID',
			'nombre' => 'Nombre / Razon Social',			
			'cuit' => 'Cuit/Cuil',
			'cond_iva' => 'Condicion Iva',
			'direccion' => 'Direccion',
			'telefono' => 'Telefono',
			'email' => 'Email',
			'rubro' => 'Rubro',
		];
	}
}
