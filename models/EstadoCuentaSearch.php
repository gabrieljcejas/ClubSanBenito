<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EstadoCuenta;

/**
 * EstadoCuentaSearch represents the model behind the search form about `app\models\EstadoCuenta`.
 */
class EstadoCuentaSearch extends EstadoCuenta
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'subcuenta_id', 'socio_id'], 'integer'],
            [['fecha_vencimiento', 'periodo_mes', 'periodo_anio', 'fecha_pago'], 'safe'],
            [['importe_apagar', 'importe_pagado'], 'number'],
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
        $query = EstadoCuenta::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith('socio');

        $query->andFilterWhere([
            'id' => $this->id,
            'fecha_vencimiento' => $this->fecha_vencimiento,
            'subcuenta_id' => $this->subcuenta_id,
            //'socio_id' => $this->socio_id,
            'fecha_pago' => $this->fecha_pago,
            'periodo_anio' => $this->periodo_anio,
            'periodo_mes' => $this->periodo_mes,
            'importe_apagar' => $this->importe_apagar,
            'importe_pagado' => $this->importe_pagado,
        ]);

        $query->andFilterWhere(['like', 'socio.apellido_nombre', $this->socio_id]);

        return $dataProvider;
    }
}
