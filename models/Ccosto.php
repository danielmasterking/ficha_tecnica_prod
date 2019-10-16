<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ccosto".
 *
 * @property integer $id
 * @property string $nombre
 *
 * @property CcostoCiudad[] $ccostoCiudads
 * @property Ciudad[] $ciudads
 * @property UsuarioCcosto[] $usuarioCcostos
 * @property Usuario[] $usuarios
 */
class Ccosto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ccosto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 45]
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCcostoCiudads()
    {
        return $this->hasMany(CcostoCiudad::className(), ['ccosto_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCiudades()
    {
        return $this->hasMany(Ciudad::className(), ['id' => 'ciudad_id'])->viaTable('ccosto_ciudad', ['ccosto_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioCcostos()
    {
        return $this->hasMany(UsuarioCcosto::className(), ['ccosto_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuario::className(), ['usuario' => 'usuario'])->viaTable('usuario_ccosto', ['ccosto_id' => 'id']);
    }
}
