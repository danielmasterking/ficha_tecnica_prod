<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "informe_gestion".
 *
 * @property integer $id
 * @property string $titulo
 * @property string $descripcion
 * @property string $fecha
 * @property string $archivo
 * @property string $fecha_registro
 * @property string $cliente
 *
 * @property Cliente $cliente0
 */
class InformeGestion extends \yii\db\ActiveRecord
{
    
    public $image2;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'informe_gestion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['titulo', 'fecha', 'archivo', 'fecha_registro', 'cliente'], 'required'],
            [['fecha', 'fecha_registro'], 'safe'],
            [['titulo'], 'string', 'max' => 100],
            [['descripcion', 'archivo'], 'string', 'max' => 500],
            [['cliente'], 'string', 'max' => 20],
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
            'titulo' => 'Titulo',
            'descripcion' => 'Descripción',
            'fecha' => 'Fecha',
            'archivo' => 'Archivo',
            'fecha_registro' => 'Fecha Registro',
            'cliente' => 'Cliente',
            'image2' => 'Archivo (PDF)',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCliente2()
    {
        return $this->hasOne(Cliente::className(), ['nit' => 'cliente']);
    }
}
