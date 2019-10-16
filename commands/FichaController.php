<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;
use Yii;
use app\models\ReporteDiarioEnc;
use app\models\UsuarioRol;
use app\models\Usuario;
use app\models\UsuarioCliente;
use app\models\PermisoRol;
use app\models\Ciudad;
use app\models\Cliente;
use app\models\Sucursal;
use yii\console\Controller;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class FichaController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";
    }

    public function allowed($usuario){

        $usuario_model = UsuarioRol::find()->where(['usuario' => $usuario])->all();
        $permisos = array();

        foreach ($usuario_model as $key) {

            /*Obtener Permisos Rol*/
            $permiso_rol = PermisoRol::find()->where(['rol_id' => $key->rol_id])->all();

            foreach ($permiso_rol as $key2) {

                $permisos [] = strtolower( rtrim($key2->permiso->nombre) );

            }
        }


        return $permisos;


    }

    public function actionAsignarTodosLosClientes(){

        $clientes_totales = Cliente::find()->all();
        
        $primaryConnection = Yii::$app->db;
        $primaryCommand = $primaryConnection->createCommand("SELECT nit
                                                             FROM usuario_cliente
                                                             WHERE usuario = :usuario
                                                             ");

        $cont = 0;
        $usuarios_todos_clientes = Usuario::find()->where(['estado' => 'A','todos_clientes' => 'S'])->all();

        foreach ($usuarios_todos_clientes as $user) {


            foreach($clientes_totales as $key){
            
                 $sw = 0;
                 $clientes_asignados = UsuarioCliente::find()->where(['usuario' => $user->usuario])->all();

                 foreach ($clientes_asignados as $key2 ) {
                     
                     if($key->nit == $key2->nit){

                        $sw = 1;
                        break;
                     }
                 }

                 if($sw == 0){


                        $model = new UsuarioCliente();
                        $model->SetAttribute('nit',$key->nit);
                        $model->SetAttribute('usuario',$user->usuario);
                        $model->save();
                        $cont++;

                 }

            }            
            

        }

        echo $cont.' Registros insertados';
        


    }


    public function actionCrearReportesDiarios(){


            $primaryConnection = Yii::$app->db;

            $cont = 0;

            $secondCommand = $primaryConnection->createCommand("SELECT  usuario
                                                                 FROM   usuario
                                                                 WHERE tipo = 'E'
                                                                 AND   status = 'A'
                                                                  ");
            $thirdCommand = $primaryConnection->createCommand("SELECT  id
                                                                 FROM  estado
                                                                 WHERE tipo = 'R'
                                                                 AND   orden = 1
                                                                  ");
            $fourthCommand = $primaryConnection->createCommand("SELECT COUNT(*)
                                                                 FROM  reporte_diario_enc
                                                                 WHERE fecha = :fecha");                 


            date_default_timezone_set ( 'America/Bogota');
            $fecha = date('Y-m-d',time());
            $reportes = $fourthCommand->bindValue(':fecha',$fecha)->queryScalar();


            if($reportes === false || $reportes == 0){

                $estados = $thirdCommand->queryAll();
                $usuarios =  $secondCommand->queryAll();

                foreach ($usuarios as $key => $value) {

                     $permisos_usu = $this->allowed($value['usuario']);

                     if(in_array("reporte diario - escritura", $permisos_usu)){

                             $model_reporte = new ReporteDiarioEnc();
                             $model_reporte->SetAttribute('fecha',$fecha);
                             $model_reporte->SetAttribute('usuario',$value['usuario']);
                             $model_reporte->SetAttribute('estado_id',$estados[0]['id']);
                             $model_reporte->save();
                             $cont++;

                    }


                }


            }


            echo $cont.' Registros creados para fecha: '.$fecha;

    }
    
    /*Verificar reportes próximos a cerrar y que no podrán ser editados si no se realizan.*/
    public function actionRvencimiento(){

    	$primaryConnection = Yii::$app->db;

    	$secondCommand2 = $primaryConnection->createCommand("SELECT rde.id AS CODIGO, rde.fecha AS FECHA_REPORTE, rde.usuario AS USUARIO, u.email AS CORREO
                                                             FROM   reporte_diario_enc rde, usuario u, rol r, usuario_rol ur
                                                             WHERE rde.fecha = DATE_SUB(CURDATE(), INTERVAL 3 DAY )
                                                             AND   rde.usuario = u.usuario 
                                                             AND   u.usuario = ur.usuario
                                                             AND   ur.rol_id = r.id
                                                             AND   r.nombre LIKE '%coordinador%'
                                                             AND NOT EXISTS (
                                                             	                 select *
                                                             	                 from reporte_diario rd
                                                             	                 where rd.reporte_id = rde.id

                                                             	             )
                                                                  ");
         $vencimientos = $secondCommand2->queryAll();

         foreach ($vencimientos as $key => $value) {
         	
         	 Yii::$app->mailer->compose()
                    ->setFrom('nomina@cvsc.co')
                    ->setTo($value['CORREO'])
                    ->setSubject('Reporte diario próximo a cerrarse')
                    ->setTextBody('Plain text content')
                    ->setHtmlBody('<h2>Por favor revisar: </h2>
                                   El reporte diario correspondiente a la fecha '.$value['FECHA_REPORTE'].' cerrara el día de hoy a medianoche. Hasta la fecha usted no ha agregado las novedades correspondiente a este día. 
                                   ')
                    ->send();
         }


    }

    public function actionAgregacolviseg(){
        $primaryConnection = Yii::$app->db;
        $ciudadCommand = $primaryConnection->createCommand("SELECT id 
                                                             FROM  ciudad
                                                             WHERE cod_oasis = :cod_oasis

                                                             ");
        $secondConnection =  Yii::$app->second_db; // Oasis --> SQL SERVER
        $command = $secondConnection->createCommand("SELECT bdir_direccion.dirn_numero AS COD,
                                                                bdir_direccion.dirc_nombre AS NOMBRE,
                                                                bdir_direccion.dirc_direccion AS DIRECCION,
                                                                bdir_direccion.dirn_ubicacion_geografica AS COD_OASIS,
                                                                bdir_direccion.dirc_estado AS ESTADO
                                                            FROM bdir_direccion
                                                            WHERE bdir_direccion.dirn_numero%10 = 2
                                                            AND   bdir_direccion.dirn_numero != 122
                                                            AND   bdir_direccion.dirv_tercero = 800101613");

        $sucursales_oasis = $command->queryAll();

        foreach ($sucursales_oasis as $key => $value) {
                    
          $sucursales_oasis_array [] = $value['COD'].';'.$value['NOMBRE'].';'.$value['DIRECCION'].';'.$value['COD_OASIS'].';'.$value['ESTADO'];
        }

          $tamano_sucursales_oasis = count($sucursales_oasis_array);

           for($i = 1; $i < $tamano_sucursales_oasis; $i++){

               $tmp = explode(';', $sucursales_oasis_array[$i]);
               $suc_tmp = Sucursal::find()->where(['nit' => '800101613','cod_oasis' => $tmp[0]])->one();     
                    if($suc_tmp == null){

                        $clave =  $ciudadCommand->bindValue(':cod_oasis',$tmp[3])->queryOne();
                      //  $ids_sucursales_actuales [] = $clave;
                        
                        $model = new Sucursal();

                        $model_validator = Sucursal::find()->where(['nit' => '800101613','cod_oasis' => $tmp[0]])
                                                            ->one();

                        if($model_validator == null){

                            $model->setAttribute('nit','800101613');
                            $model->setAttribute('nombre',$tmp[1]);
                            $model->setAttribute('direccion',$tmp[2]);
                            $model->setAttribute('cod_oasis',$tmp[0]);
                            $model->setAttribute('ciudad_id',$clave['id']);
                            $model->save();

                        }
                        
                    }else{

                        $clave =  $ciudadCommand->bindValue(':cod_oasis',$tmp[3])->queryOne();
                        $model_validator = Sucursal::find()->where(['nit' => '800101613','cod_oasis' => $tmp[0]])
                                                            ->one();

                        if($model_validator != null){

                            $model_validator->setAttribute('nit','800101613');
                            $model_validator->setAttribute('nombre',$tmp[1]);
                            $model_validator->setAttribute('direccion',$tmp[2]);
                            $model_validator->setAttribute('cod_oasis',$tmp[0]);
                            $model_validator->setAttribute('estado',$tmp[4]);
                            $model_validator->setAttribute('ciudad_id',$clave['id']);
                            $model_validator->save();

                        }



                    }

                }

                

    }

    public function actionActualizaclientes(){

        $secondConnection =  Yii::$app->second_db; // Oasis --> SQL SERVER

        $command = $secondConnection->createCommand("SELECT  DISTINCT(bter_tercero.terv_codigo) AS CODIGO,
                                                             bter_tercero.terc_nit AS NIT,
                                                             bter_tercero.terc_direccion AS DIRECCION,
                                                             bter_tercero.terc_nombre AS NOMBRE,
                                                             FORMAT(bter_tercero.terf_ingreso, 'yyyy-MM-dd') AS FECHA_INICIO,
                                                             bter_tercero.terc_telefono AS TELEFONO,
                                                             bubg_ubicacion_geografica.ubgc_nombre AS CIUDAD,
                                                             bter_tercero.terc_estado AS ESTADO
                                                        FROM  bter_tercero, bubg_ubicacion_geografica
                                                        WHERE bter_tercero.tern_ubicacion_geografica = bubg_ubicacion_geografica.ubgn_codigo
                                                        AND   bter_tercero.terc_cliente = 'S'
                                                       
                                                        ");

        $clientes_oasis = $command->queryAll();
        $clientes_oasis_array = array();
        $nits_oasis = array();
 
        foreach ($clientes_oasis as $key => $value) {
            
            $clientes_oasis_array [] = trim($value['NIT']).';'.$value['NOMBRE'].';'.$value['DIRECCION'].';'.$value['TELEFONO'].';'.$value['CIUDAD'].';'.$value['FECHA_INICIO'].';'.$value['ESTADO'];
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
                 //** notificar a administrador Juan Delgado de la creación de un nuevo cliente
                    Yii::$app->mailer->compose()
                    ->setFrom('nomina@cvsc.co')
                    ->setTo('juandelgado@cvsc.com.co')
                    ->setSubject('Nuevo cliente Creado en Oasis')
                    ->setTextBody('Plain text content')
                    ->setHtmlBody('<h2>Por favor asignar cliente: </h2>
                                    '.$model->nombre.' creado recientemente al coordinador o persona correspondiente. 
                                   ')
                    ->send();       
           }else{

                  
                 $tmp_cliente = $this->findModel($tmp[0]);    

                if($tmp_cliente !== null){

                    
                    $tmp_cliente->setAttribute('nombre',$tmp[1]);
                    $tmp_cliente->setAttribute('direccion',$tmp[2]);
                    $tmp_cliente->setAttribute('telefono',$tmp[3]);
                    $tmp_cliente->setAttribute('ciudad',$tmp[4]);
                    $tmp_cliente->setAttribute('fecha_inicio',$tmp[5]);
                    $tmp_cliente->setAttribute('estado',$tmp[6]);
                    $tmp_cliente->save();

                }                                  

            }

        }
        

    }

    public function actionActualizasucursales(){

        $clientes_activos = Cliente::find()->where(['estado' => 'A'])->all();
        $primaryConnection = Yii::$app->db;
        $secondConnection =  Yii::$app->second_db; // Oasis --> SQL SERVER
        $primaryCommand = $primaryConnection->createCommand("SELECT id, cod_oasis 
                                                             FROM  sucursal
                                                             WHERE nit = :id
                                                             ");
        $ciudadCommand = $primaryConnection->createCommand("SELECT id 
                                                             FROM  ciudad
                                                             WHERE cod_oasis = :cod_oasis

                                                             ");

        foreach ($clientes_activos as $key2 ) {

            $sucursales_actuales = $primaryCommand->bindValue(':id',$key2->nit)->queryAll();
            $sucursales_actuales_array = array();
            $ids_sucursales_actuales = array();

            foreach ($sucursales_actuales as $key => $value) {
             
               $sucursales_actuales_array [] = $value['cod_oasis'];
            
            }

                //Validar si es exito u otro
                if($key2->nit == '890900608'){
					
					
					$command = $secondConnection->createCommand("SELECT bdir_direccion.dirn_numero AS COD,
												bdir_direccion.dirc_nombre AS NOMBRE,
												bdir_direccion.dirc_direccion AS DIRECCION,
												bdir_direccion.dirn_ubicacion_geografica AS COD_OASIS,
												bdir_direccion.dirc_estado AS ESTADO
											FROM bdir_direccion
											WHERE 
												  bdir_direccion.dirn_numero%20 = 0
											AND   bdir_direccion.dirv_tercero = :id");    




                }else{

					$command = $secondConnection->createCommand("SELECT bdir_direccion.dirn_numero AS COD,
								bdir_direccion.dirc_nombre AS NOMBRE,
								bdir_direccion.dirc_direccion AS DIRECCION,
								bdir_direccion.dirn_ubicacion_geografica AS COD_OASIS,
								bdir_direccion.dirc_estado AS ESTADO
							FROM bdir_direccion
							WHERE 
								  bdir_direccion.dirn_numero%20 = 0
							/*AND   bdir_direccion.dirn_numero < 4000*/
							AND   bdir_direccion.dirv_tercero = :id");


                }




               
                $sucursales_oasis = $command->bindValue(':id',$key2->nit)->queryAll();


                $sucursales_oasis_array = array();

                foreach ($sucursales_oasis as $key => $value) {
                    
                    $sucursales_oasis_array [] = $value['COD'].';'.$value['NOMBRE'].';'.$value['DIRECCION'].';'.$value['COD_OASIS'].';'.$value['ESTADO'];
                }

                $tamano_sucursales_oasis = count($sucursales_oasis_array);

                for($i = 1; $i < $tamano_sucursales_oasis; $i++){

                    $tmp = explode(';', $sucursales_oasis_array[$i]);
                    
                    if(!in_array($tmp[0], $sucursales_actuales_array)){

                        $clave =  $ciudadCommand->bindValue(':cod_oasis',$tmp[3])->queryOne();
                      //  $ids_sucursales_actuales [] = $clave;
                        
                        $model = new Sucursal();

                        $model_validator = Sucursal::find()->where(['nit' => $key2->nit,'cod_oasis' => $tmp[0]])
                                                            ->one();

                        if($model_validator == null){

                            $model->setAttribute('nit',$key2->nit);
                            $model->setAttribute('nombre',$tmp[1]);
                            $model->setAttribute('direccion',$tmp[2]);
                            $model->setAttribute('cod_oasis',$tmp[0]);
                            $model->setAttribute('ciudad_id',$clave['id']);
                            $model->save();
                             //** notificar a administrador Juan Delgado de la creación de un nuevo cliente
                           /* Yii::$app->mailer->compose()
                            ->setFrom('nomina@cvsc.co')
                            ->setTo('juandelgado@cvsc.com.co')
                            ->setSubject('Nueva Sucursal Creada en Oasis')
                            ->setTextBody('Plain text content')
                            ->setHtmlBody('<h2>Se ha creado la sucursal: </h2>
                                            '.$model->nombre.' para cliente con nit '.$model->nit.'. 
                                           ')
                            ->send(); */      

                        }
                        
                    }else{

                        $clave =  $ciudadCommand->bindValue(':cod_oasis',$tmp[3])->queryOne();
                        $model_validator = Sucursal::find()->where(['nit' => $key2->nit,'cod_oasis' => $tmp[0]])
                                                            ->one();

                        if($model_validator != null){

                            $model_validator->setAttribute('nit',$key2->nit);
                            $model_validator->setAttribute('nombre',$tmp[1]);
                            $model_validator->setAttribute('direccion',$tmp[2]);
                            $model_validator->setAttribute('cod_oasis',$tmp[0]);
                            $model_validator->setAttribute('estado',$tmp[4]);
                            $model_validator->setAttribute('ciudad_id',$clave['id']);
                            $model_validator->save();

                        }



                    }

                }
                

        }

       
    }

    /**
     * Finds the Cliente model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cliente the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
     function findModel($id)
    {
        if (($model = Cliente::findOne($id)) !== null) {
            return $model;
        } else {
            return null;
        }
    }
}
