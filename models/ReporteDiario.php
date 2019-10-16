<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reporte_diario".
 *
 * @property integer $id
 * @property integer $reporte_id
 * @property integer $sucursal_id
 * @property string $fecha_registro
 * @property integer $novedad_id
 * @property string $hora
 *
 * @property ReporteDiarioEnc $reporte
 * @property Sucursal $sucursal
 * @property Novedad $novedad
 */
class ReporteDiario extends \yii\db\ActiveRecord
{
    
    public $name;
    public $image2;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reporte_diario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['novedad_id'], 'required'],
            [['reporte_id', 'sucursal_id', 'novedad_id','estado_id','app_id','app_id_cap','app_id_visita_cliente','app_id_inspeccion_riesgo'], 'integer'],
            [['fecha_registro'], 'safe'],
            [['hora'], 'string', 'max' => 10],
            [['observacion'], 'string', 'max' => 2000],
            [['image2'],'safe'],
            [['image2'],'file','extensions'=>'jpg, gif, png, pdf'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reporte_id' => 'Reporte ID',
            'sucursal_id' => 'Sucursal',
            'fecha_registro' => 'Fecha Registro',
            'novedad_id' => 'Novedad',
            'hora' => 'Hora',
            'observacion' => 'Observaciones',
            'estado_id' => 'Estado',
            'archivo' => 'Archivo',
            'image2' => 'Evidencia (Opcional)',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReporte()
    {
        return $this->hasOne(ReporteDiarioEnc::className(), ['id' => 'reporte_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSucursal()
    {
        return $this->hasOne(Sucursal::className(), ['id' => 'sucursal_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstado()
    {
        return $this->hasOne(Estado::className(), ['id' => 'estado_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNovedad()
    {
        return $this->hasOne(Novedad::className(), ['id' => 'novedad_id']);
    }
}
