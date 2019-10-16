<?php

namespace app\controllers;

use Yii;
use app\models\Ccosto;
use app\models\CcostoSearch;
use app\models\Ciudad;
use app\models\Cliente;
use app\models\Sucursal;
use app\models\CcostoCiudad;
use app\models\CiudadSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CcostoController implements the CRUD actions for Ccosto model.
 */
class CcostoController extends Controller
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
     * Lists all Ccosto models.
     * @return mixed
     */
    public function actionIndex()
    {
        $centros = Ccosto::find()->asArray()->all();
        
        $clientes_activos = Cliente::find()->where(['estado' => 'A'])->all();



        $primaryConnection = Yii::$app->db;
        $secondConnection =  Yii::$app->second_db; // Oasis --> SQL SERVER

        $primaryCommand = $primaryConnection->createCommand("SELECT id, cod_oasis 
                                                             FROM  sucursal
                                                             WHERE nit = :id
                                                             ");

        $ciudadCommand = $primaryConnection->createCommand("SELECT id 
                                                             FROM  ciudad
                                                             WHERE cod_oasis = :cod_oasis

                                                             ");

        /*foreach ($clientes_activos as $key2 ) {

            $sucursales_actuales = $primaryCommand->bindValue(':id',$key2->nit)->queryAll();
            $sucursales_actuales_array = array();
            $ids_sucursales_actuales = array();

            foreach ($sucursales_actuales as $key => $value) {
             
               $sucursales_actuales_array [] = $value['cod_oasis'];
            
            }


                $command = $secondConnection->createCommand("SELECT bdir_direccion.dirn_numero AS COD,
                                                                bdir_direccion.dirc_nombre AS NOMBRE,
                                                                bdir_direccion.dirc_direccion AS DIRECCION,
                                                                bdir_direccion.dirn_ubicacion_geografica AS COD_OASIS
                                                            FROM bdir_direccion
                                                            WHERE 
                                                                  bdir_direccion.dirn_numero%20 = 0
                                                            AND   bdir_direccion.dirn_numero < 4000
                                                            AND   bdir_direccion.dirv_tercero = :id");

                $sucursales_oasis = $command->bindValue(':id',$key2->nit)->queryAll();


                $sucursales_oasis_array = array();

                foreach ($sucursales_oasis as $key => $value) {
                    
                    $sucursales_oasis_array [] = $value['COD'].';'.$value['NOMBRE'].';'.$value['DIRECCION'].';'.$value['COD_OASIS'];
                }

                $tamano_sucursales_oasis = count($sucursales_oasis_array);

                for($i = 1; $i < $tamano_sucursales_oasis; $i++){

                    $tmp = explode(';', $sucursales_oasis_array[$i]);
                    
                    if(!in_array($tmp[0], $sucursales_actuales_array)){

                        $clave =  $ciudadCommand->bindValue(':cod_oasis',$tmp[3])->queryOne();
                      //  $ids_sucursales_actuales [] = $clave;
                        
                        $model = new Sucursal();

                        $model_validator = Sucursal::find()->where(['nit' => $key2->nit,'cod_oasis' => $tmp[0]])
                                                            ->one();

                        if($model_validator == null){

                            $model->setAttribute('nit',$key2->nit);
                            $model->setAttribute('nombre',$tmp[1]);
                            $model->setAttribute('direccion',$tmp[2]);
                            $model->setAttribute('cod_oasis',$tmp[0]);
                            $model->setAttribute('ciudad_id',$clave['id']);
                            $model->save();

                        }
                        
                    }else{

                        $clave =  $ciudadCommand->bindValue(':cod_oasis',$tmp[3])->queryOne();
                        $model_validator = Sucursal::find()->where(['nit' => $key2->nit,'cod_oasis' => $tmp[0]])
                                                            ->one();

                        if($model_validator != null){

                            $model_validator->setAttribute('nit',$key2->nit);
                            $model_validator->setAttribute('nombre',$tmp[1]);
                            $model_validator->setAttribute('direccion',$tmp[2]);
                            $model_validator->setAttribute('cod_oasis',$tmp[0]);
                            $model_validator->setAttribute('ciudad_id',$clave['id']);
                            $model_validator->save();

                        }



                    }

                }
                

        }
        */
        




        return $this->render('index', [

            'centros' => $centros,
            
        ]);
    }



    public function actionCiudades($id)
    {
        $array_post = Yii::$app->request->post(); // almacenar variables POST
        $model = $this->findModel($id);
        $primaryConnection = Yii::$app->db;
        $primaryCommand = $primaryConnection->createCommand("DELETE 
                                                              FROM  ccosto_ciudad
                                                              WHERE ccosto_id = :id
                                                             ");

        $secondCommand = $primaryConnection->createCommand(" SELECT ciudad_id
                                                              FROM  ccosto_ciudad
                                                              WHERE ccosto_id = :id
                                                             ");

        $ciudades_actuales = $secondCommand->bindValue(':id',intval($id))->queryAll(); 



        
        

        if(isset($array_post['asignar'])){

             $primaryCommand->bindValue(':id',intval($id))->execute();

             $seleccionadas = array_key_exists('ciudad', $array_post) ? $array_post['ciudad'] : array();
             $tamano_seleccionadas = count($seleccionadas);
             for ($i=0; $i < $tamano_seleccionadas ; $i++) { 
                 $usu_cen_model = new CcostoCiudad();
                
                 $usu_cen_model->SetAttribute('ccosto_id',intval($id));
                 $usu_cen_model->SetAttribute('ciudad_id',intval($seleccionadas[$i]));
                 $usu_cen_model->save();

             }
             
             $centros = Ccosto::find()->asArray()->all();

             return $this->render('index',[
                    'centros' => $centros,
                    ]);
        }

        $ciudades = Ciudad::find()->asArray()->all();

        return $this->render('ciudades', [
            'model' => $model,
            'ciudades' => $ciudades,
            'ciudades_actuales' => $ciudades_actuales,
        ]);
        
    }

    /**
     * Displays a single Ccosto model.
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
     * Creates a new Ccosto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Ccosto();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Ccosto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Ccosto model.
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
     * Finds the Ccosto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ccosto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ccosto::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
