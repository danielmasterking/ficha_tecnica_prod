<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "archivo_junta".
 *
 * @property integer $id
 * @property string $archivo
 * @property string $descripcion
 * @property integer $junta_id
 *
 * @property Junta $junta
 */
class ArchivoJunta extends \yii\db\ActiveRecord
{
    public $image2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'archivo_junta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['archivo', 'junta_id'], 'required'],
            [['junta_id'], 'integer'],
            [['archivo'], 'string', 'max' => 300],
            [['descripcion'], 'string', 'max' => 5000],
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
            'descripcion' => 'Descripcion',
            'junta_id' => 'Junta',
            'image2' => 'Archivo (PDF)',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJunta()
    {
        return $this->hasOne(Junta::className(), ['id' => 'junta_id']);
    }
}
