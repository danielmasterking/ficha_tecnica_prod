<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Prorroga;

/**
 * ProrrogaSearch represents the model behind the search form about `app\models\Prorroga`.
 */
class ProrrogaSearch extends Prorroga
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cedula'], 'integer'],
            [['apellidos', 'nombres', 'fecha'], 'safe'],
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
        $query = Prorroga::find();

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
            'cedula' => $this->cedula,
            'fecha' => $this->fecha,
        ]);

        $query->andFilterWhere(['like', 'apellidos', $this->apellidos])
            ->andFilterWhere(['like', 'nombres', $this->nombres]);

        return $dataProvider;
    }
}
