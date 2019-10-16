<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "observacion_vtecnica".
 *
 * @property integer $id
 * @property string $descripcion
 * @property string $archivo
 * @property integer $vtecnica_id
 * @property string $elemento
 *
 * @property Vtecnica $vtecnica
 */
class ObservacionVtecnica extends \yii\db\ActiveRecord
{
    public $image2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'observacion_vtecnica';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripcion', 'vtecnica_id', 'elemento'], 'required'],
            [['vtecnica_id'], 'integer'],
            [['descripcion'], 'string', 'max' => 2000],
            [['archivo'], 'string', 'max' => 200],
            [['elemento'], 'string', 'max' => 80],
            [['image2'],'safe'],
            [['image2'],'file','extensions'=> ['jpg','png']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descripcion' => 'Descripcion',
            'archivo' => 'Archivo',
            'vtecnica_id' => 'Vtecnica ID',
            'elemento' => 'Elemento',
            'image2' => 'Fotografia',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVtecnica()
    {
        return $this->hasOne(Vtecnica::className(), ['id' => 'vtecnica_id']);
    }
}
