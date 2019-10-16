<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pendiente".
 *
 * @property integer $id
 * @property integer $comite_id
 * @property string $compromiso
 * @property string $fecha_entrega
 * @property string $tarea_derivada
 *
 * @property Comite $comite
 * @property ResponsablePendiente[] $responsablePendientes
 */
class Pendiente extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pendiente';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['comite_id', 'compromiso'], 'required'],
            [['comite_id'], 'integer'],
            [['fecha_entrega'], 'safe'],
            [['compromiso', 'tarea_derivada'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'comite_id' => 'Comite ID',
            'compromiso' => 'Compromiso',
            'fecha_entrega' => 'Fecha Entrega',
            'tarea_derivada' => 'Tarea Derivada',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComite()
    {
        return $this->hasOne(Comite::className(), ['id' => 'comite_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResponsablePendientes()
    {
        return $this->hasMany(ResponsablePendiente::className(), ['pendiente_id' => 'id']);
    }
}
