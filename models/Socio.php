<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "socio".
 *
 * @property integer $id
 * @property string $apellido_nombre
 * @property string $cp
 * @property string $direccion
 * @property integer $dni
 * @property string $email
 * @property string $fecha_alta
 * @property string $fecha_baja
 * @property string $obs
 * @property string $fecha_nacimiento
 * @property integer $nombre_foto 
 * @property integer $id_categoria_social
 * @property integer $id_ciudad
 * @property integer $id_cobrador
 * @property integer $matricula
 * @property string $provincia
 * @property string $sexo
 * @property string $telefono
 * @property string $telefono2
 * @property string $categoriaSocial.descripcion
 * @property string $ciudad.descripcion
 * @property string $provincia.descripcion
 * @property string $id_debito
 * @property string $id_socio
 * @property string $file
 * @property string $edad
 * @property string $antiguedad
 * @property string $codigo_desde
 * @property string $codigo_hasta
    
 */
class Socio extends \yii\db\ActiveRecord
{
    
    public $id_debito;
    public $id_socio;
    public $file;
    public $edad;
    public $antiguedad;
    public $codigo_desde;
    public $codigo_hasta;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'socio';
    }

    /**
     * @Rules
     */
    public function rules()
    {
        return [
            [['apellido_nombre','dni','matricula','direccion','id_categoria_social','id_cobrador','fecha_alta'], 'required'],
            [['dni','id_categoria_social', 'id_ciudad', 'id_cobrador', 'matricula'], 'integer'],
            [['fecha_alta', 'fecha_baja', 'fecha_nacimiento'], 'safe'],
            [['apellido_nombre'], 'string', 'max' => 80],
            [['file'], 'file'],
            [['cp', 'telefono', 'telefono2','edad','antiguedad','codigo_desde','codigo_hasta'], 'string', 'max' => 15],
            [['direccion'], 'string', 'max' => 60],
            [['email'], 'string', 'max' => 30],           
            [['sexo'], 'string', 'max' => 1],
            [['obs'], 'string', 'max' => 150]
        ];
    }
    
       
    /**[['apellido_nombre','cp', 'direccion', 'dni', 'fecha_alta','fecha_nacimiento', 'id_categoria_social', 'id_ciudad', 'id_cobrador', 'matricula', 'id_provincia', 'sexo'], 'required'],
     * @Relaciones
     */      
    public function getCategoriaSocial()
    {
        return $this->hasOne(CategoriaSocial::className(), ['id' => 'id_categoria_social']);
    }
    
    public function getProvincia()
    {
        return $this->hasOne(Provincia::className(), ['id' => 'id_provincia']);
    }
    
    public function getCiudad()
    {
        return $this->hasOne(Ciudad::className(), ['id' => 'id_ciudad']);
    }
    
    public function getCobrador()
    {
        return $this->hasOne(Cobrador::className(), ['id' => 'id_cobrador']);
    }
       
       
    
    /**
     * @attributeLabels
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Codigo Socio',
            'apellido_nombre' => 'Apellido y Nombre',
            'cp' => 'Codigo Postal',
            'direccion' => 'Direccion',
            'dni' => 'Dni',
            'email' => 'Email',
            'fecha_alta' => 'Fecha Alta',
            'fecha_baja' => 'Fecha Baja',
            'fecha_nacimiento' => 'Fecha Nacimiento',
            'nombre_foto' => 'Foto',            
            'id_categoria_social' => 'Categoria Social',
            'id_ciudad' => 'Ciudad',
            'id_cobrador' => 'Cobrador',
            'matricula' => 'Matricula',
            'id_provincia' => 'Provincia',
            'sexo' => 'Sexo',
            'telefono' => 'Telefono',
            'telefono2' => 'Telefono2',
            'categoriaSocial.descripcion'=>'Categoria Social',
            'ciudad.descripcion'=>'Ciudad',
            'provincia.descripcion'=>'Provincia',
            'cobrador.descripcion'=>'Cobrador',
            'id_debito'=>'',
            'id_socio'=>'Codigo Socio',
            'obs'=>'Observacion',
            'edad'=>'Edad',
            'codigo_desde'=>'Codigo Desde',
            'codigo_hasta'=>'Codigo Hasta',
        ];
    }
    
    /**
     * ----------------------FUNCIONES------------------------------------------
     */
    public function findLastId() {
        
         $query= self::find()
                ->select('id')
                ->orderBy('id DESC')->one();
       
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        return $dataProvider;
    }

        
}
