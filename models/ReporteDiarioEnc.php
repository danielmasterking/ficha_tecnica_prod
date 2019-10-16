<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reporte_diario_enc".
 *
 * @property integer $id
 * @property string $fecha
 * @property string $usuario
 * @property integer $estado_id
 *
 * @property ReporteDiario[] $reporteDiarios
 * @property Usuario $usuario0
 * @property Estado $estado
 */
class ReporteDiarioEnc extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reporte_diario_enc';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fecha', 'usuario', 'estado_id'], 'required'],
            [['fecha'], 'safe'],
            [['estado_id'], 'integer'],
            [['usuario'], 'string', 'max' => 25]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fecha' => 'Fecha',
            'usuario' => 'Usuario',
            'estado_id' => 'Estado ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReportes()
    {
        return $this->hasMany(ReporteDiario::className(), ['reporte_id' => 'id']);
    }

    public function getCount()
    {
        //return ReporteDiario::find()->where(['reporte_id' => $this->id])->count(); 
        //$this->hasMany(ReporteDiario::className(), ['reporte_id' => 'id']);
        return $this->hasMany(ReporteDiario::className(), ['reporte_id' => 'id'])->count();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['usuario' => 'usuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstado()
    {
        return $this->hasOne(Estado::className(), ['id' => 'estado_id']);
    }
}
