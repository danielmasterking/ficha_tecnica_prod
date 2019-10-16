<?php

namespace app\controllers;

use Yii;
use app\models\Consigna;
use app\models\Sucursal;
use app\models\ConsignaSearch;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ConsignaController implements the CRUD actions for Consigna model.
 */
class ConsignaController extends Controller
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
     * Lists all Consigna models.
     * @return mixed
     */
    public function actionIndex($id)
    {
         $consignas = Consigna::find()->with(['sucursal'])
                                      ->where(['sucursal_id' => $id])
                                      ->asArray()
                                      ->all();

         $sucursal = Sucursal::find()->where(['id' => $id])->all();

        return $this->render('index', [

            'consignas' => $consignas,
            'id' => $id,
            'nit' => $sucursal[0]->nit,
            
        ]);
    }

    /**
     * Displays a single Consigna model.
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
     * Creates a new Consigna model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new Consigna();
        Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/';
        $shortPath = '/uploads/';


        if ($model->load(Yii::$app->request->post())) {

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

            $consignas = Consigna::find()->with(['sucursal'])
                                            ->where(['sucursal_id' => $id])
                                            ->asArray()
                                            ->all();

            return $this->redirect(['index', 
                'id' => $id,
                'consignas' => $consignas,

                ]);


 
 
        } else {
            return $this->render('create', [
                'model' => $model,
                'sucursal_id' => $id,
                
            ]);
        }

        
    }

    /**
     * Updates an existing Consigna model.
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
     * Deletes an existing Consigna model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $sucursal = $model->sucursal;

        $web = Yii::getAlias('@webroot');

        unlink($web.$model->archivo);

        $model->delete();

        return $this->redirect(['index', 'id' => $sucursal->id.'']);
    }
    
    public function actionEmpanada($id)
    {
        $model = $this->findModel($id);

        $sucursal = $model->sucursal;

        $web = Yii::getAlias('@webroot');
        
        if(file_exists($web.$model->archivo)){
      
           unlink($web.$model->archivo);
        }
         
        

        $model->delete();

        return $this->redirect(['index', 'id' => $sucursal->id]);
    }

    /**
     * Finds the Consigna model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Consigna the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Consigna::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
