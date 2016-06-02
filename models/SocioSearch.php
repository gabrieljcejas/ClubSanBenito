<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Socio;

/**
 * SocioSearch represents the model behind the search form about `app\models\Socio`.
 */
class SocioSearch extends Socio
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'dni', 'nombre_foto', 'id_categoria_social', 'id_ciudad', 'id_cobrador', 'matricula'], 'integer'],
            [['apellido_nombre', 'cp', 'direccion', 'email', 'fecha_alta', 'fecha_baja', 'fecha_nacimiento','id_provincia', 'sexo', 'telefono', 'telefono2'], 'safe'],
        ];
    }
    
   
    
    
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Socio::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        //$query->joinWith(['categoriaSocial']);
        
        $query->andFilterWhere([
            'id' => $this->id,
            'dni' => $this->dni,
            'fecha_alta' => $this->fecha_alta,
            'fecha_baja' => $this->fecha_baja,
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'nombre_foto' => $this->nombre_foto,
            'id_categoria_social' => $this->id_categoria_social,
            'id_ciudad' => $this->id_ciudad,
            'id_cobrador' => $this->id_cobrador,
            'matricula' => $this->matricula,
             //'categoria_social.descripcion' => $this->id_categoria_social,
        ]);

        $query->andFilterWhere(['like', 'apellido_nombre', $this->apellido_nombre])
            ->andFilterWhere(['like', 'cp', $this->cp])
            ->andFilterWhere(['like', 'direccion', $this->direccion])
            ->andFilterWhere(['like', 'email', $this->email])            
            ->andFilterWhere(['like', 'id_provincia', $this->id_provincia])
            ->andFilterWhere(['like', 'sexo', $this->sexo])
            ->andFilterWhere(['like', 'telefono', $this->telefono])
            ->andFilterWhere(['like', 'telefono2', $this->telefono2]);

        return $dataProvider;
    }
}
