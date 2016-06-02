<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "debito".
 *
 * @property integer $id
 * @property string $concepto
 * @property string $importe
 * @property integer $subcuenta_id
 * @property integer $subCuenta.concepto
 * @property integer $subCuenta.codigo
 */
class Debito extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'debito';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['concepto', 'importe', 'subcuenta_id'], 'required'],
            [['importe'], 'number'],
            [['subcuenta_id'], 'integer'],
            [['concepto'], 'string', 'max' => 60]
        ];
    }

    /**
     * @inheritdoc
     */

    public function getSubCuenta()
    {
        return $this->hasOne(SubCuenta::className(), ['id' => 'subcuenta_id']);
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'concepto' => 'Concepto',
            'importe' => 'Importe',
            'subcuenta_id' => 'Cuenta',
            'subCuenta.concepto'=> 'Concepto Cuenta',
            'subCuenta.codigo'=> 'Codigo Cuenta',

        ];
    }
    
    //concatenar Concepto y Precio
    public function getListConceptoImporte() {
        
        $query=  self::find()->asArray()->all();
                
        return $query;
    }
    
}
