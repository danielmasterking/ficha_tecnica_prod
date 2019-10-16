<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "novedad".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $tipo
 * @property string $tecnica
 *
 * @property ReporteDiario[] $reporteDiarios
 * @property Visita[] $visitas
 */
class Novedad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'novedad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 45],
            [['tipo', 'tecnica','estado'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'tipo' => 'Tipo',
            'tecnica' => 'Tecnica',
            'estado' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReporteDiarios()
    {
        return $this->hasMany(ReporteDiario::className(), ['novedad_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVisitas()
    {
        return $this->hasMany(Visita::className(), ['novedad_id' => 'id']);
    }
}
