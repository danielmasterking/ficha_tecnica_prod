<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estudio_seguridad".
 *
 * @property integer $id
 * @property string $archivo
 * @property string $descripcion
 * @property integer $sucursal_id
 * @property string $fecha
 *
 * @property Sucursal $sucursal
 * @property SeguimientoEstudio[] $seguimientoEstudios
 */
class EstudioSeguridad extends \yii\db\ActiveRecord
{
    public $image2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'estudio_seguridad';
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
            'descripcion' => 'Descripción',
            'sucursal_id' => 'Sucursal',
            'fecha' => 'Fecha',
            'image2' => 'Estudio de seguridad (PDF)'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSucursal()
    {
        return $this->hasOne(Sucursal::className(), ['id' => 'sucursal_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeguimientoEstudios()
    {
        return $this->hasMany(SeguimientoEstudio::className(), ['estudio_seguridad_id' => 'id']);
    }
}
