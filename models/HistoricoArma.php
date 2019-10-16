<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "historico_arma".
 *
 * @property integer $id
 * @property integer $arma_id
 * @property integer $novedad_id
 * @property string $fecha
 * @property string $observacion
 * @property string $usuario
 *
 * @property Arma $arma
 * @property Novedad $novedad
 * @property Usuario $usuario0
 */
class HistoricoArma extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'historico_arma';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'novedad_id', 'fecha', 'observacion', 'usuario'], 'required'],
            [['arma_id', 'novedad_id'], 'integer'],
            [['fecha'], 'safe'],
            [['observacion'], 'string', 'max' => 5000],
            [['usuario'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'arma_id' => 'Arma',
            'novedad_id' => 'Novedad',
            'fecha' => 'Fecha',
            'observacion' => 'Observación',
            'usuario' => 'Usuario',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArma()
    {
        return $this->hasOne(Arma::className(), ['id' => 'arma_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNovedad()
    {
        return $this->hasOne(Novedad::className(), ['id' => 'novedad_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario0()
    {
        return $this->hasOne(Usuario::className(), ['usuario' => 'usuario']);
    }
}
