<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;
use Yii;
use app\models\ReporteDiarioEnc;
use app\models\ReporteDiario;
use app\models\Visita;
use app\models\Vtecnica;
use app\models\Usuario;
use yii\console\Controller;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class KontrolidController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionSincronizarApp($message = 'hello world')
    {
        
        $last_key = ReporteDiario::find()->max('app_id');
        $curl2 = curl_init();
        curl_setopt_array($curl2, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 1,
            //CURLOPT_VERBOSE        => 1,
            //CURLOPT_POST => 1,
            CURLOPT_URL => 'https://app.kontrolid.com/api/v1/data/2629?start='.$last_key,
            CURLOPT_USERPWD => 'colviseg:colviseg7',
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_SSL_VERIFYPEER => false
            
        ));

        $response = curl_exec($curl2);

        curl_close($curl2);
        //var_dump($response);

        $respuesta = json_decode($response);

        date_default_timezone_set ( 'America/Bogota');

        $fecha_actual = date('Y-m-d',time());
        //$fecha_actual = '2017-07-21';
        $timestamp_cargue = strtotime('-1 day' , strtotime ( $fecha_actual )); 
        $contador = 0;

        foreach ($respuesta as $value) {

              $fecha_temp;

              if (($timestamp = strtotime($value->HoraLocal)) !== false) {

                $fecha_temp = date('Y-m-d H:i', $timestamp);
                 
              }        

               $fecha_fin_array = explode(' ', $fecha_temp);

               //pos 0 fecha
               //pos 1 hora
               
               //echo $value->horalocal.'\n';

               //if($fecha_fin_array[0] == $fecha_actual){

             //if(strtotime($fecha_fin_array[0]) >= $timestamp_cargue){

                  //verificar si ya se insertó la sincronización.
                  $novedad = null;
                  $novedad = ReporteDiario::find()->where(['app_id' => $value->prikey])->one();

                  $usuario = Usuario::find()->where(['email' => $value->Usuario])->one();

                   
                  //Si no existe novedad previamente
                  if($novedad == null && $usuario != null){

                   
                    //Se debe insertar novedad y se obtiene id del encabezado del día para el usuario
                    $id_reporte = '';
                   
                    $id_reporte = ReporteDiarioEnc::find()->where(['usuario' => $usuario->usuario,'fecha' => $fecha_fin_array[0] ])->one(); 
                    
                    $hora = $fecha_fin_array[1];

                    
                    if($id_reporte != null && $value->CodSuc != null && $value->CodSuc != ''){

                        $modelo_novedad = new ReporteDiario();

                        $modelo_novedad->setAttribute('reporte_id',$id_reporte->id);
                        $modelo_novedad->setAttribute('sucursal_id',$value->CodSuc);
                        $modelo_novedad->setAttribute('fecha_registro',$fecha_fin_array[0]);
                        $modelo_novedad->setAttribute('novedad_id',$value->Novedad);
                        $modelo_novedad->setAttribute('archivo',$value->Foto);
                        $modelo_novedad->setAttribute('observacion',$value->Comentarios);
                        $modelo_novedad->setAttribute('estado_id',5);
                        $modelo_novedad->setAttribute('app_id',$value->prikey);
                        $modelo_novedad->setAttribute('hora',$hora);

                        $modelo_novedad->save();
                        $contador++;
                        


                    }


                  }


             //  }//Fin si fecha cargue.
               
               
           }   



             echo $contador.' Registros insertados';
        
    }//Fin proceso actualizar reportes diarios con la app.


    public function actionSincronizarVisitasTecnicasApp($message = 'hello world')
    {
        
        $last_key = Visita::find()->max('app_id');
        $curl2 = curl_init();
        curl_setopt_array($curl2, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 1,
            //CURLOPT_VERBOSE        => 1,
            //CURLOPT_POST => 1,
            CURLOPT_URL => 'https://app.kontrolid.com/api/v1/data/2631?start='.$last_key,
            CURLOPT_USERPWD => 'colviseg:colviseg7',
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_SSL_VERIFYPEER => false
            
        ));

        $response = curl_exec($curl2);

        curl_close($curl2);
        //var_dump($response);

        $respuesta = json_decode($response);

        date_default_timezone_set ( 'America/Bogota');

        $fecha_actual = date('Y-m-d',time());
        //$fecha_actual = '2017-07-21';
        $timestamp_cargue = strtotime('-1 day' , strtotime ( $fecha_actual )); 
        $contador = 0;

        foreach ($respuesta as $value) {

              $fecha_temp;



              if (($timestamp = strtotime($value->HoraLocal)) !== false) {

                $fecha_temp = date('Y-m-d H:i', $timestamp);
                 
              }        

               $fecha_fin_array = explode(' ', $fecha_temp);

               //pos 0 fecha
               //pos 1 hora
               
               //echo $value->horalocal.'\n';

               //if($fecha_fin_array[0] == $fecha_actual){

             //if(strtotime($fecha_fin_array[0]) >= $timestamp_cargue){

                  //verificar si ya se insertó la sincronización.
                  $novedad = null;
                  $novedad = Visita::find()->where(['app_id' => $value->prikey])->one();

                  $usuario = Usuario::find()->where(['email' => $value->Usuario])->one();

                   
                  //Si no existe novedad previamente
                  if($novedad == null && $usuario != null){

                   
                    //Se debe insertar novedad y se obtiene id del encabezado del día para el usuario                    
                    $hora = $fecha_fin_array[1];

                    
                    if($value->CodSuc != null && $value->CodSuc != ''){

                        $modelo_novedad = new Visita();

                        $comentarios = ($value->Comentarios == null || $value->Comentarios == '') ?  'X' : $value->Comentarios;


                        $recomendaciones = ($value->Recomendaciones == null || $value->Recomendaciones == '') ?  'X' : $value->Recomendaciones; 

                        $modelo_novedad->setAttribute('novedad_id',37);
                        $modelo_novedad->setAttribute('sucursal_id',$value->CodSuc);
                        $modelo_novedad->setAttribute('fecha',$fecha_fin_array[0]);
                        $modelo_novedad->setAttribute('comentarios',$comentarios);
                        $modelo_novedad->setAttribute('recomendaciones',$recomendaciones);
                        $modelo_novedad->setAttribute('estado_id',4);
                        $modelo_novedad->setAttribute('reporta',$usuario->usuario);
                        $modelo_novedad->setAttribute('email_reportante',$usuario->email);
                        $modelo_novedad->setAttribute('usuario',$usuario->usuario);
                        $modelo_novedad->setAttribute('autor',$usuario->usuario);
                        $modelo_novedad->setAttribute('firma_coord',$value->FirmaCoordinador);
                        $modelo_novedad->setAttribute('firma_recibe',$value->FirmaRecibe);
                        $modelo_novedad->setAttribute('vigilante',$value->Vigilante);
                        $modelo_novedad->setAttribute('cargo',$value->Cargo);
                        $modelo_novedad->setAttribute('contacto',$value->Contacto);
                        $modelo_novedad->setAttribute('app_id',$value->prikey);
                        $modelo_novedad->setAttribute('compromiso_cliente','X');
                        $modelo_novedad->setAttribute('compromiso_colviseg','X');
                        $modelo_novedad->save();


                        if($modelo_novedad->save()){
                          
                          $contador++;

                          //última visita insertada.
                          $visita_id = Visita::find()->max('id');
                          $model_vtecnica = new Vtecnica();
                          $model_vtecnica->setAttribute('visita_id', $visita_id);
                          $model_vtecnica->setAttribute('app_id', $value->prikey);

                          $dotacion = strtoupper( substr( $value->Dotacion, 0 , 1 ) );
                          $model_vtecnica->setAttribute('presentacion', $dotacion);

                          $iluminacion = strtoupper( substr( $value->Iluminacion, 0 , 1 ) );
                          $model_vtecnica->setAttribute('iluminacion', $iluminacion);

                          $accesos = strtoupper( substr( $value->Accesos, 0 , 1 ) );
                          $model_vtecnica->setAttribute('acceso', $accesos);   

                          $perimetral = strtoupper( substr( $value->Perimetral, 0 , 1 ) );
                          $model_vtecnica->setAttribute('perimetro', $perimetral);

                          $cerraduras = strtoupper( substr( $value->Cerraduras, 0 , 1 ) );
                          $model_vtecnica->setAttribute('cerraduras', $cerraduras);

                          $generales = strtoupper( substr( $value->Generales, 0 , 1 ) );
                          $model_vtecnica->setAttribute('consigna_general', $generales); 

                          $particulares = strtoupper( substr( $value->Particulares, 0 , 1 ) );
                          $model_vtecnica->setAttribute('consigna_particular', $particulares);                           

                          $alarmas = strtoupper( substr( $value->Alarmas, 0 , 1 ) );
                          $model_vtecnica->setAttribute('alarmas', $alarmas); 

                          $instrucciones_especificas = strtoupper( substr( $value->Especificas, 0 , 1 ) );
                          $model_vtecnica->setAttribute('instrucciones', $instrucciones_especificas);                           


                          $cctv = strtoupper( substr( $value->CCTV, 0 , 1 ) );
                          $model_vtecnica->setAttribute('cctv', $cctv);                           


                          $model_vtecnica->save();

                                              $id_reporte = ReporteDiarioEnc::find()->where(['usuario' => $usuario->usuario,'fecha' => $fecha_fin_array[0] ])->one(); 


                          //Guardar Novedad de visita técnica en reporte diario
                           if($id_reporte != null){

                               $model3 = new ReporteDiario();
                               $model3->setAttribute('sucursal_id',$modelo_novedad->sucursal_id);
                               $model3->setAttribute('reporte_id',$id_reporte->id);
                               $model3->setAttribute('novedad_id',1);
                               $model3->setAttribute('estado_id',5);
                               $model3->setAttribute('observacion','Agregada automáticamente');
                               $model3->setAttribute('fecha_registro',$modelo_novedad->fecha);
                               $model3->setAttribute('hora','12:00 AM');
                               $model3->setAttribute('app_id_cap',0);
                               $model3->save(); 
                            }
                                                 



                        }

                        
                        

                        //
                        


                    }


                  }


             //  }//Fin si fecha cargue.
               
               
           }   



             echo $contador.' Registros insertados';
        
    }//Fin proceso actualizar visitas técnicas con la app.    

    public function actionSincronizarCapacitacionesApp($message = 'hello world')
    {
      

        $last_key = ReporteDiario::find()->max('app_id_cap');
        $curl2 = curl_init();
        curl_setopt_array($curl2, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 1,
            //CURLOPT_VERBOSE        => 1,
            //CURLOPT_POST => 1,
            CURLOPT_URL => 'https://app.kontrolid.com/api/v1/data/2641?start='.$last_key,
            CURLOPT_USERPWD => 'colviseg:colviseg7',
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_SSL_VERIFYPEER => false
            
        ));

        $response = curl_exec($curl2);

        curl_close($curl2);
        //var_dump($response);

        $respuesta = json_decode($response);

        date_default_timezone_set ( 'America/Bogota');

        $fecha_actual = date('Y-m-d',time());
        //$fecha_actual = '2017-07-21';
        $timestamp_cargue = strtotime('-1 day' , strtotime ( $fecha_actual )); 
        $contador = 0;

        foreach ($respuesta as $value) {

              $fecha_temp;


              if (($timestamp = strtotime($value->HoraLocal)) !== false) {

                $fecha_temp = date('Y-m-d H:i', $timestamp);
                 
              }        

               $fecha_fin_array = explode(' ', $fecha_temp);

               //pos 0 fecha
               //pos 1 hora
               
               //echo $value->horalocal.'\n';

               //if($fecha_fin_array[0] == $fecha_actual){

             //if(strtotime($fecha_fin_array[0]) >= $timestamp_cargue){

                  //verificar si ya se insertó la sincronización.
                  $novedad = null;
                  $novedad = ReporteDiario::find()->where(['app_id_cap' => $value->prikey])->one();

                  $usuario = Usuario::find()->where(['email' => $value->Usuario])->one();

                   
                  //Si no existe novedad previamente
                  if($novedad == null && $usuario != null){

                    //$id_reporte = '';
                   
                    $id_reporte = ReporteDiarioEnc::find()->where(['usuario' => $usuario->usuario,'fecha' => $fecha_fin_array[0] ])->one(); 


                   
                    //Se debe insertar novedad y se obtiene id del encabezado del día para el usuario                    
                    $hora = $fecha_fin_array[1];

                    
                    if( $id_reporte != null && ($value->CodSuc != null && $value->CodSuc != '') ){

                       $modelo_novedad = new ReporteDiario();

                        $motivo = '<h3>Motivo</h3><h4>'.$value->Motivo.'</h4>';
                        $objetivo = '<h3>Objetivo</h3><h4>'.$value->Objetivo.'</h4>';
                        $lugar = '<h3>Lugar</h3><h4>'.$value->Lugar.'</h4>';
                        $instructor = '<h3>Instructor</h3><h4>'.$value->Instructor.'</h4>';
                        $observaciones = '<h3>Observaciones</h3><p>'.$value->Observaciones.'</p>';
                        $recomendaciones = '<h3>Recomendaciones</h3><p>'.$value->Recomendaciones.'</p>';
                        $compromisos = '<h3>Compromisos</h3><p>'.$value->Compromisos.'</p>';

                        $texto = $motivo.$objetivo.$lugar.$instructor.$observaciones.$recomendaciones.$compromisos;


                        $modelo_novedad->setAttribute('novedad_id',17);
                        $modelo_novedad->setAttribute('sucursal_id',$value->CodSuc);
                        $modelo_novedad->setAttribute('fecha_registro',$fecha_fin_array[0]);
                        $modelo_novedad->setAttribute('estado_id',5);
                        $modelo_novedad->setAttribute('reporte_id',$id_reporte->id);
                        $modelo_novedad->setAttribute('hora',$hora);
                        $modelo_novedad->setAttribute('app_id_cap',$value->prikey);
                        $modelo_novedad->setAttribute('archivo',$value->Foto1);
                        $modelo_novedad->setAttribute('observacion',$texto);
                        $modelo_novedad->save();


                        if($modelo_novedad->save()){
                          
                          $contador++;

                        }

                        //

                    }


                  }


             //  }//Fin si fecha cargue.
               
               
           }   



             echo $contador.' Registros insertados';
        
    }//Fin proceso actualizar capacitaciones técnicas con la app.     

    public function actionSincronizarVisitasClienteApp($message = 'hello world')
    {
        
        $last_key = ReporteDiario::find()->max('app_id_visita_cliente');
        $curl2 = curl_init();
        curl_setopt_array($curl2, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 1,
            //CURLOPT_VERBOSE        => 1,
            //CURLOPT_POST => 1,
            CURLOPT_URL => 'https://app.kontrolid.com/api/v1/data/2632?start='.$last_key,
            CURLOPT_USERPWD => 'colviseg:colviseg7',
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_SSL_VERIFYPEER => false
            
        ));

        $response = curl_exec($curl2);

        curl_close($curl2);
        //var_dump($response);

        $respuesta = json_decode($response);

        date_default_timezone_set ( 'America/Bogota');

        $fecha_actual = date('Y-m-d',time());
        //$fecha_actual = '2017-07-21';
        $timestamp_cargue = strtotime('-1 day' , strtotime ( $fecha_actual )); 
        $contador = 0;

        foreach ($respuesta as $value) {

              $fecha_temp;


              if (($timestamp = strtotime($value->HoraLocal)) !== false) {

                $fecha_temp = date('Y-m-d H:i', $timestamp);
                 
              }        

               $fecha_fin_array = explode(' ', $fecha_temp);

               //pos 0 fecha
               //pos 1 hora
               
               //echo $value->horalocal.'\n';

               //if($fecha_fin_array[0] == $fecha_actual){

             //if(strtotime($fecha_fin_array[0]) >= $timestamp_cargue){

                  //verificar si ya se insertó la sincronización.
                  $novedad = null;
                  $novedad = ReporteDiario::find()->where(['app_id_visita_cliente' => $value->prikey])->one();

                  $usuario = Usuario::find()->where(['email' => $value->Usuario])->one();

                   
                  //Si no existe novedad previamente
                  if($novedad == null && $usuario != null){

                    //$id_reporte = '';
                   
                    $id_reporte = ReporteDiarioEnc::find()->where(['usuario' => $usuario->usuario,'fecha' => $fecha_fin_array[0] ])->one(); 


                   
                    //Se debe insertar novedad y se obtiene id del encabezado del día para el usuario                    
                    $hora = $fecha_fin_array[1];

                    
                    if( $id_reporte != null && ($value->CodSuc != null && $value->CodSuc != '') ){

                       $modelo_novedad = new ReporteDiario();

                        $contacto = '<h3>Contacto</h3><h4>'.$value->Contacto.'</h4>';
                        $comentarios = '<h3>Comentarios</h3><p>'.$value->Comentarios.'</p>';
                        $recomendaciones = '<h3>Recomendaciones</h3><p>'.$value->Recomendaciones.'</p>';
                      

                        $texto = $contacto.$comentarios.$recomendaciones;


                        $modelo_novedad->setAttribute('novedad_id',18);
                        $modelo_novedad->setAttribute('sucursal_id',$value->CodSuc);
                        $modelo_novedad->setAttribute('fecha_registro',$fecha_fin_array[0]);
                        $modelo_novedad->setAttribute('estado_id',5);
                        $modelo_novedad->setAttribute('reporte_id',$id_reporte->id);
                        $modelo_novedad->setAttribute('hora',$hora);
                        $modelo_novedad->setAttribute('app_id_visita_cliente',$value->prikey);
                        $modelo_novedad->setAttribute('app_id_cap',0);
                        $modelo_novedad->setAttribute('archivo',$value->FirmaRecibe);
                        $modelo_novedad->setAttribute('observacion',$texto);
                        $modelo_novedad->save();


                        if($modelo_novedad->save()){
                          
                          $contador++;

                        }

                        //

                    }


                  }


             //  }//Fin si fecha cargue.
               
               
           }   



             echo $contador.' Registros insertados';
        
    }//Fin proceso actualizar novedades visitas clientes en reporte diario con la app.    

}
