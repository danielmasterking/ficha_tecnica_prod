<?php

namespace app\controllers;

use Yii;
use app\models\Usuario;
use app\models\UsuarioSearch;
use app\models\Ciudad;
use app\models\Cliente;
use app\models\UsuarioCcosto;
use app\models\UsuarioCiudad;
use app\models\UsuarioCliente;
use app\models\UsuarioMeta;
use app\models\UsuarioSucursal;
use app\models\UsuarioRol;
use app\models\CiudadSearch;
use app\models\Ccosto;
use app\models\PermisoRol;
use app\models\Sucursal;
use app\models\CcostoSearch;
use app\models\Rol;
use app\models\Permiso;
use app\models\RolSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UsuarioController implements the CRUD actions for Usuario model.
 */
class UsuarioController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Usuario models.
     * @return mixed
     */
    public function actionIndex()
    {
        $usuarios = Usuario::find()->asArray()->all();
        

        return $this->render('index', [
            'usuarios' => $usuarios,
        ]);
    }

     public function actionSucursales($id)
    {
        $array_post = Yii::$app->request->post(); // almacenar variables POST

        $model = new UsuarioSucursal();

        $primaryConnection = Yii::$app->db;
        $primaryCommand = $primaryConnection->createCommand("SELECT nit
                                                             FROM usuario_sucursal
                                                             WHERE usuario = :usuario
                                                             ");

        $sucursales_asignadas = UsuarioSucursal::find()->where(['usuario' => $id])->all();

        $usuario = $id;

        $asignaciones = array_key_exists('clientes', $array_post) ? $array_post['clientes'] : array();
        
        $tamano_asignaciones = count($asignaciones);
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {


            $usuarios = Usuario::find()->asArray()->all();
        

            return $this->render('index', [
                                 'usuarios' => $usuarios,
            ]);



        }


        $clientes = Cliente::find()->asArray()
                                   ->all();


        

        return $this->render('sucursales', [
            'usuario' => $usuario,
            'clientes' => $clientes,
            'sucursales_asignadas' => $sucursales_asignadas,
            'model' => $model,
        ]);
    }

    public function actionTodas($id)
    {
          
        $array_post = Yii::$app->request->post(); // almacenar variables POST

        $model = new UsuarioSucursal();

        $primaryConnection = Yii::$app->db;
        $primaryCommand = $primaryConnection->createCommand("SELECT nit
                                                             FROM usuario_sucursal
                                                             WHERE usuario = :usuario
                                                             ");

        $sucursales_asignadas = UsuarioSucursal::find()->where(['usuario' => $id])->all();

        $usuario = $id;

        $asignaciones = array_key_exists('clientes', $array_post) ? $array_post['clientes'] : array();
        $sucursales = array_key_exists('sucursales', $array_post) ? $array_post['sucursales'] : array();
        $cliente = array_key_exists('cliente', $array_post) ? $array_post['sucursales'] : '0'; 
        $tamano_sucursales = count($sucursales);
        $tamano_asignaciones = count($asignaciones);
     
        if($tamano_sucursales > 0){
             
             

             for($i = 0; $i < $tamano_sucursales; $i++){

                $model = new UsuarioSucursal();
                $model->setAttribute("usuario", $usuario);
                $model->setAttribute("sucursal_id",$sucursales[$i]);
                $model->save();              

             }



            $usuarios = Usuario::find()->asArray()->all();
        

            return $this->render('index', [
                                 'usuarios' => $usuarios,
            ]);




        }else{

          if(isset($array_post['todas'])){
               
               $sucursales_totales = Sucursal::find()->where(['nit' => $cliente])->all();

               foreach ($sucursales_totales as $key) {

                $model = new UsuarioSucursal();
                $model->setAttribute("usuario", $usuario);
                $model->setAttribute("sucursal_id",$key->id);
                $model->save();              
                /*Validar si ya tiene las sucursales no volverlas a colocar*/
                   
               }
          }

          


        }

        $clientes = Cliente::find()->asArray()
                                   ->all();

    
        return $this->render('sucursalesvarios', [
            'usuario' => $usuario,
            'clientes' => $clientes,
            'sucursales_asignadas' => $sucursales_asignadas,
            'model' => $model,
        ]);


    }
    
     public function actionSucursalesciudades($id)
    {
        $array_post = Yii::$app->request->post(); // almacenar variables POST

        $model = new UsuarioSucursal();

        $primaryConnection = Yii::$app->db;
        $primaryCommand = $primaryConnection->createCommand("SELECT nit
                                                             FROM usuario_sucursal
                                                             WHERE usuario = :usuario
                                                             ");

        $sucursales_asignadas = UsuarioSucursal::find()->where(['usuario' => $id])->all();

        $usuario = $id;

        $asignaciones = array_key_exists('clientes', $array_post) ? $array_post['clientes'] : array();
        $cliente = array_key_exists('cliente', $array_post) ? $array_post['cliente'] : '0'; 
        $ciudad = array_key_exists('ciudad', $array_post) ? $array_post['ciudad'] : '0';
        $sucursales = Sucursal::find()->where(['nit' => $cliente,'ciudad_id' => $ciudad])->all();
        $tamano_sucursales = count($sucursales);
        $tamano_asignaciones = count($asignaciones);
       // \yii\helpers\VarDumper::dump($array_post);
     
        if($tamano_sucursales > 0 && $sucursales[0] != ''){
             
             

             foreach($sucursales as $key){

                $model = new UsuarioSucursal();
                $model->setAttribute("usuario", $usuario);
                $model->setAttribute("sucursal_id",$key->id);
                $model->save();

                

             }



            $usuarios = Usuario::find()->asArray()->all();
        

            return $this->render('index', [
                                 'usuarios' => $usuarios,
                                 'tem' => $sucursales,
            ]);




        }

        

        $clientes = Cliente::find()->asArray()
                                   ->all();
        $ciudades = Ciudad::find()->all();
    
        return $this->render('sucursalesciudades', [
            'usuario' => $usuario,
            'clientes' => $clientes,
            'sucursales_asignadas' => $sucursales_asignadas,
            'model' => $model,
            'tem' => $sucursales,
            'ciudades' => $ciudades,
        ]);
    }

     public function actionSucursalesvarios($id)
    {
        $array_post = Yii::$app->request->post(); // almacenar variables POST

        $model = new UsuarioSucursal();

        $primaryConnection = Yii::$app->db;
        $primaryCommand = $primaryConnection->createCommand("SELECT nit
                                                             FROM usuario_sucursal
                                                             WHERE usuario = :usuario
                                                             ");

        $sucursales_asignadas = UsuarioSucursal::find()->where(['usuario' => $id])->all();

        $usuario = $id;

        $asignaciones = array_key_exists('clientes', $array_post) ? $array_post['clientes'] : array();
        $sucursales = array_key_exists('sucursales', $array_post) ? $array_post['sucursales'] : array();
        $cliente = array_key_exists('cliente', $array_post) ? $array_post['cliente'] : '0'; 
        $tamano_sucursales = count($sucursales);
        $tamano_asignaciones = count($asignaciones);
       // \yii\helpers\VarDumper::dump($array_post);
     
        if($tamano_sucursales > 0 && $sucursales[0] != ''){
             
             

             for($i = 0; $i < $tamano_sucursales; $i++){

                $model = new UsuarioSucursal();
                $model->setAttribute("usuario", $usuario);
                $model->setAttribute("sucursal_id",$sucursales[$i]);
                $model->save();

                

             }



            $usuarios = Usuario::find()->asArray()->all();
        

            return $this->render('index', [
                                 'usuarios' => $usuarios,
                                 'tem' => $sucursales,
            ]);




        }else{

          if(isset($array_post['todas'])){
               
               $sucursales_totales = Sucursal::find()->where(['nit' => $cliente])->all();

               foreach ($sucursales_totales as $key) {

                $model = new UsuarioSucursal();
                $model->setAttribute("usuario", $usuario);
                $model->setAttribute("sucursal_id",$key->id);
                $model->save();              
                /*Validar si ya tiene las sucursales no volverlas a colocar*/
                   
               }

            $usuarios = Usuario::find()->asArray()->all();
        

            return $this->render('index', [
                                 'usuarios' => $usuarios,
                                 'tem' => $sucursales,
            ]);
          }

          


        }

        $clientes = Cliente::find()->asArray()
                                   ->all();

    
        return $this->render('sucursalesvarios', [
            'usuario' => $usuario,
            'clientes' => $clientes,
            'sucursales_asignadas' => $sucursales_asignadas,
            'model' => $model,
            'tem' => $sucursales,
        ]);
    }


   

    public function actionClientes($id)
    {
        $array_post = Yii::$app->request->post(); // almacenar variables POST

        $primaryConnection = Yii::$app->db;
        $primaryCommand = $primaryConnection->createCommand("SELECT nit
                                                             FROM usuario_cliente
                                                             WHERE usuario = :usuario
                                                             ");

        $clientes_asignados = UsuarioCliente::find()->where(['usuario' => $id])->all();

        $usuario = $id;

        $asignaciones = array_key_exists('clientes', $array_post) ? $array_post['clientes'] : array();
        
        $tamano_asignaciones = count($asignaciones);
        
        $index = 0;
        while($index < $tamano_asignaciones){

            $model = new UsuarioCliente();
            $model->SetAttribute('nit',$asignaciones[$index]);
            $model->SetAttribute('usuario',$usuario);
            $model->save();
            $index++;


        }

        if($tamano_asignaciones > 0){


            $usuarios = Usuario::find()->asArray()->all();
        

            return $this->render('index', [
                                 'usuarios' => $usuarios,
            ]);


        }


        $clientes = Cliente::find()->asArray()
                                   ->all();


        

        return $this->render('clientes', [
            'usuario' => $usuario,
            'clientes' => $clientes,
            'clientes_asignados' => $clientes_asignados,
        ]);
    }

     public function actionMeta($id)
    {
        $array_post = Yii::$app->request->post(); // almacenar variables POST

        $primaryConnection = Yii::$app->db;
        $primaryCommand = $primaryConnection->createCommand("SELECT cantidad
                                                             FROM usuario_meta
                                                             WHERE usuario_usuario = :usuario
                                                             ");

        $meta_usuario = UsuarioMeta::find()->where(['usuario_usuario' => $id])->one();

        $usuario = $id;

        $cantidad = array_key_exists('cantidad', $array_post) ? $array_post['cantidad'] : 0;
        
                
        
        if($meta_usuario == null && $cantidad != 0){

            $model = new UsuarioMeta();
            $model->SetAttribute('cantidad',$cantidad);
            $model->SetAttribute('usuario_usuario',$usuario);
            $model->save();
        

        }else{
            
            if($cantidad != 0){
               
               $meta_usuario->SetAttribute('cantidad',$cantidad);
               $meta_usuario->save();
            }

            
        }

        if($cantidad > 0){


            $usuarios = Usuario::find()->asArray()->all();
        

            return $this->render('index', [
                                 'usuarios' => $usuarios,
            ]);


        }

        

        return $this->render('meta', [
            'usuario' => $usuario,
            'meta_usuario' => $meta_usuario,
            
        ]);
    }

    public function actionTodos($id)
    {
        $array_post = Yii::$app->request->post(); // almacenar variables POST
        
        $clientes_totales = Cliente::find()->all();
        
        $primaryConnection = Yii::$app->db;
        $primaryCommand = $primaryConnection->createCommand("SELECT nit
                                                             FROM usuario_cliente
                                                             WHERE usuario = :usuario
                                                             ");

        
        //Marcar atributo todos los clientes
        $user_model = Usuario::find()->where(['usuario' => $id])->one();

        if($user_model != null){

          $user_model->setAttribute('todos_clientes','S');
          $user_model->save();

        }
        
        foreach($clientes_totales as $key){
        
             $sw = 0;
             $clientes_asignados = UsuarioCliente::find()->where(['usuario' => $id])->all();

             foreach ($clientes_asignados as $key2 ) {
                 
                 if($key->nit == $key2->nit){

                    $sw = 1;
                    break;
                 }
             }

             if($sw == 0){


                    $model = new UsuarioCliente();
                    $model->SetAttribute('nit',$key->nit);
                    $model->SetAttribute('usuario',$id);
                    $model->save();
                    

             }

        }

        $usuarios = Usuario::find()->asArray()->all();
        $this->redirect('index');
    }

    public function actionDeleteCliente($id,$nit)
    {
        $primaryConnection = Yii::$app->db;
        $primaryCommand = $primaryConnection->createCommand("DELETE 
                                                             FROM  usuario_cliente
                                                             WHERE usuario = :usuario
                                                             AND   nit = :nit
                                                             ");

        $borrado = $primaryCommand->bindValue(':usuario',$id)
                                             ->bindValue(':nit',$nit)
                                             ->execute();

        return $this->redirect(Yii::$app->request->baseUrl.'/usuario/clientes?id='.$id);


    }


    public function actionDeleteSucursal($usu,$id_suc)
    {
        $primaryConnection = Yii::$app->db;
        $primaryCommand = $primaryConnection->createCommand("DELETE 
                                                             FROM  usuario_sucursal
                                                             WHERE usuario = :usuario
                                                             AND   sucursal_id = :sucursal
                                                             ");

        $borrado = $primaryCommand->bindValue(':usuario',$usu)
                                             ->bindValue(':sucursal',$id_suc)
                                             ->execute();

        return $this->redirect(Yii::$app->request->baseUrl.'/usuario/sucursalesvarios?id='.$usu);


    }


    /**
     * Displays a single Usuario model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Usuario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $array_post = Yii::$app->request->post(); // almacenar variables POST
        $model = new Usuario();
        $ciudades = Ciudad::find()->asArray()->all();
        $centros = Ccosto::find()->asArray()->all();
        $roles = Rol::find()->asArray()->all();

        ///////////////////////////////////////////////////////////////////
        $primaryConnection = Yii::$app->db;
        $primaryCommand = $primaryConnection->createCommand("DELETE 
                                                             FROM usuario_ciudad
                                                             WHERE usuario = :usuario
                                                             ");

        $secondCommand = $primaryConnection->createCommand("DELETE 
                                                             FROM usuario_ccosto
                                                             WHERE usuario = :usuario
                                                             ");

         $thirdCommand = $primaryConnection->createCommand("DELETE 
                                                            FROM usuario_rol
                                                            WHERE usuario = :usuario
                                                            ");

         $fourthCommand = $primaryConnection->createCommand("SELECT rol_id 
                                                            FROM usuario_rol
                                                            WHERE usuario = :usuario
                                                            ");

         $fifthCommand = $primaryConnection->createCommand("SELECT ccosto_id 
                                                            FROM usuario_ccosto
                                                            WHERE usuario = :usuario
                                                            ");

         $sixthCommand = $primaryConnection->createCommand("SELECT ciudad_id 
                                                            FROM usuario_ciudad
                                                            WHERE usuario = :usuario
                                                            ");




        //////////////////////////////////////////////////////////////////
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $ciudades_array = array_key_exists('ciudades_array', $array_post) ? $array_post['ciudades_array'] : array();
            $ccostos_array = array_key_exists('ccostos_array', $array_post) ? $array_post['ccostos_array'] : array();
            $roles_array = array_key_exists('roles_array', $array_post) ? $array_post['roles_array'] : array();
            $usuario = $model->getAttribute('usuario');
           //eliminar ubicaciones
            $primaryCommand->bindValue(':usuario',$usuario)->execute();
            $secondCommand->bindValue(':usuario',$usuario)->execute();
            $thirdCommand->bindValue(':usuario',$usuario)->execute();
            
            //cantidad de Seleccionados
            $tamano_ciudades = count($ciudades_array);
            $tamano_ccostos =  count($ccostos_array);
            $tamano_roles =    count($roles_array);

            $index = 0;

            while($index < $tamano_ciudades){

               /*Modelo principal guardado*/
               $usuario_ciudad_model = new UsuarioCiudad();
               /*establecer valores de Atributos del objeto prorroga*/
               $usuario_ciudad_model->SetAttribute('usuario',$usuario);
               $usuario_ciudad_model->SetAttribute('ciudad_id',$ciudades_array[$index]);
               $usuario_ciudad_model->save();
      
                

                $index++;

            }

            $index = 0;

            while($index < $tamano_ccostos){

                /*Modelo principal guardado*/
               $usuario_ccosto_model = new UsuarioCcosto();
               /*establecer valores de Atributos del objeto prorroga*/
               $usuario_ccosto_model->SetAttribute('usuario',$usuario);
               $usuario_ccosto_model->SetAttribute('ccosto_id',$ccosto_array[$index]);
               $usuario_ccosto_model->save();


    
                $index++;

            }

            //Obtener centros de costo de usuario
            $usu_cc = UsuarioCcosto::find()->where(['usuario' => $usuario])->all();

            foreach ($usu_cc as $key ) {
                 
                 $ciudades_cc = $key->ciudades;

                 foreach ($ciudades_cc as $key2) {
                     
                     $sw = UsuarioCiudad::find()->where(['usuario' => $usuario, 'ciudad_id' => $key2->id])->all();
                     if(count($sw) == 0){

                        /*Modelo principal guardado*/
                       $usuario_ciudad_model = new UsuarioCiudad();
                       /*establecer valores de Atributos del objeto prorroga*/
                       $usuario_ciudad_model->SetAttribute('usuario',$usuario);
                       $usuario_ciudad_model->SetAttribute('ciudad_id',$key2->id);
                       $usuario_ciudad_model->save();

                     }
                 }
                 
             } 

            $index = 0;
            while($index < $tamano_roles){

                /*Modelo principal guardado*/
               $usuario_roles_model = new UsuarioRol();
               /*establecer valores de Atributos del objeto prorroga*/
               $usuario_roles_model->SetAttribute('usuario',$usuario);
               $usuario_roles_model->SetAttribute('rol_id',$roles_array[$index]);
               $usuario_roles_model->save();
    
               $index++;

            }

            return $this->redirect('index');

        } else {

            
            return $this->render('create', [
                'model' => $model,
                'ciudades' => $ciudades,
                'centros' => $centros,
                'roles' => $roles,
                
            ]);
        }
    }



    /**
     * Updates an existing Usuario model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $array_post = Yii::$app->request->post(); // almacenar variables POST
        $model = $this->findModel($id);
        $ciudades = Ciudad::find()->asArray()->all();
        $centros = Ccosto::find()->asArray()->all();
        $roles = Rol::find()->asArray()->all();
        ///////////////////////////////////////////////////////////////////
        $primaryConnection = Yii::$app->db;
        $primaryCommand = $primaryConnection->createCommand("DELETE 
                                                             FROM usuario_ciudad
                                                             WHERE usuario = :usuario
                                                             ");

        $secondCommand = $primaryConnection->createCommand("DELETE 
                                                             FROM usuario_ccosto
                                                             WHERE usuario = :usuario
                                                             ");

         $thirdCommand = $primaryConnection->createCommand("DELETE 
                                                            FROM usuario_rol
                                                            WHERE usuario = :usuario
                                                            ");

         $fourthCommand = $primaryConnection->createCommand("SELECT rol_id 
                                                            FROM usuario_rol
                                                            WHERE usuario = :usuario
                                                            ");

         $fifthCommand = $primaryConnection->createCommand("SELECT ccosto_id 
                                                            FROM usuario_ccosto
                                                            WHERE usuario = :usuario
                                                            ");

         $sixthCommand = $primaryConnection->createCommand("SELECT ciudad_id 
                                                            FROM usuario_ciudad
                                                            WHERE usuario = :usuario
                                                            ");


         $usuario = $id;

        //////////////////////////////////////////////////////////////////

           if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $ciudades_array = array_key_exists('ciudades_array', $array_post) ? $array_post['ciudades_array'] : array();
            $ccostos_array = array_key_exists('ccostos_array', $array_post) ? $array_post['ccostos_array'] : array();
            $roles_array = array_key_exists('roles_array', $array_post) ? $array_post['roles_array'] : array();
            $usuario = $model->getAttribute('usuario');
           //eliminar ubicaciones
            $primaryCommand->bindValue(':usuario',$usuario)->execute();
            $secondCommand->bindValue(':usuario',$usuario)->execute();
            $thirdCommand->bindValue(':usuario',$usuario)->execute();
            
            //cantidad de Seleccionados
            $tamano_ciudades = count($ciudades_array);
            $tamano_ccostos =  count($ccostos_array);
            $tamano_roles =    count($roles_array);

            $index = 0;

            while($index < $tamano_ciudades){

               /*Modelo principal guardado*/
               $usuario_ciudad_model = new UsuarioCiudad();
               /*establecer valores de Atributos del objeto prorroga*/
               $usuario_ciudad_model->SetAttribute('usuario',$usuario);
               $usuario_ciudad_model->SetAttribute('ciudad_id',$ciudades_array[$index]);
               $usuario_ciudad_model->save();
      
                

                $index++;

            }

            $index = 0;

            while($index < $tamano_ccostos){

                /*Modelo principal guardado*/
               $usuario_ccosto_model = new UsuarioCcosto();
               /*establecer valores de Atributos del objeto prorroga*/
               $usuario_ccosto_model->SetAttribute('usuario',$usuario);
               $usuario_ccosto_model->SetAttribute('ccosto_id',$ccosto_array[$index]);
               $usuario_ccosto_model->save();
    
                $index++;

            }

            $index = 0;
            while($index < $tamano_roles){

                /*Modelo principal guardado*/
               $usuario_roles_model = new UsuarioRol();
               /*establecer valores de Atributos del objeto prorroga*/
               $usuario_roles_model->SetAttribute('usuario',$usuario);
               $usuario_roles_model->SetAttribute('rol_id',$roles_array[$index]);
               $usuario_roles_model->save();
    
               $index++;

            }

                        //Obtener centros de costo de usuario
            $usu_cc = UsuarioCcosto::find()->where(['usuario' => $usuario])->all();

            foreach ($usu_cc as $key ) {
                 
                 $ciudades_cc = $key->ciudades;

                 foreach ($ciudades_cc as $key2) {
                     
                     $sw = UsuarioCiudad::find()->where(['usuario' => $usuario, 'ciudad_id' => $key2->id])->all();
                     if(count($sw) == 0){

                        /*Modelo principal guardado*/
                       $usuario_ciudad_model = new UsuarioCiudad();
                       /*establecer valores de Atributos del objeto prorroga*/
                       $usuario_ciudad_model->SetAttribute('usuario',$usuario);
                       $usuario_ciudad_model->SetAttribute('ciudad_id',$key2->id);
                       $usuario_ciudad_model->save();

                     }
                 }
                 
             } 

            return $this->redirect('index');

        } else {

            $centros_actuales = $fifthCommand->bindValue(':usuario',$usuario)->queryAll();
            $roles_actuales =   $fourthCommand->bindValue(':usuario',$usuario)->queryAll();
            $ciudades_actuales = $sixthCommand->bindValue(':usuario',$usuario)->queryAll();
            
            return $this->render('update', [
                'model' => $model,
                'ciudades' => $ciudades,
                'centros' => $centros,
                'roles' => $roles,
                'centros_actuales' => $centros_actuales,
                'roles_actuales' => $roles_actuales,
                'ciudades_actuales' => $ciudades_actuales,
            ]);
        }
    }

    /**
     * Deletes an existing Usuario model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Usuario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Usuario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Usuario::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
