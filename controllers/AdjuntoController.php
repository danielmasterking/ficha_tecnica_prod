<?php

namespace app\controllers;

use Yii;
use app\models\Adjunto;
use app\models\AdjuntoSearch;
use app\models\Preaviso;
use app\models\PreavisoSearch;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AdjuntoController implements the CRUD actions for Adjunto model.
 */
class AdjuntoController extends Controller
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
     * Lists all Adjunto models.
     * @return mixed
     */
    public function actionIndex()
    {
        $array_post = Yii::$app->request->post(); // almacenar variables POST
        $cedula = array_key_exists('cedula', $array_post)  ? $array_post['cedula'] : 0;
        $primaryConnection = Yii::$app->db;
        
        $command2 = $primaryConnection->createCommand('SELECT DISTINCT (cedula)
                                                      FROM   preaviso
                                                      ORDER BY cedula');
        
        $cedulas = $command2->queryAll();

        $primaryCommand = $primaryConnection->createCommand("SELECT image,fecha
                                                             FROM   adjunto
                                                             WHERE  cedula = :cedula
                                                             ");
      $secondConnection =  Yii::$app->second_db; // Oasis --> SQL SERVER

      $command = $secondConnection->createCommand("SELECT bter_tercero.terc_nombre,
                                                          bter_tercero.terv_codigo,
                                                          bter_tercero.terc_nit,
                                                          FORMAT(bter_tercero.terf_contrato,'dd/MM/yyyy') as terf_contrato,
                                                          bubi_ubicacion.ubic_nombre
                                                       FROM      bter_tercero, bubi_ubicacion
                                                       WHERE     bter_tercero.tern_ubicacion = bubi_ubicacion.ubin_codigo
                                                       AND       bter_tercero.terv_codigo = :cedula");

       $adjuntos = $primaryCommand->bindValue(':cedula', $cedula)->queryAll(); // obtener resultados

        return $this->render('index', [
               
                'adjuntos' => $adjuntos,
                'cedulas' => $cedulas,
                
            ]);

      
    }

    /**
     * Displays a single Adjunto model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        
        $primaryConnection = Yii::$app->db;
        $primaryCommand = $primaryConnection->createCommand("SELECT image,fecha
                                                             FROM   adjunto
                                                             WHERE  cedula = :cedula
                                                             ");

        $adjuntos = $primaryCommand->bindValue(':cedula', $id)->queryAll(); // obtener resultados
        return $this->render('view', [
               
                'adjuntos' => $adjuntos,
               
                
            ]);


    }


    /**
    *
    *
    *
    */



    /**
     * Creates a new Adjunto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Adjunto();
        $primaryConnection = Yii::$app->db;
        $command = $primaryConnection->createCommand('SELECT DISTINCT (cedula)
                                                      FROM   preaviso
                                                      ORDER BY cedula');
        
        $cedulas = $command->queryAll();
        Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/';
        $shortPath = '/uploads/';


        if ($model->load(Yii::$app->request->post())) {

            $image = UploadedFile::getInstance($model, 'image2');
            
            if($image !== null)
            {
                $model->image = $image->name;
                $ext = end((explode(".", $image->name)));
                $path = Yii::$app->params['uploadPath'] . $model->image;
                $model->image = $shortPath. $model->image;

            }

             $fecha_actual = date('Y-m-d',time());
             
             $model->SetAttribute('fecha',$fecha_actual);

             if($model->save())
             {

                if($image !== null)
                {
                     $image->saveAs($path);

                }
               
                return $this->redirect(['create', 'message' => '200']);


             }
            
            
            return $this->redirect(['inde', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'cedulas' => $cedulas,
            ]);
        }
    }

    /**
     * Updates an existing Adjunto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $primaryConnection = Yii::$app->db;
        $command = $primaryConnection->createCommand('SELECT DISTINCT (cedula)
                                                      FROM   preaviso
                                                      ORDER BY cedula');
        
        $cedulas = $command->queryAll();
        Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/';


        if ($model->load(Yii::$app->request->post())) {

            $image = UploadedFile::getInstance($model, 'image2');
            
            if($image !== null)
            {
                $model->image = $image->name;
                $ext = end((explode(".", $image->name)));
                $path = Yii::$app->params['uploadPath'] . $model->image;
                $model->image = Yii::$app->request->baseUrl. '/uploads/'. $model->image;

            }

            $fecha_actual = date('Y-m-d',time());
             
             $model->SetAttribute('fecha',$fecha_actual);


             if($model->save())
             {

                if($image !== null)
                {
                     $image->saveAs($path);

                }
               
                return $this->redirect(['create', 'message' => '200']);


             }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'cedulas' => $cedulas,
            ]);
        }
    }

    /**
     * Deletes an existing Adjunto model.
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
     * Finds the Adjunto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Adjunto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Adjunto::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
