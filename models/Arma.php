<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "arma".
 *
 * @property integer $id
 * @property string $serie
 * @property string $vencimiento
 * @property integer $calibre_id
 * @property integer $tipo_arma_id
 * @property integer $permiso_arma_id
 * @property string $archivo
 * @property string $salvoconducto
 * @property string $estado
 *
 * @property Calibre $calibre
 * @property TipoArma $tipoArma
 * @property PermisoArma $permisoArma
 * @property ArmaSucursal[] $armaSucursals
 * @property HistoricoArma[] $historicoArmas
 */
class Arma extends \yii\db\ActiveRecord
{
    public $image2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'arma';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['serie', 'calibre_id', 'tipo_arma_id', 'permiso_arma_id', 'salvoconducto'], 'required'],
            [['vencimiento'], 'safe'],
            [['calibre_id', 'tipo_arma_id', 'permiso_arma_id','municion'], 'integer'],
            [['serie', 'salvoconducto'], 'string', 'max' => 100],
            [['archivo'], 'string', 'max' => 200],
            [['estado'], 'string', 'max' => 1],
            [['serie'], 'unique'],
            [['image2'],'safe'],
            [['image2'],'file','extensions'=>'pdf'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'serie' => 'Serie',
            'vencimiento' => 'Vencimiento',
            'calibre_id' => 'Calibre',
            'tipo_arma_id' => 'Tipo Arma',
            'permiso_arma_id' => 'Permiso Arma',
            'archivo' => 'Archivo',
            'salvoconducto' => 'Salvoconducto',
            'estado' => 'Estado',
            'image2' => 'Archivo',
            'municion'=>'Numero de municiones'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalibre()
    {
        return $this->hasOne(Calibre::className(), ['id' => 'calibre_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipo()
    {
        return $this->hasOne(TipoArma::className(), ['id' => 'tipo_arma_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPermiso()
    {
        return $this->hasOne(PermisoArma::className(), ['id' => 'permiso_arma_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArmasucursal()
    {
        return $this->hasMany(ArmaSucursal::className(), ['arma_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHistorico()
    {
        return $this->hasMany(HistoricoArma::className(), ['arma_id' => 'id']);
    }


    public static function CiudadArma($id_arma){
        $query= (new \yii\db\Query())
        ->select('ciudad.nombre,sucursal.nombre as Sucursal')
        ->from('arma')
        ->innerJoin('arma_sucursal', 'arma.id = arma_sucursal.arma_id')
        ->innerJoin('sucursal', 'arma_sucursal.sucursal_id = sucursal.id')
        ->innerJoin('ciudad', 'sucursal.ciudad_id = ciudad.id')
        ->where('arma.id='.$id_arma.'')
        ->orderby('arma_sucursal.id DESC')
        ->limit(1);
        $command = $query->createCommand();
        $rows = $command->queryOne();

        return $rows;

    }
}
