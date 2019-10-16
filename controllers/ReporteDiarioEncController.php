<?php

namespace app\controllers;

use Yii;
use app\models\ReporteDiarioEnc;
use app\models\Usuario;
use app\models\ReporteDiarioEncSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReporteDiarioEncController implements the CRUD actions for ReporteDiarioEnc model.
 */
class ReporteDiarioEncController extends Controller
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
     * Lists all ReporteDiarioEnc models.
     * @return mixed
     */
    public function actionIndex()
    {
        $usuario = Yii::$app->session['usuario'];
        date_default_timezone_set ( 'America/Bogota');
        $fecha_actual = date('Y-m-d',time());
        $today_time = strtotime($fecha_actual);
        $lower_time = strtotime('-90 day' , strtotime ( $fecha_actual )); 
        $array_post = Yii::$app->request->post();
        /*Ultimos 3 meses por defecto*/
        $ultimos_3_meses = strtotime('-45 day' , strtotime ( $fecha_actual )); 
        $date_ultimos__meses = date('Y-m-d',$ultimos_3_meses);


        /*obtener roles usuario*/
        $usuario_AR = Usuario::find()->where(['usuario' => $usuario])->all();

        $roles_usuario = $usuario_AR[0]->roles;

        $sw = 0;

        foreach ($roles_usuario as $key) {

            if(strpos($key->nombre, 'operaciones') !== false || strpos($key->nombre, 'Administrador') !== false){

                  $sw = 1;
                  break;

            }

        }        


         if(array_key_exists('consultar', $array_post) && array_key_exists('fecha_inicial', $array_post) 
            && array_key_exists('fecha_final', $array_post) ){

            $fecha_inicial = $array_post['fecha_inicial'];
            $fecha_final = $array_post['fecha_final'];


            if($sw == 0){


              $reportes = ReporteDiarioEnc::find()->where(['between','fecha',$fecha_inicial,$fecha_final])->andWhere(['usuario' => $usuario])->orderBy(['fecha' => SORT_DESC,])->all();


            }else{

              $reportes = ReporteDiarioEnc::find()->where(['between','fecha',$fecha_inicial,$fecha_final])->orderBy(['fecha' => SORT_DESC,])->all();

            }            





         }else{

            if($sw == 0){


              $reportes = ReporteDiarioEnc::find()->where(['usuario' => $usuario])->orderBy(['fecha' => SORT_DESC,])->all();


            }else{

              $reportes = ReporteDiarioEnc::find()->where(['>','fecha',$date_ultimos__meses])->orderBy(['fecha' => SORT_DESC,])->all();

            }


         }









        return $this->render('index', [
            'reportes' => $reportes,
            'today_time' => $today_time,
            'lower_time' => $lower_time,
        ]);
    }

    /**
     * Displays a single ReporteDiarioEnc model.
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
     * Creates a new ReporteDiarioEnc model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ReporteDiarioEnc();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ReporteDiarioEnc model.
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
     * Deletes an existing ReporteDiarioEnc model.
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
     * Finds the ReporteDiarioEnc model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ReporteDiarioEnc the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ReporteDiarioEnc::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
