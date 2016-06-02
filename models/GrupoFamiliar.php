<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "grupo_familiar".
 *
 * @property integer $id
 * @property integer $apellido_nombre
 * @property integer $relacion
 * @property integer $id_socio
 */
class GrupoFamiliar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'grupo_familiar';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['apellido_nombre', 'relacion', 'id_socio'], 'required'],
            [['apellido_nombre', 'relacion', 'id_socio'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'apellido_nombre' => 'Apellido Nombre',
            'relacion' => 'Relacion',
            'id_socio' => 'Id Socio',
        ];
    }
}
