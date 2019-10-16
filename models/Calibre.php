<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "calibre".
 *
 * @property integer $id
 * @property string $nombre
 *
 * @property Arma[] $armas
 */
class Calibre extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'calibre';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 45]
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArmas()
    {
        return $this->hasMany(Arma::className(), ['calibre_id' => 'id']);
    }
}
