<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "junta".
 *
 * @property integer $id
 * @property string $fecha
 * @property string $descripcion
 *
 * @property ArchivoJunta[] $archivoJuntas
 */
class Junta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'junta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fecha'], 'required'],
            [['fecha'], 'safe'],
            [['descripcion'], 'string', 'max' => 5000],
            [['titulo'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fecha' => 'Fecha',
            'descripcion' => 'Descripcion',
            'titulo' => 'Titulo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArchivos()
    {
        return $this->hasMany(ArchivoJunta::className(), ['junta_id' => 'id']);
    }
}
