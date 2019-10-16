<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ccosto_ciudad".
 *
 * @property integer $ccosto_id
 * @property integer $ciudad_id
 *
 * @property Ccosto $ccosto
 * @property Ciudad $ciudad
 */
class CcostoCiudad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ccosto_ciudad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ccosto_id', 'ciudad_id'], 'required'],
            [['ccosto_id', 'ciudad_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ccosto_id' => 'Ccosto ID',
            'ciudad_id' => 'Ciudad ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCcosto()
    {
        return $this->hasOne(Ccosto::className(), ['id' => 'ccosto_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCiudad()
    {
        return $this->hasOne(Ciudad::className(), ['id' => 'ciudad_id']);
    }
}
