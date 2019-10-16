<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario_ciudad".
 *
 * @property string $usuario
 * @property integer $ciudad_id
 *
 * @property Usuario $usuario0
 * @property Ciudad $ciudad
 */
class UsuarioCiudad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usuario_ciudad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['usuario', 'ciudad_id'], 'required'],
            [['ciudad_id'], 'integer'],
            [['usuario'], 'string', 'max' => 80]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'usuario' => 'Usuario',
            'ciudad_id' => 'Ciudad ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario0()
    {
        return $this->hasOne(Usuario::className(), ['usuario' => 'usuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCiudad()
    {
        return $this->hasOne(Ciudad::className(), ['id' => 'ciudad_id']);
    }
}
