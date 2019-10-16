<?php

namespace app\controllers;

use Yii;
use app\models\Sucursal;
use app\models\Contacto;
use app\models\UsuarioCiudad;
use app\models\UsuarioSucursal;
use app\models\SucursalSearch;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SucursalController implements the CRUD actions for Sucursal model.
 */
class SucursalController extends Controller
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
     * Lists all Sucursal models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        $primaryConnection = Yii::$app->db;
        $primaryCommand = $primaryConnection->createCommand("SELECT id, cod_oasis 
                                                             FROM  sucursal
                                                             WHERE nit = :id
                                                             ");

        $ciudadCommand = $primaryConnection->createCommand("SELECT id 
                                                             FROM  ciudad
                                                             WHERE cod_oasis = :cod_oasis

                                                             ");

        $sucursales_actuales = $primaryCommand->bindValue(':id',$id)->queryAll();

        $sucursales_actuales_array = array();
        $ids_sucursales_actuales = array();
        $usuario = Yii::$app->session['usuario'];

        foreach ($sucursales_actuales as $key => $value) {
            
            $sucursales_actuales_array [] = $value['cod_oasis'];
            
        }
      
        /*$secondConnection =  Yii::$app->second_db; // Oasis --> SQL SERVER

        $command = $secondConnection->createCommand("SELECT bdir_direccion.dirn_numero AS COD,
                                                            bdir_direccion.dirc_nombre AS NOMBRE,
                                                            bdir_direccion.dirc_direccion AS DIRECCION,
                                                            bdir_direccion.dirn_ubicacion_geografica AS COD_OASIS
                                                        FROM bdir_direccion
                                                        WHERE 
                                                              bdir_direccion.dirn_numero%20 = 0
                                                        AND   bdir_direccion.dirn_numero < 4000
                                                        AND   bdir_direccion.dirv_tercero = :id");

        $sucursales_oasis = $command->bindValue(':id',$id)->queryAll();


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

                $model_validator = Sucursal::find()->where(['nit' => $id,'cod_oasis' => $tmp[0]])
                                                    ->one();

                if($model_validator == null){

                    $model->setAttribute('nit',$id);
                    $model->setAttribute('nombre',$tmp[1]);
                    $model->setAttribute('direccion',$tmp[2]);
                    $model->setAttribute('cod_oasis',$tmp[0]);
                    $model->setAttribute('ciudad_id',$clave['id']);
                    $model->save();

                }
                
            }else{

                $clave =  $ciudadCommand->bindValue(':cod_oasis',$tmp[3])->queryOne();
                $model_validator = Sucursal::find()->where(['nit' => $id,'cod_oasis' => $tmp[0]])
                                                    ->one();

                if($model_validator != null){

                    $model_validator->setAttribute('nit',$id);
                    $model_validator->setAttribute('nombre',$tmp[1]);
                    $model_validator->setAttribute('direccion',$tmp[2]);
                    $model_validator->setAttribute('cod_oasis',$tmp[0]);
                    $model_validator->setAttribute('ciudad_id',$clave['id']);
                    $model_validator->save();

                }



            }

        }

        */



        $sucursales = Sucursal::find()->with(['ciudad','cliente'])
                                      ->where(['nit' => $id])
                                      ->asArray()
                                      ->all();

        $ciudades_usuario = UsuarioCiudad::find()->where(['usuario' => $usuario])->all();
        $sucursales_usuario = UsuarioSucursal::find()->where(['usuario' => $usuario])->all();

        if(count($sucursales) == 0){

             \Yii::$app->getSession()->setFlash('error', 'Cliente no tiene sucursales de vigilancia');

             Yii::$app->response->redirect(array('cliente/index'));


        }                              

        return $this->render('index', [

            'sucursales' => $sucursales,
            'ciudades_usuario' => $ciudades_usuario,
            'sucursales_usuario' => $sucursales_usuario,
            
        ]);
        
    }

    /**
     * Displays a single Sucursal model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $contactos = Contacto::find()->where(['sucursal_id' => $id])->all();
        return $this->render('view', [
            'model' => $model,
            'nit' => $model->cliente->nit,
            'id' => $id,
            'contactos' => $contactos,
        ]);
    }

    public function actionTemporal($id)
    {
       $model = $this->findModel($id);
       $model->setAttribute('temporal', 'S');
       $model->save();
      return $this->redirect(['index' ,'id' => $model->cliente->nit]);

    }

    public function actionRtemporal($id)
    {
       $model = $this->findModel($id);
       $model->setAttribute('temporal', 'N');
       $model->save();
       return $this->redirect(['index' ,'id' => $model->cliente->nit]);

    }

    public function actionImagen($id)
    {
        Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/';
        $shortPath = '/uploads/';
        $array_post = Yii::$app->request->post();
         $model = $this->findModel($id);
         $contactos = Contacto::find()->where(['sucursal_id' => $id])->all();

        if(isset($array_post['cambiar'])){

            $image = UploadedFile::getInstance($model, 'image2');
            if($image !== null)
            {
                date_default_timezone_set ( 'America/Bogota');
                $fecha_registro = date('Ymd',time());
                
                $model->image = $fecha_registro.'_'.utf8_encode($image->name);
                $ext = end((explode(".", $image->name)));
                $path = Yii::$app->params['uploadPath'] . $model->image;
                $model->image = $shortPath. $model->image;

            }


            if($model->save()){

                 if($image !== null)
                {
                     $image->saveAs($path);
                     return $this->render('view', [
                    'model' => $model,
                    'nit' => $model->cliente->nit,
                    'id' => $id,
                    'contactos' => $contactos,
                     ]);

                }

            }

        }



       
        
        return $this->render('imagen', [
            'model' => $model,
            'nit' => $model->cliente->nit,
            'id' => $id,
            
        ]);
    }

    /**
     * Creates a new Sucursal model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Sucursal();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Sucursal model.
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
     * Deletes an existing Sucursal model.
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
     * Finds the Sucursal model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Sucursal the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sucursal::findOne($id)) !== null) {
            return $model;
        } else {
            return null;
        }
    }
}
