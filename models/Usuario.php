<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario".
 *
 * @property string $usuario
 * @property string $nombres
 * @property string $apellidos
 * @property string $password
 * @property string $tipo
 * @property string $email
 * @property string $status
 *
 * @property ReporteDiarioEnc[] $reporteDiarioEncs
 * @property UsuarioCcosto[] $usuarioCcostos
 * @property Ccosto[] $ccostos
 * @property UsuarioCiudad[] $usuarioCiudads
 * @property Ciudad[] $ciudads
 * @property UsuarioRol[] $usuarioRols
 * @property Rol[] $rols
 * @property UsuarioSucursal[] $usuarioSucursals
 * @property Sucursal[] $sucursals
 * @property Visita[] $visitas
 */
class Usuario extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /*Propiedades necesaria para interfaz identity*/ 
    public $id;
    public $authKey;
    public $accessToken;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usuario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['usuario', 'nombres', 'apellidos', 'password'], 'required'],
            [['usuario'], 'string', 'max' => 80],
            [['nombres', 'apellidos'], 'string', 'max' => 80],
            [['password'], 'string', 'max' => 60],
            [['tipo', 'status','todos_clientes'], 'string', 'max' => 1],
            [['email'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'usuario' => 'Usuario',
            'nombres' => 'Nombres',
            'apellidos' => 'Apellidos',
            'password' => 'Password',
            'tipo' => 'Tipo',
            'email' => 'Email',
            'status' => 'Estado',
            'todos_clientes' => 'Todos los Clientes',
        ];
    }

     /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['usuario' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
      
        return null;
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
       
        return null;
    }
    
    /**
    * Before Insert change password from plain text.
    *
    */
    public function beforeSave($insert)
    {
     
     //  $this->password = substr(hash('sha512', $this->password), 0,60);
      
      $this->password = $this->password;
 
      return parent::beforeSave($insert);
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        //return $this->password === substr(hash('sha512', $password), 0,60);
         return $this->password === $password;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }
    
    /*Obtener Usuario*/
     public function getId()
    {
        return $this->usuario;
        
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReporteDiarioEncs()
    {
        return $this->hasMany(ReporteDiarioEnc::className(), ['usuario' => 'usuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioCcostos()
    {
        return $this->hasMany(UsuarioCcosto::className(), ['usuario' => 'usuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCcostos()
    {
        return $this->hasMany(Ccosto::className(), ['id' => 'ccosto_id'])->viaTable('usuario_ccosto', ['usuario' => 'usuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioCiudades()
    {
        return $this->hasMany(UsuarioCiudad::className(), ['usuario' => 'usuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCiudades()
    {
        return $this->hasMany(Ciudad::className(), ['id' => 'ciudad_id'])->viaTable('usuario_ciudad', ['usuario' => 'usuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioRoles()
    {
        return $this->hasMany(UsuarioRol::className(), ['usuario' => 'usuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoles()
    {
        return $this->hasMany(Rol::className(), ['id' => 'rol_id'])->viaTable('usuario_rol', ['usuario' => 'usuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioSucursales()
    {
        return $this->hasMany(UsuarioSucursal::className(), ['usuario' => 'usuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSucursales()
    {
        return $this->hasMany(Sucursal::className(), ['id' => 'sucursal_id'])->viaTable('usuario_sucursal', ['usuario' => 'usuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVisitas()
    {
        return $this->hasMany(Visita::className(), ['usuario' => 'usuario']);
    }
}
