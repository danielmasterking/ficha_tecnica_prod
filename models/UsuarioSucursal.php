<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario_sucursal".
 *
 * @property string $usuario
 * @property integer $sucursal_id
 * @property string $coordinador
 *
 * @property Usuario $usuario0
 * @property Sucursal $sucursal
 */
class UsuarioSucursal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usuario_sucursal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['usuario', 'sucursal_id'], 'required'],
            [['sucursal_id'], 'integer'],
            [['usuario'], 'string', 'max' => 80],
            [['coordinador'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'usuario' => 'Usuario',
            'sucursal_id' => 'Sucursal ID',
            'coordinador' => 'Coordinador',
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
    public function getSucursal()
    {
        return $this->hasOne(Sucursal::className(), ['id' => 'sucursal_id']);
    }
}
