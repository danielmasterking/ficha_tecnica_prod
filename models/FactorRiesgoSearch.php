<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\FactorRiesgo;

/**
 * FactorRiesgoSearch represents the model behind the search form about `app\models\FactorRiesgo`.
 */
class FactorRiesgoSearch extends FactorRiesgo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sucursal_id'], 'integer'],
            [['archivo', 'descripcion'], 'safe'],
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
        $query = FactorRiesgo::find();

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
            'sucursal_id' => $this->sucursal_id,
        ]);

        $query->andFilterWhere(['like', 'archivo', $this->archivo])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
