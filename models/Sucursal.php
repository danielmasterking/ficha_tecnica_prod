<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sucursal".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $direccion
 * @property integer $nit
 * @property integer $ciudad_id
 * @property 
 *
 * @property Contacto[] $contactos
 * @property ReporteDiario[] $reporteDiarios
 * @property Cliente $nit0
 * @property Ciudad $ciudad
 * @property UsuarioSucursal[] $usuarioSucursals
 * @property Usuario[] $usuarios
 * @property Visita[] $visitas
 */
class Sucursal extends \yii\db\ActiveRecord
{
    public $image2;
    public $name;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sucursal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'nit', 'ciudad_id'], 'required'],
            [[ 'ciudad_id'], 'integer'],
            [[ 'nit','estado','temporal'], 'string'],
            [['nombre', 'direccion'], 'string', 'max' => 80],
            [['image'], 'string', 'max' => 200],
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
            'nombre' => 'Nombre',
            'direccion' => 'Direccion',
            'nit' => 'Nit',
            'ciudad_id' => 'Ciudad ID',
            'cod_oasis' => 'Código Oasis',
            'image2' => 'Adjuntar Imagen',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContactos()
    {
        return $this->hasMany(Contacto::className(), ['sucursal_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReporteDiarios()
    {
        return $this->hasMany(ReporteDiario::className(), ['sucursal_id' => 'id']);
    }

    public function getReportes()
    {
        return $this->hasMany(ReporteDiario::className(), ['sucursal_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCliente()
    {
        return $this->hasOne(Cliente::className(), ['nit' => 'nit']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCiudad()
    {
        return $this->hasOne(Ciudad::className(), ['id' => 'ciudad_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioSucursales()
    {
        return $this->hasMany(UsuarioSucursal::className(), ['sucursal_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuario::className(), ['usuario' => 'usuario'])->viaTable('usuario_sucursal', ['sucursal_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVisitas()
    {
        return $this->hasMany(Visita::className(), ['sucursal_id' => 'id']);
    }

    public function getMemorias()
    {
        return $this->hasMany(Memoria::className(), ['sucursal_id' => 'id']);
    }
}
