<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario_cliente".
 *
 * @property string $usuario
 * @property integer $nit
 *
 * @property Usuario $usuario0
 * @property Cliente $nit0
 */
class UsuarioCliente extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usuario_cliente';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['usuario', 'nit'], 'required'],
            [['nit'], 'string'],
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
            'nit' => 'Nit',
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
    public function getCliente()
    {
        return $this->hasOne(Cliente::className(), ['nit' => 'nit']);
    }
}
