<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contacto".
 *
 * @property string $nombres
 * @property string $apellidos
 * @property string $telefono
 * @property string $direccion
 * @property string $email
 * @property integer $sucursal_id
 * @property string $cumpleaño
 *
 * @property Sucursal $sucursal
 */
class Contacto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contacto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombres', 'apellidos', 'telefono', 'sucursal_id','direccion','email','cumpleano'], 'required'],
            ['email', 'email'],
            [['sucursal_id','telefono'], 'integer'],
            [['cumpleano'], 'safe'],
            [['nombres', 'apellidos'], 'string', 'max' => 80],
            [['telefono'], 'string', 'max' => 15],
            [['direccion'], 'string', 'max' => 45],
            [['email'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nombres' => 'Nombres',
            'apellidos' => 'Apellidos',
            'telefono' => 'Telefono',
            'direccion' => 'Cargo',
            'email' => 'Email',
            'sucursal_id' => 'Sucursal ID',
            'cumpleano' => 'Cumpleaño',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSucursal()
    {
        return $this->hasOne(Sucursal::className(), ['id' => 'sucursal_id']);
    }
}
