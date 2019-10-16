<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\HistoricoArma;

/**
 * HistoricoArmaSearch represents the model behind the search form about `app\models\HistoricoArma`.
 */
class HistoricoArmaSearch extends HistoricoArma
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'arma_id', 'novedad_id'], 'integer'],
            [['fecha', 'observacion', 'usuario'], 'safe'],
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
        $query = HistoricoArma::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'arma_id' => $this->arma_id,
            'novedad_id' => $this->novedad_id,
            'fecha' => $this->fecha,
        ]);

        $query->andFilterWhere(['like', 'observacion', $this->observacion])
            ->andFilterWhere(['like', 'usuario', $this->usuario]);

        return $dataProvider;
    }
}
