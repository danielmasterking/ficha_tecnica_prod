<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Visita;

/**
 * VisitaSearch represents the model behind the search form about `app\models\Visita`.
 */
class VisitaSearch extends Visita
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sucursal_id', 'novedad_id', 'estado_id'], 'integer'],
            [['fecha', 'comentarios', 'recomendaciones', 'compromiso_colviseg', 'compromiso_cliente', 'usuario', 'contacto', 'cargo', 'vigilante', 'email_cliente', 'telefono', 'reporta', 'email_reportante'], 'safe'],
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
        $query = Visita::find();

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
            'fecha' => $this->fecha,
            'sucursal_id' => $this->sucursal_id,
            'novedad_id' => $this->novedad_id,
            'estado_id' => $this->estado_id,
        ]);

        $query->andFilterWhere(['like', 'comentarios', $this->comentarios])
            ->andFilterWhere(['like', 'recomendaciones', $this->recomendaciones])
            ->andFilterWhere(['like', 'compromiso_colviseg', $this->compromiso_colviseg])
            ->andFilterWhere(['like', 'compromiso_cliente', $this->compromiso_cliente])
            ->andFilterWhere(['like', 'usuario', $this->usuario])
            ->andFilterWhere(['like', 'contacto', $this->contacto])
            ->andFilterWhere(['like', 'cargo', $this->cargo])
            ->andFilterWhere(['like', 'vigilante', $this->vigilante])
            ->andFilterWhere(['like', 'email_cliente', $this->email_cliente])
            ->andFilterWhere(['like', 'telefono', $this->telefono])
            ->andFilterWhere(['like', 'reporta', $this->reporta])
            ->andFilterWhere(['like', 'email_reportante', $this->email_reportante]);

        return $dataProvider;
    }
}
