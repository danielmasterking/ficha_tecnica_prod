<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "seguimiento_visita".
 *
 * @property integer $id
 * @property integer $visita_id
 * @property string $fecha
 * @property string $observacion
 *
 * @property Visita $visita
 */
class SeguimientoVisita extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'seguimiento_visita';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['visita_id', 'fecha', 'observacion'], 'required'],
            [['visita_id'], 'integer'],
            [['fecha'], 'safe'],
            [['observacion'], 'string', 'max' => 300]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'visita_id' => 'Visita ID',
            'fecha' => 'Fecha',
            'observacion' => 'Observacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVisita()
    {
        return $this->hasOne(Visita::className(), ['id' => 'visita_id']);
    }
}
