<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sucursal_unidad".
 *
 * @property integer $unidad_negocio_id
 * @property integer $sucursal_id
 *
 * @property UnidadNegocio $unidadNegocio
 * @property Sucursal $sucursal
 */
class SucursalUnidad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sucursal_unidad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['unidad_negocio_id', 'sucursal_id'], 'required'],
            [['unidad_negocio_id', 'sucursal_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'unidad_negocio_id' => 'Unidad Negocio ID',
            'sucursal_id' => 'Sucursal ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnidadNegocio()
    {
        return $this->hasOne(UnidadNegocio::className(), ['id' => 'unidad_negocio_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSucursal()
    {
        return $this->hasOne(Sucursal::className(), ['id' => 'sucursal_id']);
    }
}
