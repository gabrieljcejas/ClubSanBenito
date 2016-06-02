<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class GenerarDeudaForm extends Model
{
    public $fecha_vencimiento;
    public $periodo_mes;
    public $periodo_anio;
    public $socio_desde;
    public $socio_hasta;
    public $subcuenta_id;
 


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
    
            [['fecha_vencimiento', 'socio_desde','socio_hasta','periodo_anio','periodo_mes'], 'required'],
            [['subcuenta_id','socio_desde','socio_desde'],'integer'],            
            [['periodo_anio','periodo_mes'],'string']            

            ];
    }

    public function attributeLabels()
    {
        return [
            'fecha_vencimiento' => 'Fecha Vencimiento',
            'periodo_mes' => '',
            'periodo_anio' => '',
            'socio_desde' => 'Socio Desde',
            'socio_hasta' => 'Socio Hasta',
            'subcuenta_id' => 'Concepto a Debitar',
        ];
    }
    

}
        
