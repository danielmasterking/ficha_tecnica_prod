<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "permiso_arma".
 *
 * @property integer $id
 * @property string $nombre
 *
 * @property Arma[] $armas
 */
class PermisoArma extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'permiso_arma';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 50]
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
        return $this->hasMany(Arma::className(), ['permiso_arma_id' => 'id']);
    }
}
