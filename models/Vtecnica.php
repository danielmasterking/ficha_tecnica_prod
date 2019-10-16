<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vtecnica".
 *
 * @property integer $id
 * @property integer $visita_id
 * @property string $presentacion
 * @property string $minuta
 * @property string $armamento
 * @property string $equipos_seguridad
 * @property string $equipos_comunicacion
 * @property string $iluminacion
 * @property string $acceso
 * @property string $perimetro
 * @property string $cerraduras
 * @property string $consigna_general
 * @property string $consigna_particular
 * @property string $instrucciones
 * @property string $alarmas
 * @property string $cctv
 * @property string $otros
 * @property string $seguridad_industrial
 *
 * @property Visita $visita
 */
class Vtecnica extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vtecnica';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['visita_id'], 'required'],
            [['visita_id','app_id'], 'integer'],
            [['presentacion', 'minuta', 'armamento', 'equipos_seguridad', 'equipos_comunicacion', 'iluminacion', 'acceso', 'perimetro', 'cerraduras', 'consigna_general', 'consigna_particular', 'instrucciones', 'alarmas', 'cctv', 'otros', 'seguridad_industrial'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'visita_id' => 'Visita ID',
            'presentacion' => 'Presentacion',
            'minuta' => 'Minuta',
            'armamento' => 'Armamento',
            'equipos_seguridad' => 'Equipos Seguridad',
            'equipos_comunicacion' => 'Equipos Comunicacion',
            'iluminacion' => 'Iluminacion',
            'acceso' => 'Acceso',
            'perimetro' => 'Perimetro',
            'cerraduras' => 'Cerraduras',
            'consigna_general' => 'Consigna General',
            'consigna_particular' => 'Consigna Particular',
            'instrucciones' => 'Instrucciones',
            'alarmas' => 'Alarmas',
            'cctv' => 'Cctv',
            'otros' => 'Otros',
            'seguridad_industrial' => 'Seguridad Industrial',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVisita()
    {
        return $this->hasOne(Visita::className(), ['id' => 'visita_id']);
    }
}
