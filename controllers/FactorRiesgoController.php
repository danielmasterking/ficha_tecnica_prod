<?php

namespace app\controllers;

use Yii;
use app\models\FactorRiesgo;
use app\models\Sucursal;
use app\models\FactorRiesgoSearch;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FactorRiesgoController implements the CRUD actions for FactorRiesgo model.
 */
class FactorRiesgoController extends Controller
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
     * Lists all FactorRiesgo models.
     * @return mixed
     */
    public function actionIndex($id)
    {
         $factores = FactorRiesgo::find()->with(['sucursal'])
                                            ->where(['sucursal_id' => $id])
                                            ->asArray()
                                            ->all();

         $sucursal = Sucursal::find()->where(['id' => $id])->all();                                   

        return $this->render('index', [

            'factores' => $factores,
            'id' => $id,
            'nit' => $sucursal[0]->nit,
            
        ]);
    }

    /**
     * Displays a single FactorRiesgo model.
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
     * Creates a new FactorRiesgo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new FactorRiesgo();
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

            $factores = FactorRiesgo::find()->with(['sucursal'])
                                            ->where(['sucursal_id' => $id])
                                            ->asArray()
                                            ->all();

            return $this->redirect(['index', 
                'id' => $id,
                'factores' => $factores,

                ]);


 
 
        } else {
            return $this->render('create', [
                'model' => $model,
                'sucursal_id' => $id,
            ]);
        }
    }

    /**
     * Updates an existing FactorRiesgo model.
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
     * Deletes an existing FactorRiesgo model.
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
     * Finds the FactorRiesgo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FactorRiesgo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FactorRiesgo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
