<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Vtecnica;

/**
 * VtecnicaSearch represents the model behind the search form about `app\models\Vtecnica`.
 */
class VtecnicaSearch extends Vtecnica
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'visita_id'], 'integer'],
            [['presentacion', 'minuta', 'armamento', 'equipos_seguridad', 'equipos_comunicacion', 'iluminacion', 'acceso', 'perimetro', 'cerraduras', 'consigna_general', 'consigna_particular', 'instrucciones', 'alarmas', 'cctv', 'otros', 'seguridad_industrial'], 'safe'],
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
        $query = Vtecnica::find();

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
        ]);

        $query->andFilterWhere(['like', 'presentacion', $this->presentacion])
            ->andFilterWhere(['like', 'minuta', $this->minuta])
            ->andFilterWhere(['like', 'armamento', $this->armamento])
            ->andFilterWhere(['like', 'equipos_seguridad', $this->equipos_seguridad])
            ->andFilterWhere(['like', 'equipos_comunicacion', $this->equipos_comunicacion])
            ->andFilterWhere(['like', 'iluminacion', $this->iluminacion])
            ->andFilterWhere(['like', 'acceso', $this->acceso])
            ->andFilterWhere(['like', 'perimetro', $this->perimetro])
            ->andFilterWhere(['like', 'cerraduras', $this->cerraduras])
            ->andFilterWhere(['like', 'consigna_general', $this->consigna_general])
            ->andFilterWhere(['like', 'consigna_particular', $this->consigna_particular])
            ->andFilterWhere(['like', 'instrucciones', $this->instrucciones])
            ->andFilterWhere(['like', 'alarmas', $this->alarmas])
            ->andFilterWhere(['like', 'cctv', $this->cctv])
            ->andFilterWhere(['like', 'otros', $this->otros])
            ->andFilterWhere(['like', 'seguridad_industrial', $this->seguridad_industrial]);

        return $dataProvider;
    }
}
