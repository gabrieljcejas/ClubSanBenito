<?php

namespace app\models;

use Yii;
use app\models\RolOperacion;
/**
 * This is the model class for table "rol".
 *
 * @property integer $id
 * @property string $nombre
 */
class Rol extends \yii\db\ActiveRecord
{
    
    public $operaciones;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rol';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 60],
            ['operaciones', 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Rol',
        ];
    }


    public function afterSave($insert, $changedAttributes)
    {
        //var_dump("aftersave!");die;
        \Yii::$app->db->createCommand()->delete('rol_operacion', 'rol_id = '.(int) $this->id)->execute();
        
        if (!empty($this->operaciones)){
            
            foreach ($this->operaciones as $id) {
                $ro = new RolOperacion();
                $ro->rol_id = $this->id;
                $ro->operacion_id = $id;
                $ro->save();
            }
            
        }
    }

    public function getRolOperaciones()
    {
        return $this->hasMany(RolOperacion::className(), ['rol_id' => 'id']);
    }
     
    public function getOperacionesPermitidas()
    {
        return $this->hasMany(Operacion::className(), ['id' => 'operacion_id'])
            ->viaTable('rol_operacion', ['rol_id' => 'id']);
    }
     
    public function getOperacionesPermitidasList()
    {
        return $this->getOperacionesPermitidas()->asArray();
    }

    /**
     * @RELACIONES
     */
    public function getUsers() 
    {
            return $this->hasMany(User::className(), ['rol_id' => 'id']);
    }

}
