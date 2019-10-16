<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "autor_visita".
 *
 * @property integer $visita_id
 * @property string $usuario
 *
 * @property Visita $visita
 * @property Usuario $usuario0
 */
class AutorVisita extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'autor_visita';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['visita_id', 'usuario'], 'required'],
            [['visita_id'], 'integer'],
            [['usuario'], 'string', 'max' => 25]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'visita_id' => 'Visita ID',
            'usuario' => 'Usuario',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVisita()
    {
        return $this->hasOne(Visita::className(), ['id' => 'visita_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['usuario' => 'usuario']);
    }
}
