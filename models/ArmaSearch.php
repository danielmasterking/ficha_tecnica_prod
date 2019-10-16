<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Arma;

/**
 * ArmaSearch represents the model behind the search form about `app\models\Arma`.
 */
class ArmaSearch extends Arma
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'calibre_id', 'tipo_arma_id', 'permiso_arma_id'], 'integer'],
            [['serie', 'vencimiento', 'archivo', 'salvoconducto', 'estado'], 'safe'],
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
        $query = Arma::find();

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
            'vencimiento' => $this->vencimiento,
            'calibre_id' => $this->calibre_id,
            'tipo_arma_id' => $this->tipo_arma_id,
            'permiso_arma_id' => $this->permiso_arma_id,
        ]);

        $query->andFilterWhere(['like', 'serie', $this->serie])
            ->andFilterWhere(['like', 'archivo', $this->archivo])
            ->andFilterWhere(['like', 'salvoconducto', $this->salvoconducto])
            ->andFilterWhere(['like', 'estado', $this->estado]);

        return $dataProvider;
    }
}
