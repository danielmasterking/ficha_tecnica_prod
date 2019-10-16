<?php

namespace app\controllers;

use Yii;
use app\models\Rol;
use app\models\Permiso;
use app\models\PermisoRol;
use app\models\RolSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RolController implements the CRUD actions for Rol model.
 */
class RolController extends Controller
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
     * Lists all Rol models.
     * @return mixed
     */
    public function actionIndex()
    {
        $roles = Rol::find()->asArray()->all();

        return $this->render('index', [
           'roles' => $roles,
        ]);
    }

    /**
     * Displays a single Rol model.
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
     * Creates a new Rol model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Rol();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Rol model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

     public function actionPermisos($id)
    {
        $array_post = Yii::$app->request->post(); // almacenar variables POST
        
        $permisos = Permiso::find()->all();
        $rol = Rol::find()->where(['id' => intval($id)])->all();
        $rol = $rol[0];
        $primaryConnection = Yii::$app->db;

        $primaryCommand = $primaryConnection->createCommand("DELETE 
                                                             FROM  permiso_rol
                                                             WHERE rol_id = :rol_id
                                                            ");

        $secondCommand = $primaryConnection->createCommand("SELECT rol_id, permiso_id 
                                                             FROM   permiso_rol
                                                             WHERE  rol_id = :rol_id
                                                            ");

        $permisos_array = array_key_exists('permisos_array', $array_post) ? $array_post['permisos_array'] : array();
        $tamano_permisos_array = count($permisos_array);
        
        if($tamano_permisos_array > 0){

            $primaryCommand->bindValue(':rol_id' , $id)->execute();

            for($i=0;$i < $tamano_permisos_array; $i++){

                $model = new PermisoRol();
                $model->SetAttribute('rol_id',$id);
                $model->SetAttribute('permiso_id',$permisos_array[$i]);
                $model->save();

            }

            return $this->redirect('index');


        }

        $permisos_actuales = $secondCommand->bindValue(':rol_id', $id)->queryAll(); 


        /*Obtener permisos actuales del rol*/


        return $this->render('permisos', [
                  
                  'permisos' => $permisos,
                  'permisos_actuales' => $permisos_actuales,
                  'rol' => $rol,

               ]);

    }

    /**
     * Deletes an existing Rol model.
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
     * Finds the Rol model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Rol the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Rol::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
