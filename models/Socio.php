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
 * @property string $grupo_sanguineo
 * @property string $antecedentes_medicos
 * @property string $sanciones
 * @property string $tutor_nombre
 * @property integer $tutor_dni
 * @property string $tutor_fn
 * @property string $tutor_tel

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
            [['dni','id_categoria_social', 'id_ciudad', 'id_cobrador', 'matricula','tutor_dni'], 'integer'],
            [['fecha_alta', 'fecha_baja', 'fecha_nacimiento'], 'safe'],
            [['apellido_nombre'], 'string', 'max' => 80],
            [['grupo_sanguineo','antecedentes_medicos','sanciones','tutor_nombre','tutor_fn','tutor_tel'], 'string'],
            [['file'], 'file'],
            [['cp', 'telefono', 'telefono2','edad','antiguedad','codigo_desde','codigo_hasta'], 'string', 'max' => 15],
            [['direccion'], 'string', 'max' => 60],
            [['email'], 'string', 'max' => 30],           
            [['sexo'], 'string', 'max' => 1],
            [['obs'], 'string', 'max' => 150]
        ];
    }
    
       
    /**
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
            'id' => 'Codigo',
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
            'telefono' => 'Celular',
            'telefono2' => 'Telefono',
            'categoriaSocial.descripcion'=>'Categoria Social',
            'ciudad.descripcion'=>'Ciudad',
            'provincia.descripcion'=>'Provincia',
            'cobrador.descripcion'=>'Cobrador',
            'id_debito'=>'',
            'id_socio'=>'Codigo',
            'obs'=>'Observacion',
            'edad'=>'Edad',
            'codigo_desde'=>'Codigo Desde',
            'codigo_hasta'=>'Codigo Hasta',
            'grupo_sanguineo'=> 'Grupo Sanguineo',
            'antecedentes_medicos'=>'Antecedentes Medicos',
            'sanciones'=>'Sanciones',
            'tutor_nombre'=> 'Nombre',
            'tutor_dni'=> 'Dni',
            'tutor_fn'=> 'Fecha Nacimiento',
            'tutor_tel'=>'Telefono',
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
