<?php

namespace app\controllers;

use Yii;
use app\models\ArchivoJunta;
use app\models\HistorialJunta;
use app\models\ArchivoJuntaSearch;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ArchivoJuntaController implements the CRUD actions for ArchivoJunta model.
 */
class ArchivoJuntaController extends Controller
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
     * Lists all ArchivoJunta models.
     * @return mixed
     */
    public function actionIndex($id_junta)
    {
        //$this->layout = "layoutJunta";
        $archivos = ArchivoJunta::find()->where(['junta_id' => $id_junta])->all();

        return $this->render('index', [
            'archivos' => $archivos,
            'id_junta' => $id_junta,

            
        ]);
    }

    /**
     * Displays a single ArchivoJunta model.
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
     * Creates a new ArchivoJunta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id_junta)
    {
      //  $this->layout = "layoutJunta";
        $model = new ArchivoJunta();
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

            $archivos = ArchivoJunta::find()->where(['junta_id' => $id_junta])->all();

            return $this->redirect(['index', 
                'id_junta' => $id_junta,
                'archivos' => $archivos,

                ]);

        } else {
            return $this->render('create', [
                'model' => $model,
                'id_junta' => $id_junta,
            ]);
        }
    }

    public function actionViewpdf($id, $id_junta){
        //$this->layout = "layoutJunta";
        $file = $id;
        date_default_timezone_set ( 'America/Bogota');
        $fecha = date('Y-m-d H:i:s', time());
        $usuario = Yii::$app->session['usuario'];
        $names = explode('/', $file);
        $archivo = $names[count($names) - 1];
        /***************   Usuario Vio documento ******************************/
        $historial_junta_model = new HistorialJunta();
        $historial_junta_model->setAttribute('usuario', $usuario);
        $historial_junta_model->setAttribute('fecha', $fecha);   
        $historial_junta_model->setAttribute('mensaje', 'Vió documento '.$archivo);             
        $historial_junta_model->save();
        /*********************************************************************/
        
        return $this->render('pdf',['file' => $file, 'id_junta' => $id_junta]);
        
    }

    /**
     * Updates an existing ArchivoJunta model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout = "layoutJunta";
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

        $id_junta = $model->junta_id;

        $web = Yii::getAlias('@webroot');
        
        if(file_exists($web.$model->archivo)){
      
           unlink($web.$model->archivo);
        }
         
        $model->delete();

        

        return $this->redirect(['index', 'id_junta' => $id_junta]);
    }

    /**
     * Deletes an existing ArchivoJunta model.
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
     * Finds the ArchivoJunta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ArchivoJunta the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ArchivoJunta::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
