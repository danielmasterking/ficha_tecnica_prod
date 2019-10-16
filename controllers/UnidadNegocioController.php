<?php

namespace app\controllers;

use Yii;
use app\models\UnidadNegocio;
use app\models\Cliente;
use app\models\Sucursal;
use app\models\SucursalUnidad;
use app\models\UnidadNegocioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UnidadNegocioController implements the CRUD actions for UnidadNegocio model.
 */
class UnidadNegocioController extends Controller
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
     * Lists all UnidadNegocio models.
     * @return mixed
     */
    public function actionIndex()
    {
       $unidades = UnidadNegocio::find()->orderBy(['nombre' => SORT_ASC])->all();

        return $this->render('index', [
            'unidades' => $unidades,
        ]);
    }

    /**
     * Displays a single UnidadNegocio model.
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
     * Creates a new UnidadNegocio model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UnidadNegocio();
        $clientes = Cliente::find()->where(['estado' => 'A'])->orderBy(['nombre' => SORT_ASC])->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'status' => 'ok']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'clientes' => $clientes,
            ]);
        }
    }

    public function actionAsignar($id){
        
        $array_post = Yii::$app->request->post(); // almacenar variables POST
        $unidad = UnidadNegocio::find()->where(['id' => $id])->one();
        $sucursales_cliente = Sucursal::find()->where(['nit' => $unidad->clienteName->nit, 'estado' => 'A'])->all();
        $primaryConnection = Yii::$app->db;
        $primaryCommand = $primaryConnection->createCommand("DELETE 
                                                             FROM sucursal_unidad
                                                             WHERE unidad_negocio_id = :unidad_id
                                                             ");

        if(array_key_exists('asignar', $array_post)){
           
           $sucursales_array = array_key_exists('sucursales_array', $array_post) ? $array_post['sucursales_array'] : array();
           
           $tamano_sucursales = count($sucursales_array);

           if($tamano_sucursales > 0){
            
            $primaryCommand->bindValue(':unidad_id',$id)->execute();
            //Asignar Sucursales
            $index = 0;

            while($index < $tamano_sucursales){
              
              $sucursal_unidad_model = new SucursalUnidad();
              $sucursal_unidad_model->setAttribute('unidad_negocio_id',$id);
              $sucursal_unidad_model->setAttribute('sucursal_id',$sucursales_array[$index]);
              $sucursal_unidad_model->save();

              $index++;

            }


           }

        }   

        //Obtener sucursales asignadas 
        $sucursales_asignadas = SucursalUnidad::find()->where(['unidad_negocio_id' => $id])->all();    

        

        return $this->render('asignar', [

            'unidad' => $unidad,
            'sucursales' => $sucursales_cliente,
            'asignadas' => $sucursales_asignadas,
               
        ]);
    }



    /**
     * Updates an existing UnidadNegocio model.
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
     * Deletes an existing UnidadNegocio model.
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
     * Finds the UnidadNegocio model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UnidadNegocio the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UnidadNegocio::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
