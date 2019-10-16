<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "preaviso".
 *
 * @property integer $id
 * @property integer $cedula
 * @property string $apellidos
 * @property string $nombre
 * @property string $fecha
 * @property string $ubicacion
 */
class Preaviso extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'preaviso';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cedula',  'fecha'], 'required'],
            [['cedula'], 'integer'],
            [['fecha'], 'safe'],
            [['apellidos', 'nombre', 'ubicacion'], 'string', 'max' => 80]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cedula' => 'Cedula',
            'apellidos' => 'Apellidos',
            'nombre' => 'Nombre',
            'fecha' => 'Fecha',
            'ubicacion' => 'Ubicacion',
        ];
    }
}
