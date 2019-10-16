<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario_ccosto".
 *
 * @property string $usuario
 * @property integer $ccosto_id
 *
 * @property Usuario $usuario0
 * @property Ccosto $ccosto
 */
class UsuarioCcosto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usuario_ccosto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['usuario', 'ccosto_id'], 'required'],
            [['ccosto_id'], 'integer'],
            [['usuario'], 'string', 'max' => 25]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'usuario' => 'Usuario',
            'ccosto_id' => 'Ccosto ID',
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
    public function getCcosto()
    {
        return $this->hasOne(Ccosto::className(), ['id' => 'ccosto_id']);
    }
}
