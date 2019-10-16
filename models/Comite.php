<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comite".
 *
 * @property integer $id
 * @property string $fecha
 * @property string $asunto
 * @property string $archivo
 *
 * @property Pendiente[] $pendientes
 */
class Comite extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comite';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fecha', 'asunto'], 'required'],
            [['fecha'], 'safe'],
            [['asunto'], 'string', 'max' => 200],
            [['archivo'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fecha' => 'Fecha',
            'asunto' => 'Asunto',
            'archivo' => 'Archivo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPendientes()
    {
        return $this->hasMany(Pendiente::className(), ['comite_id' => 'id']);
    }
}
