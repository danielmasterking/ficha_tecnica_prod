<?php

namespace app\controllers;

use Yii;
use app\models\SeguimientoVisita;
use app\models\Estado;
use app\models\SeguimientoVisitaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SeguimientoVisitaController implements the CRUD actions for SeguimientoVisita model.
 */
class SeguimientoVisitaController extends Controller
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
     * Lists all SeguimientoVisita models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        $seguimientos = SeguimientoVisita::find()->where(['visita_id' => $id])->all();
        return $this->render('index', [
           'seguimientos' => $seguimientos,
           'id_visita' => $id,
        ]);
    }
    
    public function actionIndexcliente($id)
    {
        $estado = Estado::find()->where(['tipo'  => 'V', 'orden' => 4])->one(); 
        $seguimientos = SeguimientoVisita::find()->where(['visita_id' => $id,'estado_id' => $estado->id])->all();
        return $this->render('indexcliente', [
           'seguimientos' => $seguimientos,
           'id_visita' => $id,
        ]);
    }

    /**
     * Displays a single SeguimientoVisita model.
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
     * Creates a new SeguimientoVisita model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new SeguimientoVisita();
        $usuario = Yii::$app->session['usuario'];
        $estado = Estado::find()->where(['tipo' => 'V','orden' => 1])->one();
        if ($model->load(Yii::$app->request->post()) ) {

            $model->setAttribute('visita_id',$id);
            $model->setAttribute('usuario',$usuario);
            $model->setAttribute('estado_id',$estado->id);
            $model->save();
            return $this->redirect(['index', 'id' => $id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'id_visita' => $id,
            ]);
        }
    }

    /**
     * Updates an existing SeguimientoVisita model.
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
     * Deletes an existing SeguimientoVisita model.
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
     * Finds the SeguimientoVisita model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SeguimientoVisita the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SeguimientoVisita::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
