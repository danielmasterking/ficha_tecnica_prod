<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "visita".
 *
 * @property integer $id
 * @property string $fecha
 * @property integer $sucursal_id
 * @property integer $novedad_id
 * @property string $comentarios
 * @property string $recomendaciones
 * @property string $compromiso_colviseg
 * @property string $compromiso_cliente
 * @property string $usuario
 * @property string $contacto
 * @property string $cargo
 * @property string $vigilante
 * @property string $email_cliente
 * @property string $telefono
 * @property string $reporta
 * @property string $email_reportante
 * @property integer $estado_id
 *
 * @property SeguimientoVisita[] $seguimientoVisitas
 * @property Novedad $novedad
 * @property Usuario $usuario0
 * @property Sucursal $sucursal
 * @property Estado $estado
 * @property Vtecnica[] $vtecnicas
 */
class Visita extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $name;
    public static function tableName()
    {
        return 'visita';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fecha', 'sucursal_id', 'novedad_id', 'comentarios', 'recomendaciones', 'compromiso_colviseg', 'compromiso_cliente', 'usuario', 'estado_id'], 'required'],
            [['fecha'], 'safe'],
            [['sucursal_id', 'novedad_id', 'estado_id','app_id'], 'integer'],
            [['comentarios', 'recomendaciones', 'compromiso_colviseg', 'compromiso_cliente'], 'string', 'max' => 5000],
            [['usuario'], 'string', 'max' => 25],
            [['contacto', 'vigilante'], 'string', 'max' => 80],
            [['cargo', 'reporta'], 'string', 'max' => 45],
            [['email_cliente', 'email_reportante'], 'string', 'max' => 50],
            [['telefono'], 'string', 'max' => 20],
            [['firma_coord','firma_recibe'], 'string', 'max' => 250]
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
            'sucursal_id' => 'Sucursal',
            'novedad_id' => 'Novedad',
            'comentarios' => 'Comentarios',
            'recomendaciones' => 'Recomendaciones',
            'compromiso_colviseg' => 'Compromiso Colviseg',
            'compromiso_cliente' => 'Compromiso Cliente',
            'usuario' => 'Asignar a usuario',
            'contacto' => 'Contacto',
            'cargo' => 'Cargo',
            'vigilante' => 'Vigilante',
            'email_cliente' => 'Email Cliente',
            'telefono' => 'Telefono',
            'reporta' => 'Reporta',
            'email_reportante' => 'Email Reportante',
            'estado_id' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeguimientoVisitas()
    {
        return $this->hasMany(SeguimientoVisita::className(), ['visita_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNovedad()
    {
        return $this->hasOne(Novedad::className(), ['id' => 'novedad_id']);
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
    public function getVtecnicas()
    {
        return $this->hasMany(Vtecnica::className(), ['visita_id' => 'id']);
    }
}
