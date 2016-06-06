<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Asistencia;

/**
 * AsistenciaSearch represents the model behind the search form about `app\models\Asistencia`.
 */
class AsistenciaSearch extends Asistencia
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_socio'], 'integer'],
            [['fecha_hora'], 'safe'],
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
        $query = Asistencia::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'id_socio' => $this->id_socio,
            'fecha_hora' => $this->fecha_hora,
        ]);

        //$query->andFilterWhere(['like', 'evento', $this->evento]);

        return $dataProvider;
    }
}