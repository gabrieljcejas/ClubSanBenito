<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cliente".
 *
 * @property integer $id
 * @property string $razon_social
 * @property string $domicilio
 * @property integer $telefono
 * @property string $mail
 * @property string $obs
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
            [['razon_social'], 'required'],
            [['telefono'], 'integer'],
            [['razon_social'], 'string', 'max' => 100],
            [['domicilio'], 'string', 'max' => 80],
            [['mail', 'rubro'], 'string', 'max' => 50],
            [['obs'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'razon_social' => 'Razon Social',
            'domicilio' => 'Domicilio',
            'telefono' => 'Telefono',
            'mail' => 'Mail',
            'obs' => 'Obs',
            'rubro' => 'Rubro',
        ];
    }

}
