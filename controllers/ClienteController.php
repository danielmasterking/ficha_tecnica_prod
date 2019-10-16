<?php

namespace app\controllers;

use Yii;
use app\models\Cliente;
use app\models\ClienteSearch;
use app\models\UsuarioCliente;
use app\models\UsuarioSucursal;
use app\models\Sucursal;
use app\models\Contacto;
use app\models\UsuarioCiudad;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers;
use yii\helpers\Json;
use \yii\web\Response;

/**
 * ClienteController implements the CRUD actions for Cliente model.
 */
class ClienteController extends Controller
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


    public function actionListado(){

        $out = [];
        $nit = '3';
        if (isset($_POST['depdrop_parents'])) {

            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
              
                $nit = $parents[0];
                $usuario = Yii::$app->session['usuario'];
                $ciudades_usuario = UsuarioCiudad::find()->where(['usuario' => $usuario])->all();
                $sucursales_usuario = UsuarioSucursal::find()->where(['usuario' => $usuario])->all();
                $ciudades = array();
                $sucu = array();
                $sucursales = Sucursal::find()->where(['nit' => $nit,'estado' => 'A'])
                                              ->all(); 
                                             

                $data =  array();
                
                foreach ($ciudades_usuario as $key ) {
                    
                    $ciudades [] = $key->ciudad_id;                         
                }

                foreach ($sucursales_usuario as $key ) {
                    
                    $sucu [] = $key->sucursal_id;                         
                }

                $tamano_sucu = count($sucu);

                foreach ($sucursales as $key) {
                                      
                      if($tamano_sucu == 0){

                        if(in_array($key->ciudad_id, $ciudades)){
                          
                          $data [] = array('id' => $key->id, 'name' => $key->nombre);

                        }


                      }else{

                        if(in_array($key->id, $sucu)){
                          
                          $data [] = array('id' => $key->id, 'name' => $key->nombre);

                        }



                      }

                      
                }                         
                
                $value = (count($data) == 0) ? ['' => ''] : $data; 

                $out = $value; 
                
                echo Json::encode(['output'=> $out, 'selected'=>'']);
                return;
            }


        }

        echo Json::encode(['output'=>'', 'selected'=>'']);

    }

    public function actionListado3(){

        $out = [];
        $nit = '3';
        if ( isset($_POST['depdrop_parents']) ) {

            $parents = $_POST['depdrop_parents'];
            
            if ($parents != null) {
              
                $nit = $parents[0];
                $sucursales = Sucursal::find()->where(['nit' => $nit,'estado' => 'A'])->all();

                $data =  array();

                foreach ($sucursales as $key) {
                      
                      $data [] = array('id' => $key->id, 'name' => $key->nombre);
                      
                }                         
                
                $value = (count($data) == 0) ? ['' => ''] : $data; 

                $out = $value; 
                
                echo Json::encode(['output'=> $out, 'selected'=>'']);
                return;
            }


        }

        echo Json::encode(['output'=>'', 'selected'=>'']);

    }

    
    public function actionListado2(){

        $out = [];
        $id_sucursal = '';
        if (isset($_POST['depdrop_parents'])) {

            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                
              
                $id_sucursal = $parents[1];
                $usuario = Yii::$app->session['usuario'];
                $contactos = Contacto::find()->where(['sucursal_id' => $id_sucursal])->all();
                                                          
                $data =  array();
                $contacts = array();

                foreach ($contactos as $key) {
                         
                         
                    $data [] = array('id' => $key->nombres.' '.$key->apellidos, 'name' => $key->nombres.' '.$key->apellidos);                  
                                            
                }                         
                
                $value = (count($data) == 0) ? ['' => ''] : $data; 

                $out = $value; 
                
                echo Json::encode(['output'=> $out, 'selected'=>'']);
                return;
            }


        }

        echo Json::encode(['output'=>'', 'selected'=>'']);

    }


    
    /**
     * Lists all Cliente models.
     * @return mixed
     */
    public function actionIndex()
    {
        
        $usuario = Yii::$app->session['usuario'];
        $primaryConnection = Yii::$app->db;
        $primaryCommand = $primaryConnection->createCommand("SELECT nit
                                                             FROM usuario_cliente
                                                             WHERE usuario = :usuario
                                                             ");

        $clientes_asignados = UsuarioCliente::find()->where(['usuario' => $usuario])->all();

        /*$secondConnection =  Yii::$app->second_db; // Oasis --> SQL SERVER

        $command = $secondConnection->createCommand("SELECT  DISTINCT(bter_tercero.terv_codigo) AS CODIGO,
                                                             bter_tercero.terc_nit AS NIT,
                                                             bter_tercero.terc_direccion AS DIRECCION,
                                                             bter_tercero.terc_nombre AS NOMBRE,
                                                             FORMAT(bter_tercero.terf_ingreso, 'yyyy-MM-dd') AS FECHA_INICIO,
                                                             bter_tercero.terc_telefono AS TELEFONO,
                                                             bubg_ubicacion_geografica.ubgc_nombre AS CIUDAD
                                                        FROM  bter_tercero, bubg_ubicacion_geografica
                                                        WHERE bter_tercero.tern_ubicacion_geografica = bubg_ubicacion_geografica.ubgn_codigo
                                                        AND   bter_tercero.terc_cliente = 'S'
                                                        AND   bter_tercero.terc_estado = 'A'
                                                        ");

        $clientes_oasis = $command->queryAll();


        $clientes_oasis_array = array();
        $nits_oasis = array();
 
        foreach ($clientes_oasis as $key => $value) {
            
            $clientes_oasis_array [] = trim($value['NIT']).';'.$value['NOMBRE'].';'.$value['DIRECCION'].';'.$value['TELEFONO'].';'.$value['CIUDAD'].';'.$value['FECHA_INICIO'];
            $nits_oasis [] =  trim($value['NIT']);
        }

        $tamano_clientes_oasis = count($clientes_oasis_array);
        
        for($i = 0; $i < $tamano_clientes_oasis; $i++){

            $tmp = explode(';', $clientes_oasis_array[$i]);
            $tmp_cliente = null;
            $tmp_cliente = $this->findModel($tmp[0]);    

            
            
            if($tmp_cliente === null){
                
                $model = new Cliente();
 
                        $model->setAttribute('nit',$tmp[0]);
                        $model->setAttribute('nombre',$tmp[1]);
                        $model->setAttribute('direccion',$tmp[2]);
                        $model->setAttribute('telefono',$tmp[3]);
                        $model->setAttribute('ciudad',$tmp[4]);
                        $model->setAttribute('fecha_inicio',$tmp[5]);
                        $model->save();
           }else{

                  
                 $tmp_cliente = $this->findModel($tmp[0]);    

                if($tmp_cliente !== null){

                    
                    $tmp_cliente->setAttribute('nombre',$tmp[1]);
                    $tmp_cliente->setAttribute('direccion',$tmp[2]);
                    $tmp_cliente->setAttribute('telefono',$tmp[3]);
                    $tmp_cliente->setAttribute('ciudad',$tmp[4]);
                    $tmp_cliente->setAttribute('fecha_inicio',$tmp[5]);
                    $tmp_cliente->save();

                }                                  

            }

        }*/


        /*mostrar clientes del usuario si se quiere mostrar todos se deben de asignar todos*/

        

        $clientes = array();

        /*Si no es admin*/

        if($usuario != 'admin'){

          foreach ($clientes_asignados as $key ) {
            
            $clientes [] = $key->cliente;
          }
    
        }else{

            $clientes = Cliente::find()->all();
        }



        
        return $this->render('index', [

            'clientes' => $clientes,
           
                        
        ]);
         
    }

    /**
     * Displays a single Cliente model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionFactura($idf,$id){

        $secondConnection =  Yii::$app->second_db; // Oasis --> SQL SERVER

        $command = $secondConnection->createCommand("select CONVERT(INT,f.fcdv_cantidad) AS CANTIDAD,
                                                               FORMAT(f.fcdv_precio, 'C', 'en-us') AS PRECIO,
                                                               p.proc_nombre AS NOMBRE,
                                                               f.fcdt_observacion AS OBSERVACION 
                                                        from ffcd_factura_detalle f, bpro_producto p 
                                                        where f.fcdv_producto = p.prov_codigo 
                                                        and f.fcdn_numero = :factura
                                                       ");

        $facturas = $command->bindValue(':factura',$idf)->queryAll();


        return $this->render('factura', [
            
            'facturas' => $facturas,
            'nit' => $id,
            'fac' => $idf,
            
        ]);



    }
   
    public function actionFacturacion($id)
    {
        
        $array_post = Yii::$app->request->post();
        date_default_timezone_set ( 'America/Bogota');
        $fecha = date('Y-m-d',time());
        $ano = date('Y',time());        
        $fecha_anterior = strtotime('-5 month' , strtotime ( $fecha ));
        $ano_mes_fecha_anterior_date = date('Ym',$fecha_anterior);
        $fecha_anterior_date = date('Y-m-d',$fecha_anterior);
        $mes_anterior = date('m',$fecha_anterior);
        $ano_anterior = date('Y',$fecha_anterior);
        $meses = [];
        for($i = 1; $i <= 6; $i++){
           
           setlocale(LC_TIME, 'spanish');  
           $nombre=strftime("%B",mktime(0, 0, 0, $mes_anterior, 1, 2000)); 

           $meses[$ano_mes_fecha_anterior_date] = strtoupper( $nombre) .' - '.$ano_anterior;
           $fecha_anterior = strtotime('+1 month' , strtotime ( $fecha_anterior_date ));
           $ano_mes_fecha_anterior_date = date('Ym',$fecha_anterior);
           $fecha_anterior_date = date('Y-m-d',$fecha_anterior);
           $mes_anterior = date('m',$fecha_anterior);
           $ano_anterior = date('Y',$fecha_anterior);

        }


        $parametros_array = array();
        $parametros_array[':nit'] = $id;
        if(isset($array_post['consultar'])){
          
          

            if(array_key_exists('mes', $array_post) && $array_post['mes'] != ''){

               $sql = ' AND ffac_factura.facf_fecha BETWEEN :FECHA_1 AND DATEADD(day, 1, :FECHA_2)';
               $parametros_array[':FECHA_1'] = $array_post['mes'].'01';
               $parametros_array[':FECHA_2'] = $array_post['mes'].'29';
            
            }else{
                
               $sql = '';

            }

           

        }else{

          $sql = '';

        }




        $secondConnection =  Yii::$app->second_db; // Oasis --> SQL SERVER

        $command = $secondConnection->createCommand("SELECT ffac_factura.facc_documento AS DOCUMENTO,
                                                             ffac_factura.facn_numero AS NUMERO,   
                                                             FORMAT(ffac_factura.facf_fecha,'dd/MM/yyyy') AS FECHA,     
                                                             ffac_factura.facv_tercero AS CLIENTE,      
                                                             ffac_factura.facv_bruto AS VALOR_BRUTO,     
                                                             ffac_factura.facv_subtotal AS VALOR_SUBTOTAL,   
                                                             ffac_factura.facv_iva AS VALOR_IVA,   
                                                             FORMAT(ffac_factura.facv_total, 'C', 'en-us') AS VALOR_TOTAL,   
                                                             ffac_factura.facv_retencion AS VALOR_RETENCION,   
                                                             ffac_factura.facv_neto AS VALOR_NETO,      
                                                             ffac_factura.facc_observacion AS OBS,      
                                                             bter_tercero_a.terc_nombre AS CLIENTE_NOMBRE          
                                                        FROM ffac_factura,   
                                                             bter_tercero bter_tercero_a,   
                                                             bter_tercero y,   
                                                             bubi_ubicacion,   
                                                             bdoc_documento,   
                                                             bcon_concepto,   
                                                             bmot_motivo,   
                                                             bter_tercero bter_tercero_c,   
                                                             semp_empresa  
                                                       WHERE ( ffac_factura.facv_tercero = bter_tercero_a.terv_codigo ) and  
                                                             ( ffac_factura.facv_vendedor = y.terv_codigo ) and  
                                                             ( ffac_factura.facn_empresa = bubi_ubicacion.ubin_empresa ) and  
                                                             ( ffac_factura.facn_ubicacion = bubi_ubicacion.ubin_codigo ) and  
                                                             ( ffac_factura.facc_documento = bdoc_documento.docc_codigo ) and  
                                                             ( ffac_factura.facc_concepto = bcon_concepto.conc_codigo ) and  
                                                             ( ffac_factura.facc_documento = bcon_concepto.conc_documento ) and  
                                                             ( ffac_factura.facc_documento = bmot_motivo.motc_documento ) and  
                                                             ( ffac_factura.facc_concepto = bmot_motivo.motc_concepto ) and  
                                                             ( ffac_factura.facn_motivo = bmot_motivo.motn_codigo ) and  
                                                             ( ffac_factura.facv_facturador = bter_tercero_c.terv_codigo ) and  
                                                             ( ffac_factura.facn_empresa = semp_empresa.empn_codigo ) and  
                                                             ( ffac_factura.facn_empresa = 1 )   and
                                                             (ffac_factura.facv_tercero = :nit ) and
                                                             (ffac_factura.facc_estado = 'P') and 
                                                             (ffac_factura.facc_documento = 'FC')
                                                       ".$sql);

        $facturas = $command->bindValues($parametros_array)->queryAll();


        $clientes_oasis_array = array();
        $nits_oasis = array();
 


        return $this->render('facturacion', [
            'facturas' => $facturas,
            'nit' => $id,
            'meses' => $meses,
        ]);
    }
    /**
     * Creates a new Cliente model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Cliente();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Cliente model.
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

    /**
     * Deletes an existing Cliente model.
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
     * Finds the Cliente model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cliente the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cliente::findOne($id)) !== null) {
            return $model;
        } else {
            return null;
        }
    }
}
