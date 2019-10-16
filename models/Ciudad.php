<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ciudad".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $cod_oasis
 *
 * @property CcostoCiudad[] $ccostoCiudads
 * @property Ccosto[] $ccostos
 * @property Sucursal[] $sucursals
 * @property UsuarioCiudad[] $usuarioCiudads
 * @property Usuario[] $usuarios
 */
class Ciudad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ciudad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'cod_oasis'], 'required'],
            [['nombre'], 'string', 'max' => 45],
            [['cod_oasis'], 'string', 'max' => 7]
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
            'cod_oasis' => 'Cod Oasis',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCcostoCiudads()
    {
        return $this->hasMany(CcostoCiudad::className(), ['ciudad_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCcostos()
    {
        return $this->hasMany(Ccosto::className(), ['id' => 'ccosto_id'])->viaTable('ccosto_ciudad', ['ciudad_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSucursals()
    {
        return $this->hasMany(Sucursal::className(), ['ciudad_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioCiudads()
    {
        return $this->hasMany(UsuarioCiudad::className(), ['ciudad_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuario::className(), ['usuario' => 'usuario'])->viaTable('usuario_ciudad', ['ciudad_id' => 'id']);
    }
}
