<?php

namespace app\controllers;

use Yii;
use app\models\SeguimientoEstudio;
use app\models\EstudioSeguridad;

use app\models\SeguimientoEstudioSearch;
use yii\web\UploadedFile;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SeguimientoEstudioController implements the CRUD actions for SeguimientoEstudio model.
 */
class SeguimientoEstudioController extends Controller
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
     * Lists all SeguimientoEstudio models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        $seguimientos = SeguimientoEstudio::find()->where(['estudio_seguridad_id' => $id])->all();
        $estudio = EstudioSeguridad::find()->where(['id' => $id])->one();
        
        return $this->render('index', [
            'seguimientos' => $seguimientos,
            'id' => $id,
            'sucursal_id' => $estudio->sucursal->id,
            
        ]);
    }

    /**
     * Displays a single SeguimientoEstudio model.
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
     * Creates a new SeguimientoEstudio model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new SeguimientoEstudio();
        Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/';
        $shortPath = '/uploads/';

        date_default_timezone_set ( 'America/Bogota');

        if ($model->load(Yii::$app->request->post()) ) {

             $image = UploadedFile::getInstance($model, 'image2');
             if($image !== null)
            {
                $model->archivo = $image->name;
                $ext = end((explode(".", $image->name)));
                $name = date('Ymd').rand(1, 10000).''.$model->archivo;
                $path = Yii::$app->params['uploadPath'] . $name;
                $model->archivo = $shortPath. $name;

            }
            
             $model->setAttribute('estudio_seguridad_id',$id);
             

             if($model->save()){

                  /*Sumar un día a fecha de visita técnica*/
                  $fecha_real = strtotime('+1 day' , strtotime ( $model->fecha ));
                  $fecha_real = date('Y-m-d',$fecha_real);
                  $model->setAttribute('fecha',$fecha_real);
                  $model->save();

                 if($image !== null)
                {
                     $image->saveAs($path);

                }

            }

            $seguimientos = SeguimientoEstudio::find()->where(['estudio_seguridad_id' => $id])->all();
            return $this->redirect(['index', 
                'id' => $id,
                'seguimientos' => $seguimientos,

            ]);


        } else {
            return $this->render('create', [
                'model' => $model,
                'id' => $id,
            ]);
        }
    }

    /**
     * Updates an existing SeguimientoEstudio model.
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
     * Deletes an existing SeguimientoEstudio model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $estudio = $model->estudio;

        $web = Yii::getAlias('@webroot');

        unlink($web.$model->archivo);

        $model->delete();

        return $this->redirect(['index', 'id' => $estudio->id.'']);
    }

    /**
     * Finds the SeguimientoEstudio model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SeguimientoEstudio the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SeguimientoEstudio::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
