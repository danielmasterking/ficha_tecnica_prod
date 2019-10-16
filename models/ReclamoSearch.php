<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Reclamo;

/**
 * ReclamoSearch represents the model behind the search form about `app\models\Reclamo`.
 */
class ReclamoSearch extends Reclamo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['fecha_reclamo', 'puesto', 'accion_correctiva', 'fecha_solucion'], 'safe'],
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
        $query = Reclamo::find();

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
            'fecha_reclamo' => $this->fecha_reclamo,
        ]);

        $query->andFilterWhere(['like', 'puesto', $this->puesto])
            ->andFilterWhere(['like', 'accion_correctiva', $this->accion_correctiva])
            ->andFilterWhere(['like', 'fecha_solucion', $this->fecha_solucion]);

        return $dataProvider;
    }
}
