<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SocioDebito;

/**
 * SocioDebitoSearch represents the model behind the search form about `app\models\SocioDebito`.
 */
class SocioDebitoSearch extends SocioDebito
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_socio', 'id_debito'], 'integer'],
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
        $query = SocioDebito::find();

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
            'id_debito' => $this->id_debito,
        ]);

        return $dataProvider;
    }
}
