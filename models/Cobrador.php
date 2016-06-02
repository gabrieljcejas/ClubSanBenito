<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cobrador".
 *
 * @property integer $id
 * @property string $descripcion
 * @property string $comision
 */
class Cobrador extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cobrador';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripcion', 'comision'], 'required'],
            [['comision'], 'number'],
            [['descripcion'], 'string', 'max' => 40]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descripcion' => 'Descripcion',
            'comision' => 'Comision',
        ];
    }
}
