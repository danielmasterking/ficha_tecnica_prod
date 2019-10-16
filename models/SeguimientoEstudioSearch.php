<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SeguimientoEstudio;

/**
 * SeguimientoEstudioSearch represents the model behind the search form about `app\models\SeguimientoEstudio`.
 */
class SeguimientoEstudioSearch extends SeguimientoEstudio
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'estudio_seguridad_id'], 'integer'],
            [['fecha', 'archivo'], 'safe'],
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
        $query = SeguimientoEstudio::find();

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
            'estudio_seguridad_id' => $this->estudio_seguridad_id,
            'fecha' => $this->fecha,
        ]);

        $query->andFilterWhere(['like', 'archivo', $this->archivo]);

        return $dataProvider;
    }
}
