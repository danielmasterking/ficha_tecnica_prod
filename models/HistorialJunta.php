<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "historial_junta".
 *
 * @property integer $id
 * @property string $usuario
 * @property string $mensaje
 * @property string $fecha
 *
 * @property Usuario $usuario0
 */
class HistorialJunta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'historial_junta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['usuario', 'mensaje'], 'required'],
            [['fecha'], 'safe'],
            [['usuario'], 'string', 'max' => 25],
            [['mensaje'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuario' => 'Usuario',
            'mensaje' => 'Mensaje',
            'fecha' => 'Fecha',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario0()
    {
        return $this->hasOne(Usuario::className(), ['usuario' => 'usuario']);
    }
}
