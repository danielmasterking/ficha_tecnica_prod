<?php

namespace app\controllers;

use Yii;
use app\models\Junta;
use app\models\HistorialJunta;
use app\models\JuntaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * JuntaController implements the CRUD actions for Junta model.
 */
class JuntaController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Junta models.
     * @return mixed
     */
    public function actionIndex()
    {
        $juntas = Junta::find()->all();
        
        //$this->layout = "layoutJunta";

        return $this->render('index', [
            
            'juntas' => $juntas,
        ]);
    }

    /**
     * Displays a single Junta model.
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
     * Creates a new Junta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        //$this->layout = "layoutJunta";
        $model = new Junta();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

             /*Sumar un día a fecha de visita técnica*/
              $fecha_real = strtotime('+1 day' , strtotime ( $model->fecha ));
              $fecha_real = date('Y-m-d',$fecha_real);
              $model->setAttribute('fecha',$fecha_real);
              $model->save();
              
             $juntas = Junta::find()->all();
            return $this->redirect(['index', 'juntas' => $juntas]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Junta model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        //$this->layout = "layoutJunta";
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $juntas = Junta::find()->all();
            return $this->redirect(['index', 'juntas' => $juntas]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Junta model.
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
     * Finds the Junta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Junta the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Junta::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
