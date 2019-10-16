<?php

namespace app\controllers;
use Yii;
use app\models\Preaviso;
use app\models\PreavisoSearch;
use app\models\UsuarioCiudad;
use app\models\UsuarioCiudadSearch;
use yii\web\Controller;
use kartik\mpdf\Pdf;

class PreavisoController extends Controller
{
    public function actionIndex()
    {
      
      $user = isset(Yii::$app->session['usuario']) ? Yii::$app->session['usuario'] : ''; 
      
      $ciudades_actuales = UsuarioCiudad::find()->where(['usuario' => $user])->all();;

      $array_post = Yii::$app->request->post(); // almacenar variables POST
      // validar si existen empleados seleccionados a preavisar
      
      //validar numero de días
      $dias = array_key_exists('dias', $array_post) && $array_post['dias'] != '' ? $array_post['dias'] : 45;
      $ciudad = array_key_exists('ciudad', $array_post)  ? $array_post['ciudad'] : 'xx';
     
      

      $sql = '';

      if(isset($array_post['cedula'])){


        if($array_post['cedula'] != ''){

          $cedula = $array_post['cedula'];
          $sql = ' AND   bter_tercero.terv_codigo = :cedula';

        }elseif(isset($array_post['empleado'])){

            if($array_post['empleado'] != ''){

              
              $sql = ' empleado';

            }

          }


      }elseif(isset($array_post['empleado'])){

        if($array_post['empleado'] != ''){

          
          $sql = ' empleado';

        }

      }



      
      $primaryConnection = Yii::$app->db;
      $primaryCommand = $primaryConnection->createCommand("SELECT COUNT(*) 
                                                             FROM preaviso
                                                             WHERE cedula = :cedula
                                                             AND   fecha >= DATE_SUB(NOW(), INTERVAL 30 DAY) ");
      $secondConnection =  Yii::$app->second_db; // Oasis --> SQL SERVER

      $command = $secondConnection->createCommand("SELECT bter_tercero.terc_nombre,
                                                          bter_tercero.terv_codigo,
                                                          bter_tercero.terc_nit,
                                                          FORMAT(bter_tercero.terf_contrato,'dd/MM/yyyy') as terf_contrato,
                                                          bubi_ubicacion.ubic_nombre
                                                       FROM      bter_tercero, bubi_ubicacion
                                                       WHERE     bter_tercero.tern_ubicacion = bubi_ubicacion.ubin_codigo
                                                        AND      bter_tercero.terc_empleado = 'S'
                                                        AND      bter_tercero.terc_estado_empleado = 'A'
                                                        AND      bter_tercero.tern_empresa = 1
                                                        AND      bter_tercero.terf_contrato >= getdate()
                                                        AND      bter_tercero.terf_contrato <= DATEADD(day,:dias,getdate())
                                                        AND      bubi_ubicacion.ubic_nombre LIKE :ciudades
                                                      ORDER BY   bter_tercero.terf_contrato ASC,  
                                                                 bubi_ubicacion.ubic_nombre ASC ");

    $command2 = $secondConnection->createCommand("SELECT bter_tercero.terc_nombre,
                                                          bter_tercero.terv_codigo,
                                                          bter_tercero.terc_nit,
                                                          FORMAT(bter_tercero.terf_contrato,'dd/MM/yyyy') as terf_contrato,
                                                          bubi_ubicacion.ubic_nombre
                                                       FROM      bter_tercero, bubi_ubicacion
                                                       WHERE     bter_tercero.tern_ubicacion = bubi_ubicacion.ubin_codigo
                                                        AND      bter_tercero.terc_empleado = 'S'
                                                        AND      bter_tercero.terc_estado_empleado = 'A'
                                                        AND      bter_tercero.tern_empresa = 1
                                                        AND      bter_tercero.terv_codigo = :codigo
                                                      ORDER BY   bter_tercero.terf_contrato ASC,  
                                                                 bubi_ubicacion.ubic_nombre ASC ");

      
      $secondCommand = $secondConnection->createCommand("SELECT bter_tercero.terc_nombre,
                                                          bter_tercero.terv_codigo,
                                                          bter_tercero.terc_nit,
                                                          FORMAT(bter_tercero.terf_contrato,'dd/MM/yyyy') as terf_contrato,
                                                          bubi_ubicacion.ubic_nombre
                                                       FROM      bter_tercero, bubi_ubicacion
                                                       WHERE     bter_tercero.tern_ubicacion = bubi_ubicacion.ubin_codigo
                                                        AND      bter_tercero.terc_empleado = 'S'
                                                        AND      bter_tercero.terc_estado_empleado = 'A'
                                                        AND      bter_tercero.tern_empresa = 1
                                                        AND      bter_tercero.terv_codigo = :cedula
                                                      ORDER BY   bter_tercero.terf_contrato ASC,  
                                                                 bubi_ubicacion.ubic_nombre ASC ");

$otroCommand = $secondConnection->createCommand("SELECT   bter_tercero.terc_nombre,
                                                          bter_tercero.terv_codigo,
                                                          bter_tercero.terc_nit,
                                                          FORMAT(bter_tercero.terf_contrato,'dd/MM/yyyy') as terf_contrato,
                                                          bubi_ubicacion.ubic_nombre
                                                       FROM      bter_tercero, bubi_ubicacion
                                                       WHERE     bter_tercero.tern_ubicacion = bubi_ubicacion.ubin_codigo
                                                        AND      bter_tercero.terc_empleado = 'S'
                                                        AND      bter_tercero.terc_estado_empleado = 'A'
                                                        AND      bter_tercero.tern_empresa = 1
                                                      ORDER BY   bter_tercero.terf_contrato ASC,  
                                                                 bubi_ubicacion.ubic_nombre ASC ");

$empleados = $otroCommand->queryAll(); 
               
              if(!isset($array_post['generar'])){

                 Yii::$app->session['ciudad'] = $ciudad;
                /*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
                    if($sql === ''){

                        $preavisos = $command->bindValues([':dias' => intval($dias),
                                                           ':ciudades' => '%'.$ciudad.'%' ])->queryAll(); // obtener resultados

                    }elseif(strpos($sql, "cedula") !== false){

                      Yii::$app->session['ced'] = $cedula;
                      
                      $preavisos = $secondCommand->bindValue(':cedula',$cedula
                                                             )->queryAll(); // obtener resultados


                    }else{

                      $preavisos = $command2->bindValue(':codigo', $array_post['empleado']
                                                         )->queryAll(); 


                    } 

              /*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/




              }  




      
      /*Obtener Fecha*/
        $fecha = date("F j   Y");
         
        if(strpos($fecha, 'January') !== false);
        {
          $fecha = str_replace('January', 'Enero', $fecha);

        }

        if (strpos($fecha, 'February') !== false ) {

          $fecha = str_replace('February', 'Febrero', $fecha);
        }

         if (strpos($fecha, 'March') !== false ) {

           $fecha = str_replace('March', 'Marzo', $fecha);

        }

         if (strpos($fecha, 'April') !== false ) {

           $fecha = str_replace('April', 'Abril', $fecha);
        }

         if (strpos($fecha, 'May') !== false ) {

           $fecha = str_replace('May', 'Mayo', $fecha);

        }

         if (strpos($fecha, 'June') !== false ) {

           $fecha = str_replace('June', 'Junio', $fecha);

        }

         if (strpos($fecha, 'August') !== false ) {

           $fecha = str_replace('August', 'Agosto', $fecha);

        }

         if (strpos($fecha, 'September') !== false ) {

           $fecha = str_replace('September', 'Septiembre', $fecha);

        }

         if (strpos($fecha, 'October') !== false ) {

           $fecha = str_replace('October', 'Octubre', $fecha);

        }

         if (strpos($fecha, 'November') !== false ) {

            $fecha =str_replace('November', 'Noviembre', $fecha);

        }

        if(strpos($fecha, 'December') !== false ){

            $fecha = str_replace('December', 'Diciembre', $fecha);

        }
        
        $nits = array_key_exists('nits', $array_post) ? $array_post['nits'] : array();
        
        // cantidad de seleccionados
        $tamano = count($nits);
        $index = 0;
        $fecha_actual = date('Y-m-d',time());
        $datos_carta = array(); // almacenar datos a usar en la carta temporalmente
        $flag = array();
        $numero_de_cartas = 0;
        
        if(isset($array_post['generar']) && $tamano == 1){
          
          $ced_array = explode('.', $nits[0]);
          $preavisos = $secondCommand->bindValue(':cedula',$ced_array[0]
                                                             )->queryAll(); // obtener resultados



        }


        if(isset($array_post['generar']) && $tamano > 1){

           $preavisos = $command->bindValues([':dias' => intval($dias),
                                                           ':ciudades' => '%'.Yii::$app->session['ciudad'].'%' ])->queryAll(); // obtener resultados
       
        }


        $datos_carta = array();
        $datos_carta2 = array();
        while($index < $tamano){


          //$datos_carta2 = $preavisos;
          foreach ($preavisos as $key => $value) {
            $datos_carta2 [] = $value['terv_codigo'];
            if($value['terv_codigo'] == $nits[$index]){
               
               //$flag = $primaryCommand->bindValue(':cedula', intval($nits[$index]))->queryScalar();
               $datos_carta [] = array('terc_nombre' => $value['terc_nombre'],
                                       'terc_nit' => $value['terc_nit'],
                                       'terf_contrato' => $value['terf_contrato'],

                                       );

               $temporal = explode('-', $value['ubic_nombre']);
               $ciudad = $temporal[0];

              break; //Encontramos el valor y culminamos ciclo interno
            }
          }

          $model = new Preaviso();
          //$numero_de_cartas = $primaryCommand->bindValue(':cedula', intval($nits[$index]))->queryScalar();
          //$flag [] = $numero_de_cartas;
          /*establecer valores de Atributos del objeto prorroga*/
          $model->SetAttribute('cedula',intval($nits[$index]));
          $model->SetAttribute('fecha',$fecha_actual);
          $model->save();
      

          $index++;


        }


        if ( $tamano > 0 ) {

           

          $pdf = Yii::$app->pdf;
          $pdf->content = $this->renderPartial('_carta',['preavisos' => $datos_carta,'fecha' => $fecha,'ciudad' => $ciudad]);
          $pdf->destination = Pdf::DEST_DOWNLOAD;
          return $pdf->render();

        }

        //crear array paralelo con información de número de preavisos en los ultimos 30 días
        $cantidad_preavisos = array();

        foreach ($preavisos as $key => $value) {
          //contar preavisos ultimos 30 días
          $numero_de_preavisos = $primaryCommand->bindValue(':cedula', intval($value['terv_codigo']))->queryScalar();

          $cantidad_preavisos [] = $numero_de_preavisos;
        }
        

      return $this->render('index', [
                'preavisos' => $preavisos,
                'cantidad' => $cantidad_preavisos,
                'ciudades_actuales' => $ciudades_actuales,
                'empleados' => $empleados, 
                'sql' => $datos_carta2,
            ]);



    }


     public function actionPreavisar()
     {

       // $primaryConnection = Yii::$app->db;
        $secondConnection =  Yii::$app->second_db;
        $command = $secondConnection->createCommand("SELECT bter_tercero.terc_nombre,
                                                            bter_tercero.terc_nit,
                                                            FORMAT(bter_tercero.terf_contrato,'dd/MM/yyyy') as terf_contrato, 
                                                            bubi_ubicacion.ubic_nombre 
                                                       FROM      bter_tercero, bubi_ubicacion
                                                       WHERE     bter_tercero.tern_ubicacion = bubi_ubicacion.ubin_codigo
                                                        AND      bter_tercero.terc_empleado = 'S'
                                                        AND      bter_tercero.terc_estado_empleado = 'A'
                                                        AND      bter_tercero.tern_empresa = 1
                                                        AND      bter_tercero.terf_contrato >= getdate()
                                                        AND      bter_tercero.terf_contrato <= DATEADD(day,45,getdate())
                                                      ORDER BY   bubi_ubicacion.ubic_nombre ASC, bter_tercero.terf_contrato ASC");
                                
        $preavisos = $command->queryAll();

        /*Obtener Fecha*/
        $fecha = date("F j  Y");
         
        if(strpos($fecha, 'January') !== false);
        {
          $fecha = str_replace('January', 'Enero', $fecha);

        }

        if (strpos($fecha, 'February') !== false ) {

          $fecha = str_replace('February', 'Febrero', $fecha);
        }

         if (strpos($fecha, 'March') !== false ) {

           $fecha = str_replace('March', 'Marzo', $fecha);

        }

         if (strpos($fecha, 'April') !== false ) {

           $fecha = str_replace('April', 'Abril', $fecha);
        }

         if (strpos($fecha, 'May') !== false ) {

           $fecha = str_replace('May', 'Mayo', $fecha);

        }

         if (strpos($fecha, 'June') !== false ) {

           $fecha = str_replace('June', 'Junio', $fecha);

        }

         if (strpos($fecha, 'August') !== false ) {

           $fecha = str_replace('August', 'Agosto', $fecha);

        }

         if (strpos($fecha, 'September') !== false ) {

           $fecha = str_replace('September', 'Septiembre', $fecha);

        }

         if (strpos($fecha, 'October') !== false ) {

           $fecha = str_replace('October', 'Octubre', $fecha);

        }

         if (strpos($fecha, 'November') !== false ) {

            $fecha =str_replace('November', 'Noviembre', $fecha);

        }

        if(strpos($fecha, 'December') !== false ){

            $fecha = str_replace('December', 'Diciembre', $fecha);

        }

          $pdf = Yii::$app->pdf;
          $pdf->content = $this->renderPartial('_carta',['preavisos' => $preavisos,'fecha' => $fecha]);
          return $pdf->render();

         
       // return $this->render('preaviso',['preavisos' => $preavisos]);



     }

}
