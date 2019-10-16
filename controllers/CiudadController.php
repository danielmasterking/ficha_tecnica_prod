<?php

namespace app\controllers;

use Yii;
use app\models\Ciudad;
use app\models\CiudadSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CiudadController implements the CRUD actions for Ciudad model.
 */
class CiudadController extends Controller
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
     * Lists all Ciudad models.
     * @return mixed
     */
 public function actionIndex()
    {
        
        $primaryConnection = Yii::$app->db;
        $primaryCommand = $primaryConnection->createCommand("SELECT id, nombre, cod_oasis 
                                                             FROM ciudad
                                                             ");

        $ciudades_actuales = $primaryCommand->queryAll();

        $ciudades_actuales_array = array();

        foreach ($ciudades_actuales as $key => $value) {
            
            $ciudades_actuales_array [] = $value['nombre'];
        }
      
        $secondConnection =  Yii::$app->second_db; // Oasis --> SQL SERVER

        $command = $secondConnection->createCommand("SELECT DISTINCT(bubg_ubicacion_geografica.ubgn_codigo), 
                                                                     bubg_ubicacion_geografica.ubgc_nombre 
                                                                FROM  bubg_ubicacion_geografica, bdir_direccion
                                                                WHERE bubg_ubicacion_geografica.ubgn_codigo = bdir_direccion.dirn_ubicacion_geografica
                                                                and   bubg_ubicacion_geografica.ubgn_pais = 169
                                                                and   bubg_ubicacion_geografica.ubgn_nivel = 4
                                                                ORDER BY bubg_ubicacion_geografica.ubgc_nombre");

        $ubicaciones_oasis = $command->queryAll();


        $ubicaciones_oasis_array = array();

        foreach ($ubicaciones_oasis as $key => $value) {
            $temporal = explode('-', $value['ubgc_nombre']);
            $ciudad = $temporal[0];
            $codigo_oasis [] = $value['ubgn_codigo'];
            $ubicaciones_oasis_array [] = $ciudad ;
        }

        $tamano_ubicaciones_oasis = count($ubicaciones_oasis_array);

        for($i = 0; $i < $tamano_ubicaciones_oasis; $i++){
            
            if(!in_array($ubicaciones_oasis_array[$i], $ciudades_actuales_array)){
                
                $model = new Ciudad();
                $model->setAttribute('nombre',$ubicaciones_oasis_array[$i]);
                $model->setAttribute('cod_oasis',$codigo_oasis[$i]);
                $model->save();

            }

        }


        $ciudades = Ciudad::find()->asArray()->all();

        return $this->render('index', [
            'ciudades' => $ciudades,
            
            
        ]);
    }


    /**
     * Displays a single Ciudad model.
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
     * Creates a new Ciudad model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Ciudad();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Ciudad model.
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
     * Deletes an existing Ciudad model.
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
     * Finds the Ciudad model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ciudad the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ciudad::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
