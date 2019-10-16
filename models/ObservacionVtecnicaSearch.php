<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ObservacionVtecnica;

/**
 * ObservacionVtecnicaSearch represents the model behind the search form about `app\models\ObservacionVtecnica`.
 */
class ObservacionVtecnicaSearch extends ObservacionVtecnica
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'vtecnica_id'], 'integer'],
            [['descripcion', 'archivo', 'elemento'], 'safe'],
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
        $query = ObservacionVtecnica::find();

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
            'vtecnica_id' => $this->vtecnica_id,
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'archivo', $this->archivo])
            ->andFilterWhere(['like', 'elemento', $this->elemento]);

        return $dataProvider;
    }
}
