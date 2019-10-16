<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "auditoria_retirados".
 *
 * @property integer $id
 * @property integer $id_tercero
 * @property string $observacion
 */
class AuditoriaRetirados extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auditoria_retirados';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['estado','motivo','observacion'], 'required'],
            [['id_tercero'], 'integer'],
            [['observacion'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_tercero' => 'Id Tercero',
            'observacion' => 'Observacion',
            'estado'=>'Estado:',
            'motivo'=>'Motivo:'
        ];
    }
}
