<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "asistencia".
 *
 * @property integer $id
 * @property string $evento
 * @property integer $id_socio
 * @property string $fecha_hora
 * @property integer $dni_socio
 */
class Asistencia extends \yii\db\ActiveRecord
{
    
    public $dni_socio;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'asistencia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_socio', 'fecha_hora'], 'required'],
            [['id_socio'], 'integer'],
            [['fecha_hora'], 'safe'],          
        ];
    }
    
    public function getSocio()
    {
        return $this->hasOne(Socio::className(), ['id' => 'id_socio']);
    }
    
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Codigo',           
            'id_socio' => 'Socio',
            'fecha_hora' => 'Fecha Hora',
            'dni_socio'=>'Codigo/Dni'
        ];
    }
}
