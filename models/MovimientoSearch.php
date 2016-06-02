<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Movimiento;

/**
 * MovimientoSearch represents the model behind the search form about `app\models\Movimiento`.
 */
class MovimientoSearch extends Movimiento
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'tipo_comp', 'nro', 'fk_prov', 'fk_cliente'], 'integer'],
            [['fecha', 'fk_sc', 'obs'], 'safe'],
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
        $query = Movimiento::find();

       

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
         //$query->joinWith('Movimiento');
         //$query->joinWith('Socio');

        $query->andFilterWhere([
            'id' => $this->id,            
            'fecha' => $this->fecha,
            'tipo_comp' => $this->tipo_comp,
            'nro' => $this->nro,
            'fk_prov' => $this->fk_prov,
            'fk_cliente' => $this->fk_cliente,
        ]);

        $query->andFilterWhere(['like', 'fk_sc', $this->fk_sc])
            ->andFilterWhere(['like', 'obs', $this->obs]);
            ->andFilterWhere(['like', 'nro_recibo', $this->nro_recibo]);
            //->andFilterWhere(['like', 'nro_recibo', $this->nro_recibo]);

        return $dataProvider;
    }
}
