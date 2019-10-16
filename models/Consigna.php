<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "consigna".
 *
 * @property integer $id
 * @property string $archivo
 * @property integer $sucursal_id
 * @property string $descripcion
 *
 * @property Sucursal $sucursal
 */
class Consigna extends \yii\db\ActiveRecord
{
    
    public $image2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'consigna';
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
            [['archivo'], 'string', 'max' => 200],
            [['descripcion'], 'string', 'max' => 150],
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
            'archivo' => 'Archivo',
            'sucursal_id' => 'Sucursal',
            'descripcion' => 'Descripcion',
            'image2' => 'Consigna (PDF)',
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
