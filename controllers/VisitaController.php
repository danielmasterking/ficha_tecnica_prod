<?php

namespace app\controllers;

use Yii;
use app\models\Visita;
use app\models\Vtecnica;
use app\models\ReporteDiarioEnc;
use app\models\ReporteDiario;
use app\models\Cliente;
use app\models\SeguimientoVisita;
use app\models\Sucursal;
use app\models\Novedad;
use app\models\Estado;
use app\models\Usuario;
use app\models\ObservacionVtecnica;
use app\models\UsuarioCliente;
use app\models\VisitaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * VisitaController implements the CRUD actions for Visita model.
 */
class VisitaController extends Controller
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
     * Lists all Visita models.
     * @return mixed
     */
    public function actionIndex()
    {
        $usuario = Yii::$app->session['usuario'];

        /*obtener roles usuario*/
        $usuario_AR = Usuario::find()->where(['usuario' => $usuario])->all();

        $roles_usuario = $usuario_AR[0]->roles;
        
        $sw = 0;

        foreach ($roles_usuario as $key) {
            
            if(strpos($key->nombre, 'operaciones') !== false){
                  
                  $sw = 1;
                  break;

            }

        }



        if($sw == 0){
          
          $visitas = Visita::find()->where(['usuario' => $usuario])->all();;

        }else{

          $visitas = Visita::find()->all();;

        }


        return $this->render('index', [
            
            'visitas' => $visitas,
        ]);
    }

      public function actionVisitas()
    {
        $usuario = Yii::$app->session['usuario'];

        /*obtener roles usuario*/
        $usuario_AR = Usuario::find()->where(['usuario' => $usuario])->all();

        $roles_usuario = $usuario_AR[0]->roles;
        
        $sw = 0;

        foreach ($roles_usuario as $key) {
            
            if(strpos($key->nombre, 'operaciones') !== false){
                  
                  $sw = 1;
                  break;

            }

        }



        if($sw == 0){
          
          $visitas = Visita::find()->where(['autor' => $usuario])->all();;

        }else{

          $visitas = Visita::find()->all();

        }


        return $this->render('visitas', [
            
            'visitas' => $visitas,
        ]);
    }

    /**
     * Displays a single Visita model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


     public function actionDetalle($id)
    {
        
        $estado_ar = Estado::find()->where(['tipo' => 'V','orden' => 4])->all();
        $estado = $estado_ar[0];
        $sucursales = Sucursal::find()->where(['nit' => $id])->all();



        return $this->render('detalle',[
              
              'sucursales' => $sucursales,
              'estado' => $estado,
              'nit' => $id,

            ]);
    }

    /**
     * Creates a new Visita model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Visita();
        $model2 = new Vtecnica();
        $secondConnection =  Yii::$app->second_db; // Oasis --> SQL SERVER

        $command = $secondConnection->createCommand("SELECT bter_tercero.terc_nit AS NIT,
                                                            bter_tercero.terc_nombre AS NOMBRE,
                                                            bubi_ubicacion.ubic_nombre AS UBICACION 
                                                        FROM  bubi_ubicacion, bter_tercero
                                                        WHERE bubi_ubicacion.ubin_codigo = bter_tercero.tern_ubicacion
                                                        AND   bter_tercero.terc_empleado = 'S'
                                                        AND   bter_tercero.terc_estado_empleado = 'A'
                                                        ORDER BY bter_tercero.terc_nombre");

        $empleados = $command->queryAll();
        $usuario = Yii::$app->session['usuario'];
        $usuario_model = Usuario::find()->where(['usuario' => $usuario])->one();
        $primaryConnection = Yii::$app->db;
        $primaryCommand = $primaryConnection->createCommand("SELECT nit
                                                             FROM usuario_cliente
                                                             WHERE usuario = :usuario
                                                             
                                                             ");

        $clientes_asignados = UsuarioCliente::find()->where(['usuario' => $usuario])->all();

        $secondCommand = $primaryConnection->createCommand("SELECT id
                                                             FROM reporte_diario_enc
                                                             WHERE fecha = :fecha
                                                             AND   usuario = :usuario
                                                             
                                                             ");

        $thirdCommand = $primaryConnection->createCommand("SELECT id
                                                             FROM novedad
                                                             WHERE nombre like '%técnica%'
                                                             AND   tipo = 'R'


                                                             
                                                             ");
        
        

        $clientes = array();

        date_default_timezone_set ( 'America/Bogota');
        $fecha_registro = date('Y-m-d',time());
        $novedades = Novedad::find()->where(['tipo' => 'V','estado' => 'A'])
                                    ->orderBy(['nombre' => SORT_ASC])
                                     ->asArray()
                                     ->all();

        $estado =  Estado::find()->where(['tipo' => 'V','orden' => 4])
                                     ->asArray()
                                     ->all();     
        $estado_reporte =  Estado::find()->where(['tipo' => 'R','orden' => 1])
                                     ->one();                                  

        $usuarios =  Usuario::find()->where(['tipo' => 'E','status' => 'A'])
                                   ->all();                                                               

        foreach ($clientes_asignados as $key ) {
            
            $clientes [] = $key->cliente;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {



              $model->setAttribute('autor',$usuario);
              $model->save();

             
             /*Sumar un día a fecha de visita técnica*/
              $fecha_real_visita = strtotime('+1 day' , strtotime ( $model->fecha ));
              $fecha_real_visita = date('Y-m-d',$fecha_real_visita);
              $model->setAttribute('fecha',$fecha_real_visita);
              $model->save();
              
            /*Guardar a reporte diario del día*/
               $reporte_diario_enc = $secondCommand->bindValues([':fecha' => $model->fecha, ':usuario' => $usuario])->queryAll();
               $id_reporte = array_key_exists(0, $reporte_diario_enc) ? $reporte_diario_enc[0]['id'] : '';
               $novedad_reporte = $thirdCommand->queryAll();
               $id_novedad_reporte = array_key_exists(0, $novedad_reporte) ? $novedad_reporte[0]['id'] : '';

              if($id_reporte != ''){

                   $model3 = new ReporteDiario();
                   $model3->setAttribute('sucursal_id',$model->sucursal_id);
                   $model3->setAttribute('reporte_id',$id_reporte);
                   $model3->setAttribute('novedad_id',$id_novedad_reporte);
                   $model3->setAttribute('estado_id',$estado_reporte->id);
                   $model3->setAttribute('observacion','Agregada automáticamente');
                   $model3->setAttribute('fecha_registro',$fecha_registro);
                   $model3->setAttribute('hora','12:00 AM');
                   $model3->save(); 
              }
               


            // validar si existen campos para model 2
            if($model2->load(Yii::$app->request->post())){
               
               
               $model2->setAttribute('visita_id',$model->id);
               $model2->save();

              
            }
                         
             $this->redirect(['index','status' => '200']);

        } else {

            return $this->render('create', [
                'model' => $model,
                'clientes' => $clientes,
                'novedades' => $novedades,
                'estado' => $estado,
                'usuarios' => $usuarios,
                'model2' => $model2,
                'usuario_model' => $usuario_model,
                'empleados' => $empleados,
            ]);
        }
    }




    /**
     * Updates an existing Visita model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id,$flag)
    {
        
        
        $primaryConnection = Yii::$app->db;
        $primaryCommand2 = $primaryConnection->createCommand("SELECT u.email AS EMAIL
                                                             FROM usuario u , rol r, usuario_rol ur
                                                             WHERE u.usuario = ur.usuario
                                                             AND   r.id = ur.rol_id
                                                             AND   r.nombre LIKE '%jefe%operaciones%'
                                                             
                                                             ");
        $secondConnection =  Yii::$app->second_db; // Oasis --> SQL SERVER

        $command = $secondConnection->createCommand("SELECT bter_tercero.terc_nit AS NIT,
                                                            bter_tercero.terc_nombre AS NOMBRE,
                                                            bubi_ubicacion.ubic_nombre AS UBICACION 
                                                        FROM  bubi_ubicacion, bter_tercero
                                                        WHERE bubi_ubicacion.ubin_codigo = bter_tercero.tern_ubicacion
                                                        AND   bter_tercero.terc_empleado = 'S'
                                                        AND   bter_tercero.terc_estado_empleado = 'A'
                                                        ORDER BY bter_tercero.terc_nombre");

        $empleados = $command->queryAll();                                                    

         $jefe_operaciones = $primaryCommand2->queryAll();


        $array_post = Yii::$app->request->post();

        $v_tecnica_model = Vtecnica::find()->where(['visita_id' => $id])->one();
        $observaciones = array();
        
        
        if($v_tecnica_model != null){
           
           $observaciones = ObservacionVtecnica::find()->where(['vtecnica_id' => $v_tecnica_model->id])->all();
               
        }

       
        
        $model = $this->findModel($id);
        $usuario_inicial = $model->usuario;

        $ar_vtecnica = Vtecnica::find()->where(['visita_id' => $id])->one();
        $model2 = $ar_vtecnica;
        $usuario = Yii::$app->session['usuario'];
        
        $primaryCommand = $primaryConnection->createCommand("SELECT nit
                                                             FROM usuario_cliente
                                                             WHERE usuario = :usuario
                                                             ");
        $clientes_asignados = UsuarioCliente::find()->where(['usuario' => $usuario])->all();

        $clientes = array();

        date_default_timezone_set ( 'America/Bogota');
        $fecha_registro = date('Y-m-d',time());
        $novedades = Novedad::find()->where(['tipo' => 'V','estado' => 'A'])
                                     ->asArray()
                                     ->all();

        $estado =  Estado::find()->where(['tipo' => 'V','orden' => 4])
                                     ->asArray()
                                     ->all();  
     

        $usuarios =  Usuario::find()->where(['tipo' => 'E','status' => 'A'])
                                   ->all();                                                               

        foreach ($clientes_asignados as $key ) {
            
            $clientes [] = $key->cliente;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            
            // validar si existen campos para model 2
            if( $model2 != null && $model2->load(Yii::$app->request->post())){
               
               
             
               $model2->save();

              
            }
            
            if($model->usuario != $usuario_inicial){
                
                $usuario_ar = Usuario::find()->where(['usuario' => $model->usuario])->all();                
                 Yii::$app->mailer->compose()
                ->setFrom('horus@cvsc.com.co')
                ->setTo($usuario_ar[0]->email)
                ->setSubject('Visita '.$model->id.' Asignada')
                ->setTextBody('Plain text content')
                ->setHtmlBody('<h2>Estimado '.$model->usuario.',</h2>
                               <p>'.$usuario_inicial.' le ha asignado la visita '.$model->id.' </p>
                               <p>Por favor revise su bandeja de visitas en Ficha Técnica</p>')
                ->send();

            }

        if(array_key_exists('cerrar', $array_post)){


            $estado =  Estado::find()->where(['tipo' => 'V','orden' => 3])
                                     ->asArray()
                                     ->all(); 

             $model->setAttribute('estado_id', $estado[0]['id']);  
             $model->save();                     


                  Yii::$app->mailer->compose()
                ->setFrom('horus@cvsc.com.co')
                ->setTo($jefe_operaciones[0]['EMAIL'])
                ->setSubject('Visita '.$model->id.' Cerrada')
                ->setTextBody('Plain text content')
                ->setHtmlBody('<h2>Estimado Jefe de Operaciones,</h2>
                               <p>'.$model->usuario.' ha cerrado la visita '.$model->id.' </p>')
                ->send();

        }


        if(array_key_exists('publicar', $array_post)){


            $estado =  Estado::find()->where(['tipo' => 'V','orden' => 4])
                                     ->asArray()
                                     ->all(); 

             $model->setAttribute('estado_id', $estado[0]['id']);  
             $model->save();                     


               /*   Yii::$app->mailer->compose()
                ->setFrom('horus@cvsc.com.co')
                ->setTo($jefe_operaciones[0]['EMAIL'])
                ->setSubject('Visita '.$model->id.' Cerrada')
                ->setTextBody('Plain text content')
                ->setHtmlBody('<h2>Estimado Jefe de Operaciones,</h2>
                               <p>'.$model->usuario.' ha cerrado la visita '.$model->id.' </p>')
                ->send();*/

        }



            return $this->redirect('index');
        } else {
            return $this->render('update', [
                  'model' => $model,
                  'clientes' => $clientes,
                  'novedades' => $novedades,
                  'estado' => $estado,
                  'usuarios' => $usuarios,
                  'model2' => $model2,
                  'observaciones' => $observaciones,
                  'empleados' => $empleados,
                  'flag' => $flag,

            ]);
        }
    }

    /**
     * Deletes an existing Visita model.
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
     * Finds the Visita model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Visita the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Visita::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
