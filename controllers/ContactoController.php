<?php

namespace app\controllers;

use Yii;
use app\models\Contacto;
use app\models\Sucursal;
use app\models\ContactoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ContactoController implements the CRUD actions for Contacto model.
 */
class ContactoController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                 //   'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Contacto models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        $contactos = Contacto::find()->where(['sucursal_id' => $id])->all();
        $sucursal = Sucursal::find()->where(['id' => $id])->all(); 
        return $this->render('index', [
            
            'contactos' => $contactos,
            'nit' => $sucursal[0]->nit,
            'id' => $id,
        ]);
    }

    /**
     * Displays a single Contacto model.
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
     * Creates a new Contacto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new Contacto();
        $sucursal = Sucursal::find()->where(['id' => $id])->one(); 

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
             $this->redirect(['sucursal/view?id='.$model->sucursal->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'id' => $sucursal->id,
            ]);
        }
    }

    /**
     * Updates an existing Contacto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->redirect(['sucursal/view?id='.$model->sucursal->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'id' => $model->sucursal->id,
            ]);
        }
    }

    /**
     * Deletes an existing Contacto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        
        $id_sucursal = $this->findModel($id)->sucursal->id;

        $this->findModel($id)->delete();
        
        return $this->redirect(['sucursal/view?id='.$id_sucursal]);
        
        //return $this->redirect(['index']);
    }

    /**
     * Finds the Contacto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Contacto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Contacto::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
