<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "prorroga".
 *
 * @property integer $id
 * @property integer $cedula
 * @property string $apellidos
 * @property string $nombres
 * @property string $fecha
 */
class Prorroga extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'prorroga';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cedula', 'fecha'], 'required'],
            [['cedula'], 'integer'],
            [['fecha','cedula'], 'safe'],
            [['apellidos', 'nombres'], 'string', 'max' => 80]
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
            'nombres' => 'Nombres',
            'fecha' => 'Fecha',
        ];
    }
}
