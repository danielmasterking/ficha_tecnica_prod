<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cliente".
 *
 * @property integer $nit
 * @property string $nombre
 * @property string $direccion
 * @property string $telefono
 * @property string $nombre_contacto
 * @property string $ciudad
 * @property string $fecha_inicio
 * @property string $estado
 *
 * @property Sucursal[] $sucursals
 */
class Cliente extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cliente';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nit', 'nombre'], 'required'],
            [['nit'], 'string'],
            [['fecha_inicio'], 'safe'],
            [['nombre', 'direccion', 'nombre_contacto'], 'string', 'max' => 80],
            [['telefono', 'ciudad'], 'string', 'max' => 45],
            [['estado'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nit' => 'Nit',
            'nombre' => 'Nombre',
            'direccion' => 'Direccion',
            'telefono' => 'Telefono',
            'nombre_contacto' => 'Nombre Contacto',
            'ciudad' => 'Ciudad',
            'fecha_inicio' => 'Fecha Inicio',
            'estado' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSucursales()
    {
        return $this->hasMany(Sucursal::className(), ['nit' => 'nit']);
    }

     public function getClie()
    {
        return $this->hasMany(UsuarioCliente::className(), ['nit' => 'nit']);
    }

}
