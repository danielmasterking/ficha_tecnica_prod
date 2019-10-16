<?php

namespace app\controllers;

use Yii;
use app\models\Arma;
use app\models\Novedad;
use app\models\Calibre;
use app\models\TipoArma;
use app\models\PermisoArma;
use app\models\HistoricoArma;
use app\models\ArmaSearch;
use app\models\Cliente;
use app\models\ArmaSucursal;
use yii\web\UploadedFile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;

/**
 * ArmaController implements the CRUD actions for Arma model.
 */
class ArmaController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Arma models.
     * @return mixed
     */
    public function actionIndex()
    {
        $armas = Arma::find()->all();


        return $this->render('index', [
            'armas' => $armas,

        ]);
    }

    /**
     * Displays a single Arma model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        $novedades = Novedad::find()->where(['tipo' => 'A'])
                                    ->orderBy(['nombre' => SORT_ASC])
                                    ->all();  
        $usuario = Yii::$app->session['usuario'];                         

        $historico_model = new HistoricoArma();

        $arma_model = $this->findModel($id);

        $arma_sucursal = ArmaSucursal::find()->where(['arma_id' => $id])->one();

        
        if ( $historico_model->load(Yii::$app->request->post()) && $historico_model->save() ) {
           

             /*Sumar un día a fecha de visita técnica*/
              $fecha_real_novedad = strtotime('+1 day' , strtotime ( $historico_model->fecha ));
              $fecha_real_novedad = date('Y-m-d',$fecha_real_novedad);
              $historico_model->setAttribute('fecha',$fecha_real_novedad);
              $historico_model->save();

        }



        $historico = HistoricoArma::find()->where(['arma_id' => $id])
                                          ->orderBy(['fecha' => SORT_DESC])
                                          ->all();
                                                                
        return $this->render('view', [
            'model' => $this->findModel($id),
            'historico' => $historico,
            'arma' => $id,
            'novedades' => $novedades,
            'historico_model' => $historico_model,
            'usuario' => $usuario,
            'arma_sucursal' => $arma_sucursal,
            'arma_model' => $arma_model,

        ]);
    }

    public function actionTrasladar(){

      $clientes = Cliente::find()->orderBy(['nombre' => SORT_ASC])->all();
      $armas = Arma::find()->orderBy(['serie' => SORT_ASC])->all();
      $arma_sucursal = new ArmaSucursal();

      $array_post = Yii::$app->request->post();
      if ( $arma_sucursal->load(Yii::$app->request->post()) ) {

          $existe_arma_sucursal = ArmaSucursal::find()->where(['arma_id'  => $array_post['ArmaSucursal']['arma_id'] ])->one();

          //VarDumper::dump($existe_arma_sucursal);

          if($existe_arma_sucursal == null){

             if($arma_sucursal->save()){

               return $this->render('trasladar',['message' => '200',   'model' => $arma_sucursal,
                     'armas' => $armas,
                     'clientes' => $clientes,]);


             }

         }else{
           $existe_arma_sucursal->setAttribute('sucursal_id',$arma_sucursal->sucursal_id);
           $existe_arma_sucursal->save();

              return $this->render('trasladar',['message' => '200',   'model' => $arma_sucursal,
                 'armas' => $armas,
                 'clientes' => $clientes,]);

         }



     }else{

       return $this->render('trasladar', [
           'model' => $arma_sucursal,
           'armas' => $armas,
           'clientes' => $clientes,
       ]);

     }


    }

    /**
     * Creates a new Arma model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Arma();
        $tipos = TipoArma::find()->all();
        $permisosArmas = PermisoArma::find()->all();
        $calibres = Calibre::find()->all();
        Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/';
        $shortPath = '/uploads/';

        if ( $model->load(Yii::$app->request->post()) ) {

            $image = UploadedFile::getInstance($model, 'image2');
            if($image !== null)
            {
                $model->archivo = $image->name;
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
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'tipos' => $tipos,
                'calibres' => $calibres,
                'permisosArmas' => $permisosArmas,
            ]);
        }
    }

    /**
     * Updates an existing Arma model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $tipos = TipoArma::find()->all();
        $permisosArmas = PermisoArma::find()->all();
        $calibres = Calibre::find()->all();
        Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/';
        $shortPath = '/uploads/';


        if ($model->load(Yii::$app->request->post())) {
           $image = UploadedFile::getInstance($model, 'image2');
            if($image !== null)
            {
                $model->archivo = $image->name;
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

            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'tipos' => $tipos,
                'calibres' => $calibres,
                'permisosArmas' => $permisosArmas,
            ]);
        }
    }

    /**
     * Deletes an existing Arma model.
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
     * Finds the Arma model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Arma the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Arma::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
