<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "adjunto".
 *
 * @property integer $cedula
 * @property string $image
 * @property string $fecha
 * @property integer $id
 */
class Adjunto extends \yii\db\ActiveRecord
{
    public $image2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'adjunto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cedula'], 'required'],
            [['cedula'], 'integer'],
            [['fecha'], 'safe'],
            [['image'], 'string', 'max' => 100],
            [['image2'],'safe'],
            [['image2'],'file','extensions'=>'jpg, gif, png, pdf'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cedula' => 'Cedula',
            'image' => 'Image',
            'fecha' => 'Fecha',
            'id' => 'ID',
            'image' => 'Image',
            'image2' => 'Carta Firmada',
        ];
    }
}
