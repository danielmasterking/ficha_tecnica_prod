<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "unidad_negocio".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $cliente
 *
 * @property SucursalUnidad[] $sucursalUnidads
 * @property Cliente $cliente0
 */
class UnidadNegocio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'unidad_negocio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'cliente'], 'required'],
            [['nombre'], 'string', 'max' => 80],
            [['cliente'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'cliente' => 'Cliente',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSucursalUnidades()
    {
        return $this->hasMany(SucursalUnidad::className(), ['unidad_negocio_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClienteName()
    {
        return $this->hasOne(Cliente::className(), ['nit' => 'cliente']);
    }
}
