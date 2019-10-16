<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "factor_riesgo".
 *
 * @property integer $id
 * @property integer $sucursal_id
 * @property string $archivo
 * @property string $descripcion
 *
 * @property Sucursal $sucursal
 */
class FactorRiesgo extends \yii\db\ActiveRecord
{
    public $image2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'factor_riesgo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sucursal_id', 'fecha'], 'required'],
            [['sucursal_id'], 'integer'],
            [['fecha'], 'safe'],
            
            [['archivo', 'descripcion'], 'string', 'max' => 150],
            [['image2'],'safe'],
            [['image2'],'file','extensions'=>'pdf'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sucursal_id' => 'Sucursal',
            'archivo' => 'Archivo',
            'descripcion' => 'Descripción',
            'image2' => 'Factor de Riesgo (PDF)',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSucursal()
    {
        return $this->hasOne(Sucursal::className(), ['id' => 'sucursal_id']);
    }
}
