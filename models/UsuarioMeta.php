<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario_meta".
 *
 * @property integer $id
 * @property integer $cantidad
 * @property string $usuario_usuario
 *
 * @property Usuario $usuarioUsuario
 */
class UsuarioMeta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usuario_meta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cantidad'], 'integer'],
            [['usuario_usuario'], 'required'],
            [['usuario_usuario'], 'string', 'max' => 25]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cantidad' => 'Cantidad',
            'usuario_usuario' => 'Usuario',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['usuario' => 'usuario_usuario']);
    }
}
