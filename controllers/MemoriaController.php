<?php

namespace app\controllers;

use Yii;
use app\models\Memoria;
use app\models\Sucursal;
use app\models\UsuarioCiudad;
use app\models\UsuarioSucursal;
use app\models\MemoriaSearch;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MemoriaController implements the CRUD actions for Memoria model.
 */
class MemoriaController extends Controller
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
     * Lists all Memoria models.
     * @return mixed
     */
    public function actionIndex($id)
    {
         $usuario = Yii::$app->session['usuario'];
        $sucursales = Sucursal::find()->where(['nit' => $id])->all();
        $ciudades_usuario = UsuarioCiudad::find()->where(['usuario' => $usuario])->all();
        $sucursales_usuario = UsuarioSucursal::find()->where(['usuario' => $usuario])->all();
        $array_ciudades = array();
        $array_sucursales = array();

        foreach ($ciudades_usuario as $key ) {
            
            $array_ciudades [] = $key->ciudad_id;
        }

        foreach ($sucursales_usuario as $key ) {
           
            $array_sucursales [] = $key->sucursal_id;
        }

        return $this->render('index', [
           'sucursales' => $sucursales,
           'nit' => $id,
           'ciudades_usuario' => $array_ciudades,
           'sucursales_usuario' => $array_sucursales,
        ]);
    }

    /**
     * Displays a single Memoria model.
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
     * Creates a new Memoria model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $usuario = Yii::$app->session['usuario'];
        $model = new Memoria();
        $sucursales = Sucursal::find()->where(['nit' => $id])->all();
        Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/';
        $shortPath = '/uploads/';
        $ciudades_usuario = UsuarioCiudad::find()->where(['usuario' => $usuario])->all();
        $sucursales_usuario = UsuarioSucursal::find()->where(['usuario' => $usuario])->all();
        $array_ciudades = array();
        $array_sucursales = array();

        foreach ($ciudades_usuario as $key ) {
            
            $array_ciudades [] = $key->ciudad_id;
        }

        foreach ($sucursales_usuario as $key ) {
           
            $array_sucursales [] = $key->sucursal_id;
        }



        if ($model->load(Yii::$app->request->post()) ) {

            $image = UploadedFile::getInstance($model, 'image2');

            if($image !== null)
            {                $model->archivo = $image->name;
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

            return $this->redirect(['index', 'id' => $id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'sucursales' => $sucursales,
                'nit' => $id,
                'ciudades_usuario' => $array_ciudades,
                'sucursales_usuario' => $array_sucursales,
            ]);
        }
    }

    /**
     * Updates an existing Memoria model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $sucursales = Sucursal::find()->where(['nit' => $model->sucursal->cliente->nit])->all();
        $shortPath = '/uploads/';

        if ($model->load(Yii::$app->request->post()) ) {

            $image = UploadedFile::getInstance($model, 'image2');

            if($image !== null)
            {
                $model->archivo = $image->name;
                $ext = end((explode(".", $image->name)));
                 $name = date('Ymd').rand(1, 10000).''.$model->archivo;
                $path = Yii::$app->params['uploadPath'] . $model->archivo;
                $model->archivo = $shortPath. $model->archivo;

            }

            if($model->save()){

                 if($image !== null)
                {
                     $image->saveAs($path);

                }

            }

            return $this->redirect(['index', 'id' => $model->sucursal->cliente->nit]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'sucursales' => $sucursales,
                 'nit' => $model->sucursal->cliente->nit,
            ]);
        }
    }

    /**
     * Deletes an existing Memoria model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $sucursal = $model->sucursal;

        $web = Yii::getAlias('@webroot');

        unlink($web.$model->archivo);

        $model->delete();

        return $this->redirect(['index', 'id' => $sucursal->id.'']);
    }

    /**
     * Finds the Memoria model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Memoria the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Memoria::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
