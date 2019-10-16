<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "seguimiento_estudio".
 *
 * @property integer $id
 * @property integer $estudio_seguridad_id
 * @property string $fecha
 * @property string $archivo
 *
 * @property EstudioSeguridad $estudioSeguridad
 */
class SeguimientoEstudio extends \yii\db\ActiveRecord
{
    public $image2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'seguimiento_estudio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['estudio_seguridad_id', 'fecha'], 'required'],
            [['estudio_seguridad_id'], 'integer'],
            [['fecha'], 'safe'],
            [['archivo'], 'string', 'max' => 150],
            [['observacion'],'string', 'max' => 5000],
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
            'estudio_seguridad_id' => 'Estudio Seguridad',
            'fecha' => 'Fecha',
            'archivo' => 'Archivo',
            'observacion' => 'Observaciones',
            'image2' => 'Seguimiento Estudio (PDF)',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstudio()
    {
        return $this->hasOne(EstudioSeguridad::className(), ['id' => 'estudio_seguridad_id']);
    }
}
