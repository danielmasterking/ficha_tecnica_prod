<?php

namespace app\controllers;

use Yii;
use app\models\ObservacionVtecnica;
use app\models\Vtecnica;
use app\models\ObservacionVtecnicaSearch;
use yii\web\UploadedFile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ObservacionVtecnicaController implements the CRUD actions for ObservacionVtecnica model.
 */
class ObservacionVtecnicaController extends Controller
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
     * Lists all ObservacionVtecnica models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        $v_tecnica_model = Vtecnica::find()->where(['visita_id' => $id])->one();
        $observaciones = array();
        
        
        if($v_tecnica_model != null){
           
           $observaciones = ObservacionVtecnica::find()->where(['vtecnica_id' => $v_tecnica_model->id])->all();
               
        }
           
        return $this->render('index', [
            'observaciones' => $observaciones,
            'v_tecnica_model' => $v_tecnica_model,
            
        ]);
    }

    /**
     * Displays a single ObservacionVtecnica model.
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
     * Creates a new ObservacionVtecnica model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new ObservacionVtecnica();
        Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/';
        $shortPath = '/uploads/';


        if ($model->load(Yii::$app->request->post())) {

            $image = UploadedFile::getInstance($model, 'image2');

            if($image !== null)
            {
                $model->archivo = $image->name;
                $ext = end((explode(".", $image->name)));
                $name = date('Ymd').rand(1, 10000).''.$model->archivo;
                $path = Yii::$app->params['uploadPath'] . utf8_encode($name);
                
                $model->archivo = $shortPath. $name;

            }

            if($model->save(false)){

                 if($image !== null)
                {
                     $image->saveAs($path);

                }

            }

            $observaciones = ObservacionVtecnica::find()->where(['vtecnica_id' => $id])->all();

            return $this->redirect(['index', 
                'id' => $model->vtecnica->visita->id,
                'observaciones' => $observaciones,

                ]);

 
        } else {
            return $this->render('create', [
                'model' => $model,
                'vtecnica_id' => $id,
                
            ]);
        }
    }

    /**
     * Updates an existing ObservacionVtecnica model.
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
     * Deletes an existing ObservacionVtecnica model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
     public function actionEmpanada2($id)
    {
        $model = $this->findModel($id);

        $web = Yii::getAlias('@webroot');
        
        if(file_exists($web.$model->archivo)){
      
           unlink($web.$model->archivo);
        }
         
        

        $model->delete();

        return $this->redirect(['visita/index']);
    }

    /**
     * Finds the ObservacionVtecnica model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ObservacionVtecnica the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ObservacionVtecnica::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
