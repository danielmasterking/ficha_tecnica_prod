<?php

namespace app\controllers;

use Yii;
use app\models\ReporteDiario;
use app\models\ReporteDiarioSearch;
use app\models\Cliente;
use app\models\Estado;
use app\models\Usuario;
use app\models\Sucursal;
use app\models\ClienteSearch;
use app\models\UsuarioCliente;
use app\models\Novedad;
use app\models\UsuarioClienteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ReporteDiarioController implements the CRUD actions for ReporteDiario model.
 */
class ReporteDiarioController extends Controller
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

    public function actionConsolidar(){

        $primaryConnection = Yii::$app->db;
        $model = new ReporteDiario();
        $usuario = Yii::$app->session['usuario'];
        $consultar = '0';
        $array_post = Yii::$app->request->post();
        $model = new ReporteDiario();
        $novedades = Novedad::find()->where(['tipo' => 'R'])->all();
        $usuarios = Usuario::find()->where(['tipo' => 'E'])->all();
        $usu_obj = Usuario::find()->where(['usuario' => $usuario])->one();

        $primaryCommand = $primaryConnection->createCommand("SELECT  cliente.nit as NIT,
                                                                     cliente.nombre as NOMBRE
                                                                  FROM cliente,usuario_cliente
                                                                  WHERE usuario_cliente.nit = cliente.nit
                                                                  AND   usuario_cliente.usuario = :usuario
                                                                  AND   cliente.estado = 'A'");


      $primaryCommand2 = $primaryConnection->createCommand("SELECT n.nombre AS NOVEDAD ,COUNT(*) AS CANTIDAD 
                                                                   FROM reporte_diario rd, sucursal s, cliente c, novedad n 
                                                               WHERE s.id = rd.sucursal_id 
                                                               AND s.nit = c.nit 
                                                               AND n.id = rd.novedad_id 
                                                               AND c.nit = :nit 
                                                               GROUP BY n.nombre");
        
        $primaryCommand3 = $primaryConnection->createCommand("SELECT COUNT(*) AS TOTAL 
                                                               FROM reporte_diario rd, sucursal s, cliente c
                                                               WHERE s.id = rd.sucursal_id 
                                                               AND s.nit = c.nit 
                                                               AND c.nit = :nit 
                                                               ");

        $primaryCommand4 = $primaryConnection->createCommand("SELECT  usuario_ciudad.ciudad_id as CIU_ID
                                                                FROM usuario_ciudad
                                                                WHERE usuario_ciudad.usuario = :usuario");


         
         
         $clientes_usuario = $primaryCommand->bindValue(':usuario',$usuario)
                                           ->queryAll();

         $ciudades_usuario =  $primaryCommand4->bindValue(':usuario',$usuario)
                                           ->queryAll();


         $roles_usuario = $usu_obj->roles;

         $permisos_arr = array();

         foreach ($roles_usuario as $rol) {
           # code...
          //Obtener permisos rol
          $permisos = $rol->permisos;

          foreach ($permisos as $key) {
             # code...
             $permisos_arr [] = strtolower($key->nombre);
           } 

         }

         

                                                                           
         $total = 0;
         $consolidado = array();
         $total_sucursales = array();
         $detalle_consolidado = array();
         $sql = '';
         $parametros_array = array();

         if(array_key_exists('consultar', $array_post)){

            if(array_key_exists('cliente', $array_post)){

                 if($array_post['cliente'] != ''){

                   $sql .= ' AND c.nit = :nit';             
                 }else{
                     
                     // Se dejó criterio cliente en blanco y se deben consultar con todos los clientes del usuario activo
                     //variable temporal para almacenar nits clientes
                     $tmp_clients_var = '';

                     $tmp_ciudad_var = '';
                     // obtener información de cada cliente
                     foreach ($clientes_usuario as $key => $value) {
                         
                         $tmp_clients_var .= "'".$value['NIT']."',";
                         
                     }

                     $sql_temp = " AND c.nit in (".$tmp_clients_var.")";

                     $sql_temp_arr = explode(",)",$sql_temp);

                     $sql .= $sql_temp_arr[0].")";

                     foreach ($ciudades_usuario as $key => $value) {
                         
                         $tmp_ciudad_var .= "'".$value['CIU_ID']."',";
                         
                     } 
                     
                     $sql_temp_ciu = " AND s.ciudad_id in (".$tmp_ciudad_var.")";

                     $sql_temp_arr_ciu = explode(",)",$sql_temp_ciu);

                     $sql .= $sql_temp_arr_ciu[0].")";                    

                     
                 }
                 


            }

            if(array_key_exists('coordinador', $array_post)){

                 if($array_post['coordinador'] != ''){

                   $sql .= ' AND rde.usuario = :coordinador';             
                 }
                 


            }else{

                 if(!in_array('medicion-coord', $permisos)){

                    $sql .= " AND rde.usuario = '$usuario' ";
                 }



            }

            if(array_key_exists('ReporteDiario', $array_post)){

                    if($array_post['ReporteDiario']['sucursal_id'] != '' && $array_post['ReporteDiario']['sucursal_id'] != '-1'){

                         $sql .= ' AND s.id = :sucursal_id';


                    }

            }

            if(array_key_exists('novedad', $array_post)){

                 if($array_post['novedad'] != ''){
                   $sql .= ' AND n.id = :novedad_id';
                 }
               
               
            }

            if(array_key_exists('fecha_inicial', $array_post) && array_key_exists('fecha_final', $array_post)){

                if($array_post['fecha_inicial'] != '' && $array_post['fecha_final'] != ''){

                  $sql .= ' AND rde.fecha BETWEEN :FECHA_1 AND DATE_ADD(:FECHA_2, INTERVAL 1 DAY)';  
                }
                  
                
                  
            }

            $sucursal_id = '';
            $novedad_id = '';
            $nit = '';

            $main_sql = "SELECT COUNT(*) AS TOTAL 
                         FROM reporte_diario rd, sucursal s, cliente c , novedad n, reporte_diario_enc rde 
                         WHERE s.id = rd.sucursal_id 
                         AND s.nit = c.nit
                         AND rde.id = rd.reporte_id 
                         AND n.id = rd.novedad_id  ".$sql;

            $main_sql_2 = "SELECT n.nombre AS NOVEDAD ,COUNT(*) AS CANTIDAD 
                            FROM reporte_diario rd, sucursal s, cliente c, novedad n, reporte_diario_enc rde  
                           WHERE s.id = rd.sucursal_id 
                           AND s.nit = c.nit 
                           AND rde.id = rd.reporte_id 
                           AND n.id = rd.novedad_id  
                           ".$sql.' GROUP BY n.nombre'; 

            $main_sql_3 = "SELECT DISTINCT (s.nombre) AS SUCURSAL, s.id AS ID_SUCURSAL
                            FROM reporte_diario rd, sucursal s, cliente c, novedad n, reporte_diario_enc rde  
                           WHERE s.id = rd.sucursal_id 
                           AND s.nit = c.nit 
                           AND rde.id = rd.reporte_id 
                           AND n.id = rd.novedad_id  
                           ".$sql." ORDER BY s.nombre";     

           $main_sql_4 = "SELECT n.nombre AS NOVEDAD ,COUNT(*) AS CANTIDAD 
            FROM reporte_diario rd, sucursal s, cliente c, novedad n, reporte_diario_enc rde  
           WHERE s.id = rd.sucursal_id 
           AND s.nit = c.nit 
           AND rde.id = rd.reporte_id 
           AND n.id = rd.novedad_id 
           AND  s.id = :id_sucursal  
           ".$sql.' GROUP BY n.nombre';                            



             $primaryCommand2 = $primaryConnection->createCommand($main_sql_2);
             $primaryCommand3 = $primaryConnection->createCommand($main_sql);
             $primaryCommand4 = $primaryConnection->createCommand($main_sql_3);
             $primaryCommand5 = $primaryConnection->createCommand($main_sql_4);
             $parametros_array = array();


             $nit = array_key_exists('cliente', $array_post) ? $array_post['cliente'] : '';
             $novedad_id = array_key_exists('novedad', $array_post) ? $array_post['novedad'] : '';
             
             if(array_key_exists('ReporteDiario', $array_post)){
                
                if($array_post['ReporteDiario']['sucursal_id'] != '' && $array_post['ReporteDiario']['sucursal_id'] != '-1'){

                     $sucursal_id =   $array_post['ReporteDiario']['sucursal_id'];

                     $parametros_array[':sucursal_id'] = $sucursal_id;   

                }else{

                     $sucursal_id = '';
                }

             }


             if(array_key_exists('novedad', $array_post)){

                if($array_post['novedad'] != ''){

                     $novedad_id =   $array_post['novedad'];
                     $parametros_array[':novedad_id'] = $novedad_id;


                }


             }

             if(array_key_exists('coordinador', $array_post)){

                if($array_post['coordinador'] != ''){

                     $coord =   $array_post['coordinador'];
                     $parametros_array[':coordinador'] = $coord;


                }


             }

             if(array_key_exists('fecha_inicial', $array_post) && array_key_exists('fecha_final', $array_post)){
                   
                    if($array_post['fecha_inicial'] != '' && $array_post['fecha_final'] != ''){

                        $parametros_array[':FECHA_1'] = $array_post['fecha_inicial'];
                        $parametros_array[':FECHA_2'] = $array_post['fecha_final'];

                    }

                   

             }


             if(array_key_exists('cliente', $array_post)){

                if($array_post['cliente'] != ''){

                     $nit =   $array_post['cliente'];
                     $parametros_array[':nit'] = $nit;


                }


             }
            


              $total = $primaryCommand3->bindValues($parametros_array)->queryScalar();

              $consolidado = $primaryCommand2->bindValues($parametros_array)->queryAll();
              
              /*detalle de sucursales*/
              $total_sucursales =  $primaryCommand4->bindValues($parametros_array)->queryAll();

              if(count($total_sucursales) > 0){

                 foreach ($total_sucursales as $key) {
                     $parametros_array[':id_sucursal'] = $key['ID_SUCURSAL'];
                     $detalle_sucursal =  $primaryCommand5->bindValues($parametros_array)->queryAll();

                     if(count($detalle_sucursal) > 0){
                        
                        $array_temp = array();

                        foreach ($detalle_sucursal as $novedades2) {
                           
                           $array_temp[$novedades2['NOVEDAD']] = $novedades2['CANTIDAD'];

                        }

                        $detalle_consolidado [] = $array_temp;

                     }
                 }


              }

           $consultar =  '1';      




         }

                                   
       
        return $this->render('consolidar', [
                'model' => 'a',
                'clientes' => $clientes_usuario,
                'consultar' => $consultar,
                'total' => $total,
                'consolidado' => $consolidado,
                'model' => $model,
                'novedades' => $novedades,
                'sql' => $parametros_array,
                'usuarios' => $usuarios,
                'total_sucursales' => $total_sucursales,
                'detalle_consolidado' => $detalle_consolidado, 
            ]);



    }

    public function actionDetalle($id){


        $estado = Estado::find()->where(['tipo' => 'R','orden' => 3])->one();
        
        $sucursales = Sucursal::find()->where(['nit' => $id])->all();



        return $this->render('detalle',[
              
              'sucursales' => $sucursales,
              'estado' => $estado,
              'nit' => $id,

            ]);
    }

    /**
     * Lists all ReporteDiario models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        
        $array_post = Yii::$app->request->post();
        $estado_publicado = Estado::find()->where(['orden' => 3, 'tipo' => 'R'])->all();
        $estado_no_publicado = Estado::find()->where(['orden' => 1, 'tipo' => 'R'])->all();
        
        if(isset($array_post['publicar'])){
           
           if(isset($array_post['seleccionadas'])){
                  
              $seleccionadas = $array_post['seleccionadas'];
              
              $tamano_seleccionadas = count($seleccionadas);

              for ($i = 0; $i < $tamano_seleccionadas; $i++) { 
                  
                  $row_novedad = $this->findModel($seleccionadas[$i]);
                  $row_novedad->setAttribute('estado_id', $estado_publicado[0]->id);
                  $row_novedad->save();
              }

           }

        }

        if(isset($array_post['no-publicar'])){
           
           if(isset($array_post['seleccionadas'])){
                  
              $seleccionadas = $array_post['seleccionadas'];
              
              $tamano_seleccionadas = count($seleccionadas);

              for ($i = 0; $i < $tamano_seleccionadas; $i++) { 
                  
                  $row_novedad = $this->findModel($seleccionadas[$i]);
                  $row_novedad->setAttribute('estado_id', $estado_no_publicado[0]->id);
                  $row_novedad->save();
              }

           }

        }

        $reportes = ReporteDiario::find()->with(['sucursal'])->where(['reporte_id' => $id])->all();

        return $this->render('index',['reportes' => $reportes]);
    }

    public function actionSucursalesList($q = null, $id = null ){
        
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {

            $primaryConnection = Yii::$app->db;
            $primaryCommand = $primaryConnection->createCommand("SELECT  id, nombre AS text 
                                                                 FROM sucursal
                                                                  WHERE nit LIKE '%".$q."%'
                                                                  ORDER BY nombre ASC");

                $data = $primaryCommand->queryAll();
                $out['results'] = array_values($data);
       }

       elseif ($id > 0) {
        $out['results'] = ['id' => $id, 'text' => Sucursal::find($id)->nombre];
       }

        
        return $out;
    }


    /**
     * Displays a single ReporteDiario model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ReporteDiario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $primaryConnection = Yii::$app->db;
        $model = new ReporteDiario();
        $usuario = Yii::$app->session['usuario'];
        Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/';
        $shortPath = '/uploads/';

        


        $primaryCommand = $primaryConnection->createCommand("SELECT  cliente.nit as NIT,
                                                                     cliente.nombre as NOMBRE
                                                                  FROM cliente,usuario_cliente
                                                                  WHERE usuario_cliente.nit = cliente.nit
                                                                  AND   usuario_cliente.usuario = :usuario
                                                                  AND   cliente.estado = 'A'
                                                                  ORDER BY  cliente.nombre ASC");


         
         $clientes_usuario = $primaryCommand->bindValue(':usuario',$usuario)
                                           ->queryAll();

         $estado =  Estado::find()->where(['tipo' => 'R','orden' => 1])
                                     ->asArray()
                                     ->all();        
         

         date_default_timezone_set ( 'America/Bogota');
         $fecha_registro = date('Y-m-d',time());
         $novedades = Novedad::find()->where(['tipo' => 'R','estado' => 'A'])
                                     ->orderBy(['nombre' => SORT_ASC])
                                     ->asArray()
                                     ->all();   

        if ($model->load(Yii::$app->request->post()) ) {
               
              if($model->sucursal_id != null || $model->sucursal_id != ''){

                 /**************** Validar Imagen **********************/
                  $image = UploadedFile::getInstance($model, 'image2');
                  if($image !== null)
                  {
                      $model->archivo = $image->name;
                      $ext = end((explode(".", $image->name)));
                      $name = date('Ymd').rand(1, 10000).''.$model->archivo;
                      $path = Yii::$app->params['uploadPath'] . $name;
                      $model->archivo = $shortPath. $name;

                  }

                  if($model->save()){

                       if($image !== null)
                      {
                           $image->saveAs($path);

                      }

                  }
                    /*****************************************************/
                    $model = new ReporteDiario();
                    return $this->render('create', [
                        'model' => $model,
                        'clientes' => $clientes_usuario,
                        'reporte_id' => $id,
                        'fecha_registro' => $fecha_registro,
                        'novedades' => $novedades,
                        'status' => '200',
                        'estado' => $estado,
                    ]);           

                  
              }else{
                 
                 $model = new ReporteDiario(); 
                 return $this->render('create', [
                'model' => $model,
                'clientes' => $clientes_usuario,
                'reporte_id' => $id,
                'fecha_registro' => $fecha_registro,
                'novedades' => $novedades,
                'estado' => $estado,
                ]);
                  
              }
              


        } else {
            return $this->render('create', [
                'model' => $model,
                'clientes' => $clientes_usuario,
                'reporte_id' => $id,
                'fecha_registro' => $fecha_registro,
                'novedades' => $novedades,
                'estado' => $estado,
            ]);
        }
    }

    /**
     * Updates an existing ReporteDiario model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ReporteDiario model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ReporteDiario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ReporteDiario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ReporteDiario::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
