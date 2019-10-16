<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "arma_sucursal".
 *
 * @property integer $arma_id
 * @property integer $sucursal_id
 *
 * @property Arma $arma
 * @property Sucursal $sucursal
 */
class ArmaSucursal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'arma_sucursal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['arma_id', 'sucursal_id'], 'required'],
            [['arma_id', 'sucursal_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'arma_id' => 'Arma',
            'sucursal_id' => 'Sucursal',
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
    public function getSucursal()
    {
        return $this->hasOne(Sucursal::className(), ['id' => 'sucursal_id']);
    }
}
