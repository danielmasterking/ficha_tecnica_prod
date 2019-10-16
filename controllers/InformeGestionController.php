<?php

namespace app\controllers;

use Yii;
use app\models\InformeGestion;
use app\models\InformeGestionSearch;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * InformeGestionController implements the CRUD actions for InformeGestion model.
 */
class InformeGestionController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    
                ],
            ],
        ];
    }

    /**
     * Lists all InformeGestion models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        $informes = InformeGestion::find()->where(['cliente' => $id])
                                          ->orderBy(['fecha' => SORT_DESC])
                                          ->all();
        
        return $this->render('index', [
            'informes' => $informes,
            
        ]);
    }

    /**
     * Displays a single InformeGestion model.
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
     * Creates a new InformeGestion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new InformeGestion();
        date_default_timezone_set ( 'America/Bogota');
        $fecha_registro = date('Y-m-d',time());
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

                $fecha_real = strtotime('+1 day' , strtotime ( $model->fecha ));
                $fecha_real = date('Y-m-d',$fecha_real);
                $model->setAttribute('fecha',$fecha_real);
                $model->save();

                 if($image !== null)
                {
                     $image->saveAs($path);

                }

            }

            return $this->redirect(['index', 'id' => $id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'id' => $id,
                'fecha_registro' => $fecha_registro,
            ]);
        }
    }

    /**
     * Updates an existing InformeGestion model.
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

    public function actionEmpanada($id)
    {
        $model = $this->findModel($id);
        $cliente = $model->cliente;

        $web = Yii::getAlias('@webroot');
        
        if(file_exists($web.$model->archivo)){
      
           unlink($web.$model->archivo);
        }
         
        $model->delete();

        

        return $this->redirect(['index', 'id' => $cliente]);
    }

    /**
     * Deletes an existing InformeGestion model.
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
     * Finds the InformeGestion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InformeGestion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InformeGestion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
