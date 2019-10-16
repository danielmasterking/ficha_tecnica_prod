<?php

namespace app\controllers;

use Yii;
use app\models\PermisoRol;
use app\models\PermisoRolSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PermisoRolController implements the CRUD actions for PermisoRol model.
 */
class PermisoRolController extends Controller
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
     * Lists all PermisoRol models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PermisoRolSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PermisoRol model.
     * @param integer $rol_id
     * @param integer $permiso_id
     * @return mixed
     */
    public function actionView($rol_id, $permiso_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($rol_id, $permiso_id),
        ]);
    }

    /**
     * Creates a new PermisoRol model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PermisoRol();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'rol_id' => $model->rol_id, 'permiso_id' => $model->permiso_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PermisoRol model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $rol_id
     * @param integer $permiso_id
     * @return mixed
     */
    public function actionUpdate($rol_id, $permiso_id)
    {
        $model = $this->findModel($rol_id, $permiso_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'rol_id' => $model->rol_id, 'permiso_id' => $model->permiso_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PermisoRol model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $rol_id
     * @param integer $permiso_id
     * @return mixed
     */
    public function actionDelete($rol_id, $permiso_id)
    {
        $this->findModel($rol_id, $permiso_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PermisoRol model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $rol_id
     * @param integer $permiso_id
     * @return PermisoRol the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($rol_id, $permiso_id)
    {
        if (($model = PermisoRol::findOne(['rol_id' => $rol_id, 'permiso_id' => $permiso_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
