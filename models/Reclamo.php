<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reclamo".
 *
 * @property integer $id
 * @property string $fecha_reclamo
 * @property string $puesto
 * @property string $accion_correctiva
 * @property string $fecha_solucion
 */
class Reclamo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reclamo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fecha_reclamo', 'puesto', 'accion_correctiva'], 'required'],
            [['fecha_reclamo','nombre'], 'safe'],
            [['puesto','nombre'], 'string', 'max' => 80],
            [['accion_correctiva'], 'string', 'max' => 500],
            [['fecha_solucion'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fecha_reclamo' => 'Fecha Reclamo',
            'puesto' => 'Puesto',
            'accion_correctiva' => 'Accion Correctiva',
            'fecha_solucion' => 'Fecha Solucion',
            'nombre' => 'Nombre',
        ];
    }
}
