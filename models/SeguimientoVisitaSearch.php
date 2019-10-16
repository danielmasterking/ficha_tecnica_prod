<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SeguimientoVisita;

/**
 * SeguimientoVisitaSearch represents the model behind the search form about `app\models\SeguimientoVisita`.
 */
class SeguimientoVisitaSearch extends SeguimientoVisita
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'visita_id'], 'integer'],
            [['fecha', 'observacion'], 'safe'],
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
        $query = SeguimientoVisita::find();

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
            'visita_id' => $this->visita_id,
            'fecha' => $this->fecha,
        ]);

        $query->andFilterWhere(['like', 'observacion', $this->observacion]);

        return $dataProvider;
    }
}
