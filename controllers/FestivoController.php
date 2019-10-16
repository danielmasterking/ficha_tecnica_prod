<?php

namespace app\controllers;

use Yii;
use app\models\Festivo;
use app\models\FestivoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FestivoController implements the CRUD actions for Festivo model.
 */
class FestivoController extends Controller
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
     * Lists all Festivo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FestivoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Festivo model.
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
     * Creates a new Festivo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Festivo();
      

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

              $fecha_real = strtotime('+1 day' , strtotime ( $model->fecha ));
              $fecha_real = date('Y-m-d',$fecha_real);
              $model->setAttribute('fecha',$fecha_real);
              $model->save();

              $festivos = Festivo::find()->orderBy(['fecha' => SORT_DESC])->all();
           
           return $this->render('create', [
                'model' => $model,
                'festivos' => $festivos,
            ]);

        } else {
              $festivos = Festivo::find()->orderBy(['fecha' => SORT_DESC])->all();
            return $this->render('create', [
                'model' => $model,
                'festivos' => $festivos,
            ]);
        }
    }

    /**
     * Updates an existing Festivo model.
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
     * Deletes an existing Festivo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['create']);
    }

    /**
     * Finds the Festivo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Festivo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Festivo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
