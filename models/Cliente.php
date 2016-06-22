<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cliente".
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
class Cliente extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cliente';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre', 'direccion', 'rubro'], 'string', 'max' => 80],
            [['cuit', 'telefono'], 'string', 'max' => 15],
            [['cond_iva'], 'string', 'max' => 20],
            [['email'], 'string', 'max' => 40],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'cuit' => 'Cuit',
            'cond_iva' => 'Cond Iva',
            'direccion' => 'Direccion',
            'telefono' => 'Telefono',
            'email' => 'Email',
            'rubro' => 'Rubro',
        ];
    }
}
