<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "memoria".
 *
 * @property integer $id
 * @property integer $sucursal_id
 * @property string $fecha
 * @property string $archivo
 * @property string $descripcion
 *
 * @property Sucursal $sucursal
 */
class Memoria extends \yii\db\ActiveRecord
{
    public $image2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'memoria';
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
            'fecha' => 'Fecha',
            'archivo' => 'Archivo',
            'descripcion' => 'Descripción',
            'image2' => 'Memorias (PDF)',
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
