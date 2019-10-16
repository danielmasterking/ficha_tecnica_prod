<?php

namespace app\controllers;

use Yii;
use app\models\Prorroga;
use app\models\ProrrogaSearch;
use app\models\UsuarioCiudad;
use app\models\UsuarioCiudadSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProrrogaController implements the CRUD actions for Prorroga model.
 */
class ProrrogaController extends Controller
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
     * Lists all Prorroga models.
     * @return mixed
     */
    public function actionIndex()
    {
        $array_post = Yii::$app->request->post(); // almacenar variables POST

        $user = isset(Yii::$app->session['usuario']) ? Yii::$app->session['usuario'] : ''; 
       
        $ciudades_actuales = UsuarioCiudad::find()->where(['usuario' => $user])->all();;
 
        $ciudad = array_key_exists('ciudad', $array_post)  ? $array_post['ciudad'] : 'xx';

        $cedula = array_key_exists('cedula', $array_post) && $array_post['cedula'] != '' ? $array_post['cedula'] : 10;
      
        //validar numero de días
        $dias = array_key_exists('dias', $array_post) && $array_post['dias'] != '' ? $array_post['dias'] : 45;
      
        $MAX_PRORROGAS_TRIMESTRALES = 3;
        $primaryConnection = Yii::$app->db;
        $primaryCommand = $primaryConnection->createCommand("SELECT COUNT(*) 
                                                             FROM prorroga
                                                             WHERE cedula = :cedula");
        $secondConnection =  Yii::$app->second_db;
        $command = $secondConnection->createCommand("SELECT bter_tercero.terc_nombre,
                                                            bter_tercero.terv_codigo,
                                                            bter_tercero.terc_nit,
                                                            FORMAT(bter_tercero.terf_contrato,'dd/MM/yyyy') as terf_contrato, 
                                                            bubi_ubicacion.ubic_nombre 
                                                       FROM      bter_tercero, bubi_ubicacion
                                                       WHERE     bter_tercero.tern_ubicacion = bubi_ubicacion.ubin_codigo
                                                        AND      bter_tercero.terc_empleado = 'S'
                                                        AND      bter_tercero.terc_estado_empleado = 'A'
                                                        AND      bter_tercero.tern_empresa = 1
                                                        AND      bter_tercero.terf_contrato >= getdate()
                                                        AND      bter_tercero.terf_contrato <= DATEADD(day,:dias,getdate())
                                                        AND      bubi_ubicacion.ubic_nombre LIKE :ciudades
                                                      ORDER BY   bter_tercero.terf_contrato ASC,
                                                                 bubi_ubicacion.ubic_nombre ASC");

        $secondCommand = $secondConnection->createCommand("SELECT bter_tercero.terc_nombre,
                                                                  bter_tercero.terv_codigo,
                                                                  bter_tercero.terc_nit,
                                                                  FORMAT(bter_tercero.terf_contrato,'dd/MM/yyyy') as terf_contrato,
                                                                  bubi_ubicacion.ubic_nombre
                                                           FROM      bter_tercero, bubi_ubicacion
                                                           WHERE     bter_tercero.tern_ubicacion = bubi_ubicacion.ubin_codigo
                                                            AND      bter_tercero.terc_empleado = 'S'
                                                            AND      bter_tercero.terc_estado_empleado = 'A'
                                                            AND      bter_tercero.tern_empresa = 1
                                                            AND      bter_tercero.terv_codigo = :cedula
                                                            ORDER BY   bter_tercero.terf_contrato ASC,  
                                                                       bubi_ubicacion.ubic_nombre ASC ");
                                
              
       
        // validar si existen empleados seleccionados a prorrogar
        $nits = array_key_exists('nits', $array_post) ? $array_post['nits'] : array();

        // cantidad de seleccionados
        $tamano = count($nits);
        $index = 0;
        $fecha_actual = date('Y-m-d',time());
        while ($index < $tamano) {
            
            
            $numero_de_prorrogas = $primaryCommand->bindValue(':cedula', intval($nits[$index]))->queryScalar();
            // Crear Modelo de Prorroga para manipulación
            $model = new Prorroga();
            
            /*establecer valores de Atributos del objeto prorroga*/
            $model->SetAttribute('cedula',intval($nits[$index]));
            $model->SetAttribute('fecha',$fecha_actual);
      

            /*Reglas de negocio*/
            if($numero_de_prorrogas <= $MAX_PRORROGAS_TRIMESTRALES){

                $command2 = $secondConnection->createCommand("UPDATE bter_tercero
                                                             SET   bter_tercero.terf_contrato = DATEADD(day,90,terf_contrato)
                                                             WHERE bter_tercero.terv_codigo = :codigo")
                                            ->bindValue(':codigo',$nits[$index])
                                            ->execute();


            }else{


                $command2 = $secondConnection->createCommand("UPDATE bter_tercero
                                                             SET   bter_tercero.terf_contrato = DATEADD(day,365,terf_contrato)
                                                             WHERE bter_tercero.terv_codigo = :codigo")
                                            ->bindValue(':codigo',$nits[$index])
                                            ->execute();


            }

            // Guardar Prorroga
            $model->save();

            $index++;
        }


         if($cedula == 10){

             $prorrogas = $command->bindValues([':dias' => intval($dias),
                                         ':ciudades' => '%'.$ciudad.'%' ])->queryAll(); // obtener resultados

         }else{

           Yii::$app->session['ced'] = $cedula;
        
            $prorrogas = $secondCommand->bindValue(':cedula',$cedula
                                                  )->queryAll(); // obtener resultados

 
         } 


    
        return $this->render('index', [
            'prorrogas' => $prorrogas,
            'seleccionados' => $nits,
            'ciudades_actuales' => $ciudades_actuales,
        ]);
    }


    

    /**
     * Displays a single Prorroga model.
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
     * Creates a new Prorroga model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Prorroga();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Prorroga model.
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
     * Deletes an existing Prorroga model.
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
     * Finds the Prorroga model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Prorroga the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Prorroga::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
