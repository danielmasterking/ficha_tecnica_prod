<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ReporteDiarioEnc;
use app\models\ReporteDiario;
use app\models\UsuarioRol;
use app\models\PermisoRol;
use app\models\Usuario;
use app\models\Sucursal;
use app\models\UsuarioMeta;
use app\models\UsuarioCliente;
use app\models\UsuarioCiudad;
use app\models\Contacto;
use app\models\ContactForm;
use yii\helpers\VarDumper;
use app\models\Hdv_tercero;
use yii\web\UploadedFile;
use app\models\AuditoriaRetirados;
use app\models\Cliente;
use app\models\Novedad;
use app\models\Arma;
use app\models\TipoArma;
use app\models\Ciudad;
//use yii\httpclient\Client;

class SiteController extends Controller
{
    private $_token = null;
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionHome(){
        $this->layout='home';
        $usuario = Yii::$app->session['usuario'];
        $mes=date('m');
        $ano=date('Y');
        $clientes_asignados = UsuarioCliente::find()->where(['usuario' => $usuario])->count();
        $ciudades_asignadas=UsuarioCiudad::find()->where(['usuario' => $usuario])->all();
        $sucursales=[];
        foreach ($ciudades_asignadas as $cda) {
            $sucursales_ciudad=Sucursal::find()->where('ciudad_id='.$cda->ciudad_id.' and cod_oasis< 4000')->all();
            foreach ($sucursales_ciudad as $sc) {
                array_push($sucursales, $sc->id);
            }
        }

        $in=" AND red.sucursal_id IN(";

        foreach ($sucursales as $value) {
            
            $in.=" '".$value."',";    
        }

        if(count($sucursales)>0){
            $in_final = substr($in, 0, -1).")";
        }else{
            $in_final = null;
        }
        


        $novedades = Novedad::find()->where(['tipo' => 'R'])->all();

        $json_novedades=[];
        foreach ($novedades as $nov) {
          $sql = (new \yii\db\Query())
          ->select('COUNT(sucursal_id) TOTAL')
          ->from('reporte_diario_enc as renc')
          ->leftJoin('reporte_diario as red', 'renc.id = red.reporte_id');
          $sql->where('renc.usuario="'.$usuario.'" AND red.novedad_id='.$nov->id.' /*AND red.sucursal_id*/ '.$in_final.' AND (/*MONTH(red.fecha_registro)="'.$mes.'" AND*/ YEAR(red.fecha_registro)="'.$ano.'")');
          
          $commandsql = $sql->createCommand();

          $row_sql= $commandsql->queryOne();

          $json_novedades[]=[(string)$nov->nombre,(int)$row_sql['TOTAL']];

        }

        $json_novedades=json_encode($json_novedades);

        // echo "<pre>";
        // print_r($json_novedades);
        // echo "</pre>";

        $query = (new \yii\db\Query())
        ->select('COUNT(DISTINCT sucursal_id) TOTAL')
        ->from('reporte_diario_enc as renc')
        ->leftJoin('reporte_diario as red', 'renc.id = red.reporte_id');
       // ->where('renc.usuario="'.$usuario.'" AND red.novedad_id=18 AND red.sucursal_id '.$in_final.' ');

        $query->where('renc.usuario="'.$usuario.'" AND red.novedad_id=18 /*AND red.sucursal_id*/ '.$in_final.' AND (/*MONTH(red.fecha_registro)="'.$mes.'" AND*/ YEAR(red.fecha_registro)="'.$ano.'")');


        $query2 = (new \yii\db\Query())
        ->select('COUNT(DISTINCT sucursal_id) TOTAL')
        ->from('reporte_diario_enc as renc')
        ->leftJoin('reporte_diario as red', 'renc.id = red.reporte_id');
        $query2->where('renc.usuario="'.$usuario.'" AND red.novedad_id=1 /*AND red.sucursal_id*/ '.$in_final.' AND (/*MONTH(red.fecha_registro)="'.$mes.'" AND*/ YEAR(red.fecha_registro)="'.$ano.'")');

        //visitas cliente
        $command = $query->createCommand();

        $row_visita_cliente = $command->queryOne();

        $num_sucursales=count($sucursales);

        if($num_sucursales>0){
            $porcentaje_visitas_cliente=((int)$row_visita_cliente['TOTAL']*100)/(int)$num_sucursales;

            $porcentaje_visitas_cliente=round($porcentaje_visitas_cliente, 2);
        }else{
            $porcentaje_visitas_cliente=0;
        }
        //Visitas tecnicas

        $command2 = $query2->createCommand();

        $row_visita_tecnica= $command2->queryOne();
        if($num_sucursales>0){
            $porcentaje_visitas_tecnica=((int)$row_visita_tecnica['TOTAL']*100)/(int)$num_sucursales;

            $porcentaje_visitas_tecnica=round($porcentaje_visitas_tecnica, 2);
        }else{
            $porcentaje_visitas_tecnica=0;
        }
        ///INSPECCIONES
        $query3 = (new \yii\db\Query())
        ->select('COUNT(DISTINCT sucursal_id) TOTAL')
        ->from('reporte_diario_enc as renc')
        ->leftJoin('reporte_diario as red', 'renc.id = red.reporte_id');
        $query3->where('renc.usuario="'.$usuario.'" AND red.novedad_id=28 /*AND red.sucursal_id*/ '.$in_final.' AND (MONTH(red.fecha_registro)="'.$mes.'" AND YEAR(red.fecha_registro)="'.$ano.'")');

        $command3 = $query3->createCommand();

        $row_inspeccion= $command3->queryOne();

        $num_inspecciones=$row_inspeccion['TOTAL'];

        ////CAPACITACIONES
        $query4 = (new \yii\db\Query())
        ->select('COUNT(DISTINCT sucursal_id) TOTAL')
        ->from('reporte_diario_enc as renc')
        ->leftJoin('reporte_diario as red', 'renc.id = red.reporte_id');
        $query4->where('renc.usuario="'.$usuario.'" AND red.novedad_id=17 /*AND red.sucursal_id*/ '.$in_final.' AND (/*MONTH(red.fecha_registro)="'.$mes.'" AND */YEAR(red.fecha_registro)="'.$ano.'")');

        $command4 = $query4->createCommand();

        $row_capacitacion= $command4->queryOne();

        $num_capacitacion=$row_capacitacion['TOTAL'];

        ///

        $secondConnection =  Yii::$app->second_db; // Oasis --> SQL SERVER

        /*$command = $secondConnection->createCommand("SELECT COUNT(bter_tercero.terc_nit)AS TOTAL
                                                            
                                                        FROM  bubi_ubicacion, bter_tercero
                                                        WHERE bubi_ubicacion.ubin_codigo = bter_tercero.tern_ubicacion
                                                        AND   bter_tercero.terc_empleado = 'S'
                                                        AND   bter_tercero.terc_estado_empleado = 'A'
                                                        ");

        $empleados = $command->queryOne();*/
        $cursos_vencidos=json_decode($this->actionNum_cursos());    
        $num_cursos=$cursos_vencidos->{'result'};

        $cursos_expirados=json_decode($this->actionNum_cursos_vencidos());    
        $num_cursos_expirados=$cursos_expirados->{'result'};
        
        //ARMAS
        $ciudad=Ciudad::find()->all();
        $tipos=TipoArma::find()->all();
        $arreglo_armas=[];
        foreach ($ciudad as $cd) {
            $arreglo_armas[$cd->nombre]=[];
            foreach ($tipos as $tp) {

                $query_arma= (new \yii\db\Query())
                ->select('COUNT(arma.id)TOTAL')
                ->from('arma')
                ->innerJoin('arma_sucursal', 'arma.id = arma_sucursal.arma_id')
                ->innerJoin('sucursal', 'arma_sucursal.sucursal_id = sucursal.id')
                ->innerJoin('ciudad', 'sucursal.ciudad_id = ciudad.id')
                ->where('ciudad.id='.$cd->id.' and arma.tipo_arma_id='.$tp->id.' ')
                ->limit(1);
                $command_arma = $query_arma->createCommand();
                $rows_arma = $command_arma->queryOne();

                $arreglo_armas[$cd->nombre][$tp->nombre]=$rows_arma['TOTAL'];

            }
        }

        return $this->render('home',[
            'clientes'=>$clientes_asignados,
            //'empleados'=>$empleados,
            'num_cursos'=>$num_cursos,
            'row_visita_cliente'=>$row_visita_cliente,
            'porcentaje_visitas_cliente'=>$porcentaje_visitas_cliente,
            'row_visita_tecnica'=>$row_visita_tecnica,
            'porcentaje_visitas_tecnica'=>$porcentaje_visitas_tecnica,
            'num_inspecciones'=>$num_inspecciones,
            'num_capacitacion'=>$num_capacitacion,
            'json_novedades'=>$json_novedades,
            'num_sucursales'=>$num_sucursales,
            'num_cursos_expirados'=>$num_cursos_expirados,
            'arreglo_armas'=>$arreglo_armas

        ]);
    }

    public function actionCambio(){


         if(isset( Yii::$app->session['usuario'] )){


            $array_post = Yii::$app->request->post();


            $nueva_clave = isset($array_post['clave']) ? $array_post['clave'] : 'X';

            $confirmacion_clave = isset($array_post['confirmacion_clave']) ? $array_post['confirmacion_clave'] : 'Y';

            $model = null;

            if($confirmacion_clave == $nueva_clave){


                $usuario_ar = Usuario::find()->where(['usuario' => Yii::$app->session['usuario'] ])->all();

                $model = $usuario_ar[0];

                $model->SetAttribute('password',$nueva_clave);

                $model->save();


            }


            return $this->render('cambio',[

                        'model' => $model,
                        'post' =>  $array_post,

                ]);


         }


    }

    public function actionIndex()
    {

      $this->layout='_login';
     if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {


            $primaryConnection = Yii::$app->db;
           /* $primaryCommand = $primaryConnection->createCommand("SELECT  rol.nombre as nombre
                                                                  FROM usuario,rol
                                                                  WHERE usuario.rol_id = rol.id
                                                                  AND   usuario.usuario = :usuario");*/

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
                                                                 WHERE fecha = :fecha
                                                         ");


            date_default_timezone_set ( 'America/Bogota');
            $fecha = date('Y-m-d',time());
            $reportes = $fourthCommand->bindValue(':fecha',$fecha)->queryScalar();

            $usuario = Yii::$app->user->identity->usuario;
            \Yii::$app->session->setTimeout(5400);//5400
            Yii::$app->session['usuario'] = $usuario;

            Yii::$app->session['permisos'] = $this->allowed($usuario);

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

                    }


                }


            }



             $this->redirect('site/home');
            //return $this->goBack();
            /*return $this->render('login', [
                'model' => $model,
            ]);*/

        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {


            $primaryConnection = Yii::$app->db;
           /* $primaryCommand = $primaryConnection->createCommand("SELECT  rol.nombre as nombre
                                                                  FROM usuario,rol
                                                                  WHERE usuario.rol_id = rol.id
                                                                  AND   usuario.usuario = :usuario");*/

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
                                                                 WHERE fecha = :fecha
                                                         ");


            date_default_timezone_set ( 'America/Bogota');
            $fecha = date('Y-m-d',time());
            $reportes = $fourthCommand->bindValue(':fecha',$fecha)->queryScalar();



            $usuario = Yii::$app->user->identity->usuario;

            Yii::$app->session['usuario'] = $usuario;



            Yii::$app->session['permisos'] = $this->allowed($usuario);

            Yii::$app->session['notificacion'] =1;




            if($reportes === false || $reportes == 0){

                $estados = $thirdCommand->queryAll();
                $usuarios =  $secondCommand->queryAll();

                foreach ($usuarios as $key => $value) {

                     $permisos_usu = $this->allowed($value['usuario']);

                        if( in_array("reporte diario - escritura", $permisos_usu) ){

                             $model_reporte = new ReporteDiarioEnc();
                             $model_reporte->SetAttribute('fecha',$fecha);
                             $model_reporte->SetAttribute('usuario',$value['usuario']);
                             $model_reporte->SetAttribute('estado_id',$estados[0]['id']);
                             $model_reporte->save();

                        }


                }


            }

             $this->redirect('start');


        }else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }


    public function actionSalir(){

        session_start();

        session_destroy();

        return $this->goHome();
    }

    public function actionLogout()
    {

        Yii::$app->session->remove('usuario');
        Yii::$app->session->remove('notificacion');

        Yii::$app->session->destroy();



        Yii::$app->user->logout();



        unset($_SESSION['usuario']);



        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionIndicadores(){

         return $this->render('indicadores');
    }

    public function actionStart()
    {
           $primaryConnection = Yii::$app->db;
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
                                                                 WHERE fecha = :fecha
                                                         ");


            date_default_timezone_set ( 'America/Bogota');
            $fecha = date('Y-m-d',time());
            $reportes = $fourthCommand->bindValue(':fecha',$fecha)->queryScalar();

            if($reportes === false || $reportes == 0){

                $estados = $thirdCommand->queryAll();
                $usuarios =  $secondCommand->queryAll();

                foreach ($usuarios as $key => $value) {

                $model_reporte = new ReporteDiarioEnc();
                $model_reporte->SetAttribute('fecha',$fecha);
                $model_reporte->SetAttribute('usuario',$value['usuario']);
                $model_reporte->SetAttribute('estado_id',$estados[0]['id']);
                $model_reporte->save();

                }


            }


            $clientes_asignados = UsuarioCliente::find()->where(['usuario' => Yii::$app->session['usuario']])->all();
            $sucursales = array();
            $contactos_temp = array();
            $contactos = array();
            $cumpleano_time = strtotime('+3 day' , strtotime ( $fecha ));
            $today_time = strtotime($fecha);
            foreach($clientes_asignados as $key){

              $sucursales = $key->cliente->sucursales;

              foreach ($sucursales as $key2 ) {

                  $contactos_temp = $key2->contactos;

                  foreach ($contactos_temp as $key3) {

                      if( (strtotime($key3->cumpleano) <= $cumpleano_time) && strtotime($key3->cumpleano) >= $today_time ) {

                        $contactos [] = $key3;

                      }
                  }




              }



            }


            $cursos_vencidos=json_decode($this->actionNum_cursos());

            

            $num_cursos=$cursos_vencidos->{'result'};

            



           return $this->render('start', ['contactos' => $contactos,'num_cursos'=>$num_cursos]);

    }

    public function actionDetalleemp($id){

      $secondConnection =  Yii::$app->second_db; // Oasis --> SQL SERVER
      $sql = "SELECT bter_tercero.terc_nit AS CEDULA,
                     bter_tercero.terc_nombre AS NOMBRE,
                     bter_tercero.terc_direccion AS DIRECCION,
                     bter_tercero.terc_telefono AS TELEFONO,
                     bubg_ubicacion_geografica.ubgc_nombre AS UBICACION,
                     CAST(bter_tercero.terf_nacimiento as date) AS NACIMIENTO,
                     bter_tercero.terc_estado_civil AS ESTADO_CIVIL,
                     bter_tercero.tern_hijos AS HIJOS,
                     bter_tercero.terc_sexo AS SEXO,
                     bter_tercero.terc_discapacidad AS DISCAPACIDAD,
                     bter_tercero.terv_estatura AS ALTURA,
                     bter_tercero.terv_peso AS PESO,
                     bter_tercero.terc_rh AS RH,
                     bter_tercero.terc_tipo_contrato AS CONTRATO,
                     CAST(bter_tercero.terf_ingreso as date) AS INGRESO,
                     rpos_posicion.posc_nombre AS POSICION,
                     bter_tercero.terc_primer_apellido PRIMER_APELLIDO,
                     bter_tercero.terc_segundo_apellido SEGUNDO_APELLIDO,
                     bter_tercero.terc_primer_nombre PRIMER_NOMBRE,
                     bter_tercero.terc_segundo_nombre SEGUNDO_NOMBRE
                FROM bter_tercero,
                     bubg_ubicacion_geografica,
                     rpos_posicion
               WHERE ( bter_tercero.tern_posicion = rpos_posicion.posn_codigo ) and
                     ( bter_tercero.tern_ubicacion_geografica = bubg_ubicacion_geografica.ubgn_codigo ) and
                     ( ( terc_empleado = 'S' ) )
             and (((bter_tercero.terv_codigo =  :cedula))) ";

      $command = $secondConnection->createCommand($sql);

      $empleado = $command->bindValue(':cedula', $id)->queryAll();

      $sql_cursos='SELECT rcap_capacitacion_ch.terc_nit_escuela,rcap_capacitacion_ch.terc_nombre,rcap_capacitacion_ch.terc_certificado,rcap_capacitacion_ch.terf_fecha_inicial,rcap_capacitacion_ch.terf_fecha_final,rcur_curso.curc_nombre,rcap_capacitacion_ch.capc_certificado 
          FROM rcap_capacitacion_ch
          INNER JOIN rcur_curso on rcap_capacitacion_ch.terv_tipo_curso=rcur_curso.curn_codigo
          WHERE rcap_capacitacion_ch.terv_tercero=:cedula 
          ORDER BY rcap_capacitacion_ch.terf_fecha_final DESC
        ';

        $command_cursos = $secondConnection->createCommand($sql_cursos);

        $cursos = $command_cursos->bindValue(':cedula', $id)->queryAll();

       return $this->render('detalleemp', [
                     'empleado' => $empleado,
                     'id' => $id,
                     'cursos'=>$cursos
       ]);

    }

    public function actionEmpleados(){

        $secondConnection =  Yii::$app->second_db; // Oasis --> SQL SERVER

        $command = $secondConnection->createCommand("SELECT bter_tercero.terc_nit AS NIT,
                                                            bter_tercero.terc_nombre AS NOMBRE,
                                                            bubi_ubicacion.ubic_nombre AS UBICACION,
                                                            bter_tercero.terc_direccion AS DIRECCION,
                                                            bter_tercero.terc_telefono AS TELEFONO
                                                        FROM  bubi_ubicacion, bter_tercero
                                                        WHERE bubi_ubicacion.ubin_codigo = bter_tercero.tern_ubicacion
                                                        AND   bter_tercero.terc_empleado = 'S'
                                                        AND   bter_tercero.terc_estado_empleado = 'A'
                                                        ORDER BY bter_tercero.terc_nombre");

        $empleados = $command->queryAll();


         return $this->render('empleados', [
                'empleados' => $empleados,
         ]);
    }

    public function actionEmpleadosRetirados(){

        $secondConnection =  Yii::$app->second_db; // Oasis --> SQL SERVER



        $command = $secondConnection->createCommand("SELECT bter_tercero.terc_nit AS NIT,
                                                            bter_tercero.terc_nombre AS NOMBRE,
                                                            bubi_ubicacion.ubic_nombre AS UBICACION,
                                                            bter_tercero.terf_retiro AS FECHA_RETIRO
                                                        FROM  bubi_ubicacion, bter_tercero
                                                        WHERE bubi_ubicacion.ubin_codigo = bter_tercero.tern_ubicacion
                                                        AND   bter_tercero.terc_empleado = 'S'
                                                        AND   bter_tercero.terc_estado_empleado = 'R'
                                                        ORDER BY bter_tercero.terf_retiro DESC");

        $empleados = $command->queryAll();


         return $this->render('empleados_retirados', [
                'empleados' => $empleados,
         ]);
    }

    public function actionDetalleempRetirados($id){

        
      $secondConnection =  Yii::$app->second_db; // Oasis --> SQL SERVER
      $sql = "SELECT bter_tercero.terc_nit AS CEDULA,
                     bter_tercero.terc_nombre AS NOMBRE,
                     bter_tercero.terc_direccion AS DIRECCION,
                     bter_tercero.terc_telefono AS TELEFONO,
                     bubg_ubicacion_geografica.ubgc_nombre AS UBICACION,
                     CAST(bter_tercero.terf_nacimiento as date) AS NACIMIENTO,
                     bter_tercero.terc_estado_civil AS ESTADO_CIVIL,
                     bter_tercero.tern_hijos AS HIJOS,
                     bter_tercero.terc_sexo AS SEXO,
                     bter_tercero.terc_discapacidad AS DISCAPACIDAD,
                     bter_tercero.terv_estatura AS ALTURA,
                     bter_tercero.terv_peso AS PESO,
                     bter_tercero.terc_rh AS RH,
                     bter_tercero.terc_tipo_contrato AS CONTRATO,
                     CAST(bter_tercero.terf_ingreso as date) AS INGRESO,
                     rpos_posicion.posc_nombre AS POSICION,
                     bter_tercero.terc_primer_apellido PRIMER_APELLIDO,
                     bter_tercero.terc_segundo_apellido SEGUNDO_APELLIDO,
                     bter_tercero.terc_primer_nombre PRIMER_NOMBRE,
                     bter_tercero.terc_segundo_nombre SEGUNDO_NOMBRE
                FROM bter_tercero,
                     bubg_ubicacion_geografica,
                     rpos_posicion
               WHERE ( bter_tercero.tern_posicion = rpos_posicion.posn_codigo ) and
                     ( bter_tercero.tern_ubicacion_geografica = bubg_ubicacion_geografica.ubgn_codigo ) and
                     ( ( terc_empleado = 'S' ) )
             and (((bter_tercero.terv_codigo =  :cedula))) ";

      $command = $secondConnection->createCommand($sql);

      $empleado = $command->bindValue(':cedula', $id)->queryAll();


      $sql_cursos='SELECT rcap_capacitacion_ch.terc_nit_escuela,rcap_capacitacion_ch.terc_nombre,rcap_capacitacion_ch.terc_certificado,rcap_capacitacion_ch.terf_fecha_inicial,rcap_capacitacion_ch.terf_fecha_final,rcur_curso.curc_nombre,rcap_capacitacion_ch.capc_certificado 
          FROM rcap_capacitacion_ch
          INNER JOIN rcur_curso on rcap_capacitacion_ch.terv_tipo_curso=rcur_curso.curn_codigo
          WHERE rcap_capacitacion_ch.terv_tercero=:cedula 
          ORDER BY rcap_capacitacion_ch.terf_fecha_final DESC
        ';

        $command_cursos = $secondConnection->createCommand($sql_cursos);

        $cursos = $command_cursos->bindValue(':cedula', $id)->queryAll();


        $sql_novedad="
        select nview_novedad.novn_numero,   
         nview_novedad.novf_fecha,   
         nview_novedad.conc_nombre,   
         nview_novedad.novt_observacion,   
              (select TOP(1)motc_nombre
              from nnov_novedad
             inner join nmot_motivo on nmot_motivo.motc_codigo=nnov_novedad.novc_motivo
             where nview_novedad.novf_fecha=novf_fecha and novv_tercero=".$id."
             order by novf_fecha desc) as motivo,    
             (select TOP(1)liqn_numero  
              from nliq_liquidacion
             where nview_novedad.novf_fecha=liqf_retiro and liqv_tercero=".$id."
             order by novf_fecha desc) as Liquidacion
    from nview_novedad  
       
   where nview_novedad.novv_tercero = ".$id." and novc_concepto in ('IGN','ING','RET') 
   order by novf_fecha DESC

        ";

        $command_novedad = $secondConnection->createCommand($sql_novedad)->queryAll();

        $AuditoriaRetirados=AuditoriaRetirados::find()->where('id_tercero='.$id)->one();

        if ($AuditoriaRetirados==null) {
            $AuditoriaRetirados=new AuditoriaRetirados;
            if ($AuditoriaRetirados->load(Yii::$app->request->post())) {
                


               $AuditoriaRetirados->setAttribute('id_tercero',$id);
               if(!isset($_POST['AuditoriaRetirados']['estado'])){

                    $AuditoriaRetirados->setAttribute('estado','N');

               }
                
                $AuditoriaRetirados->save();
                return $this->redirect(['detalleemp-retirados', 'id' => $id]);
            }
        }else{

            if ($AuditoriaRetirados->load(Yii::$app->request->post())) {
                if(!isset($_POST['AuditoriaRetirados']['estado'])){

                    $AuditoriaRetirados->setAttribute('estado','N');

               }
                $AuditoriaRetirados->save();
                return $this->redirect(['detalleemp-retirados', 'id' => $id]);
            }
        }

        


       return $this->render('detalleemp_retirado', [
                     'empleado' => $empleado,
                     'id' => $id,
                     'cursos'=>$cursos,
                     'novedad'=>$command_novedad,
                     'AuditoriaRetirados'=>$AuditoriaRetirados
       ]);

    }
    
    public function actionNum_cursos(){
        $secondConnection =  Yii::$app->second_db;
        
        $sql='SELECT count(terv_tercero) contar
            FROM rcap_capacitacion_ch 
            WHERE terf_fecha_final  between convert(date,getdate()) and DATEADD(day,30,convert(date,getdate()))
        ';

        $command = $secondConnection->createCommand($sql);

        $result = $command->queryOne();

        $data=array('result'=>$result['contar']);

        return json_encode($data); 
    }

    public function actionNum_cursos_vencidos(){
        $secondConnection =  Yii::$app->second_db;
        
        $sql='SELECT count(terv_tercero) contar
            FROM rcap_capacitacion_ch 
            WHERE terf_fecha_final <= getdate()
        ';

        $command = $secondConnection->createCommand($sql);

        $result = $command->queryOne();

        $data=array('result'=>$result['contar']);

        return json_encode($data); 
    }


    public function actionNotificacion_cursos(){

        $secondConnection =  Yii::$app->second_db;
        $sql='SELECT terf_fecha_final,terv_tercero,bter_tercero.terc_nombre,rcur_curso.curc_nombre,bter_tercero.terc_nit
            FROM rcap_capacitacion_ch 
            INNER JOIN bter_tercero on rcap_capacitacion_ch.terv_tercero=bter_tercero.terv_codigo
            INNER JOIN rcur_curso   on rcap_capacitacion_ch.terv_tipo_curso=rcur_curso.curn_codigo
            WHERE terf_fecha_final  between convert(date,getdate()) and DATEADD(day,30,convert(date,getdate()))
            
        ';

        if (isset($_POST['buscar'])) {
            $sql.=" AND  rcur_curso.curc_nombre like '%".$_POST['buscar']."%'";
        }

        $sql.='ORDER BY bter_tercero.terc_nit';

        $command = $secondConnection->createCommand($sql);

        $result = $command->queryAll();


        return $this->render('cursos_vencidos', [
                'result' => $result,
         ]);
        

    }

    public function actionHdv_empleado($id,$nombre){

        $model=new Hdv_tercero();

        if ($model->load(Yii::$app->request->post()) /*&& $model->save()*/) {

            $consulta=Hdv_tercero::find()->where('id_tercero='.$id)->count();
            Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/';
            $shortPath = '/uploads/';       
            $pdf = UploadedFile::getInstances($model, 'archivo');
            $cantidad=count($pdf);

            if($consulta==0){
                
                $model->setAttribute('id_tercero',$id);
                if ($cantidad>0) {

                    $ext = end((explode(".", $pdf[0]->name)));
                    $name = date('Ymd').rand(1, 10000).''.$pdf[0]->name;
                    $path = Yii::$app->params['uploadPath'] . $name;
                    $model->setAttribute('hoja_vida',$shortPath. $name);
                    $pdf[0]->saveAs($path);
                }

                $model->save();
            }else{
                $hv=Hdv_tercero::find()->where('id_tercero='.$id)->one();
                if ($cantidad>0) {

                    $ext = end((explode(".", $pdf[0]->name)));
                    $name = date('Ymd').rand(1, 10000).''.$pdf[0]->name;
                    $path = Yii::$app->params['uploadPath'] . $name;
                    Hdv_tercero::updateAll(['hoja_vida' => $shortPath. $name], ['=', 'id_tercero',$id]);
                    $pdf[0]->saveAs($path);
                }

                unlink(Yii::$app->basePath .'/web/'.$hv->hoja_vida );
            }

            return $this->redirect(['site/empleados']);

        }

        return $this->render('form_hdv', [
                'model'=>$model,
                'nombre'=>$nombre
         ]);


    }

    /* validar permisos
     * Return array con permisos de usuario permisos
     */

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

    /************************************************************************************/

        public function actionReportes(){

                /*****Obtener cordinadores*/
                $coordinadores_tmp = UsuarioRol::find()->where(['rol_id' => 2])->all();
                $coordinadores = array();

                foreach ($coordinadores_tmp as $key) {
                    
                    //VarDumper::dump($key);
                    if($key->usuario2->status == "A"){
                      $coordinadores [] = $key;
                    }
                }


                $primaryConnection = Yii::$app->db;
                $usuario = Yii::$app->session['usuario'];
                $consultar = '0';
                $array_post = Yii::$app->request->post();
                $contador_dias_reporte = 0;
                $selected_coor = '';
                $total = 0;
                 $consolidado = array();
                 $total_sucursales = array();
                 $detalle_consolidado = array();
                 $sql = '';
                 $parametros_array = array();

                 if(array_key_exists('consultar', $array_post)){

                    $main_sql = "SELECT COUNT(*) AS TOTAL_DIA,  re.fecha AS FECHA
                                   FROM reporte_diario rd, reporte_diario_enc re
                                   WHERE rd.reporte_id = re.id
                                   AND re.usuario = :coordinador
                                   AND re.fecha BETWEEN :FECHA_1 AND DATE_ADD(:FECHA_2, INTERVAL 1 DAY)
                                   GROUP BY re.fecha
                                    ";

                    $main_sql_2 = "SELECT COUNT(*) AS TOTAL_FESTIVOS
                                   FROM festivo f
                                   WHERE f.fecha BETWEEN :FECHA_1 AND DATE_ADD(:FECHA_2, INTERVAL 1 DAY)
                                   ";

                    $main_sql_3 = "SELECT DISTINCT (s.nombre) AS SUCURSAL, s.id AS ID_SUCURSAL
                                    FROM reporte_diario rd, sucursal s, cliente c, novedad n, reporte_diario_enc rde
                                   WHERE s.id = rd.sucursal_id
                                   AND s.nit = c.nit
                                   AND rde.id = rd.reporte_id
                                   AND n.id = rd.novedad_id
                                   ".$sql;
                   $main_sql_4 = "SELECT rd.usuario AS NOVEDAD ,COUNT(*) AS CANTIDAD
                    FROM reporte_diario rd, reporte_diario_enc rde
                   WHERE   rde.id = rd.reporte_id

                   ".$sql.' GROUP BY rd.usuario';

                     //$primaryCommand2 = $primaryConnection->createCommand($main_sql_2);
                     $primaryCommand3 = $primaryConnection->createCommand($main_sql);
                     $primaryCommand4 = $primaryConnection->createCommand($main_sql_2);
                     //$primaryCommand5 = $primaryConnection->createCommand($main_sql_4);
                     $parametros_array = array();
                     $dias = 0;
                     $total_festivos = 0;

                     if(array_key_exists('fecha_inicial', $array_post) && array_key_exists('fecha_final', $array_post)){

                            if($array_post['fecha_inicial'] != '' && $array_post['fecha_final'] != ''){

                                $parametros_array[':FECHA_1'] = $array_post['fecha_inicial'];
                                $parametros_array[':FECHA_2'] = $array_post['fecha_final'];
                                $parametros_array_fes[':FECHA_1'] = $array_post['fecha_inicial'];
                                $parametros_array_fes[':FECHA_2'] = $array_post['fecha_final'];

                                $parametros_array[':coordinador'] = $array_post['coordinador'];
                                $selected_coor = $array_post['coordinador'];
                                $fecha_i = $array_post['fecha_inicial'];
                                $fecha_f = $array_post['fecha_final'];
                                $dias   = (strtotime($fecha_i)-strtotime($fecha_f))/86400;
                                $dias   = abs($dias);
                                $dias = floor($dias) + 1;
                                $consolidado = $primaryCommand3->bindValues($parametros_array)->queryAll();
                                $festivos = $primaryCommand4->bindValues($parametros_array_fes)->queryAll();
                                $total_festivos = $festivos[0]['TOTAL_FESTIVOS'];


                            }else{

                                $consolidado = array();
                            }


                     }else{

                        $consolidado = array();
                     }



                      $total = $dias - $total_festivos;





                      foreach ($consolidado as $key) {

                          $contador_dias_reporte = $contador_dias_reporte + 1;
                      }

                      /*detalle de sucursales*/
                     // $total_sucursales =  $primaryCommand4->bindValues($parametros_array)->queryAll();

                   $consultar =  '1';

                 }

                return $this->render('reportes', [
                        'model' => 'a',
                        'coord' => $selected_coor,
                        'consultar' => $consultar,
                        'total' => $total,
                        'total_realizado' => $contador_dias_reporte,
                        'consolidado' => $consolidado,
                        'sql' => $parametros_array,
                        'usuarios' => $coordinadores,
                        //'detalle_consolidado' => $detalle_consolidado,
                    ]);

            }


    /*************************************************************************************/

  /************************************************************************************/

        public function actionCapacitaciones(){

                                /*****Obtener cordinadores*/
                $coordinadores_tmp = UsuarioRol::find()->where(['rol_id' => 2])->all();
                $coordinadores = array();

                foreach ($coordinadores_tmp as $key) {
                    
                    //VarDumper::dump($key);
                    if($key->usuario2->status == "A"){
                      $coordinadores [] = $key;
                    }
                }
                $primaryConnection = Yii::$app->db;
                $usuario = Yii::$app->session['usuario'];
                $consultar = '0';
                $array_post = Yii::$app->request->post();
                $selected_coor = '';
                $total = 4;
                $consolidado = array();
                $sql = '';
                $parametros_array = array();
                $contador_capacitaciones_realizadas = 0;
                 if(array_key_exists('consultar', $array_post)){

                    $main_sql = "SELECT COUNT(*) AS TOTAL_CAPACITACIONES,  re.fecha AS FECHA, s.nombre AS NOM_SUCURSAL
                                   FROM reporte_diario rd, reporte_diario_enc re, sucursal s
                                   WHERE rd.reporte_id = re.id
                                   AND  rd.sucursal_id = s.id
                                   AND re.usuario = :coordinador
                                   AND re.fecha BETWEEN :FECHA_1 AND DATE_ADD(:FECHA_2, INTERVAL 1 DAY)
                                   AND rd.novedad_id = 17
                                   GROUP BY re.fecha
                                    ";

                     $primaryCommand = $primaryConnection->createCommand($main_sql);
                     $parametros_array = array();

                     if(array_key_exists('fecha_inicial', $array_post) && array_key_exists('fecha_final', $array_post)){

                            if($array_post['fecha_inicial'] != '' && $array_post['fecha_final'] != ''){

                                $parametros_array[':FECHA_1'] = $array_post['fecha_inicial'];
                                $parametros_array[':FECHA_2'] = $array_post['fecha_final'];
                                $parametros_array[':coordinador'] = $array_post['coordinador'];
                                $selected_coor = $array_post['coordinador'];
                                $consolidado = $primaryCommand->bindValues($parametros_array)->queryAll();

                            }else{

                                $consolidado = array();
                            }

                     }else{

                        $consolidado = array();
                     }

                      foreach ($consolidado as $key) {

                          $contador_capacitaciones_realizadas = $contador_capacitaciones_realizadas + $key['TOTAL_CAPACITACIONES'];
                      }

                      /*detalle de sucursales*/
                     // $total_sucursales =  $primaryCommand4->bindValues($parametros_array)->queryAll();

                   $consultar =  '1';

                 }

                return $this->render('capacitaciones', [
                        'model' => 'a',
                        'coord' => $selected_coor,
                        'consultar' => $consultar,
                        'total' => $total,
                        'total_realizado' => $contador_capacitaciones_realizadas,
                        'consolidado' => $consolidado,
                        'sql' => $parametros_array,
                        'usuarios' => $coordinadores,
                        //'detalle_consolidado' => $detalle_consolidado,
                    ]);

            }


    /*************************************************************************************/
     /************************************************************************************/

      public function actionInspecciones(){

                /*****Obtener cordinadores*/
                $coordinadores_tmp = UsuarioRol::find()->where(['rol_id' => 2])->all();
                $coordinadores = array();

                foreach ($coordinadores_tmp as $key) {
                    
                    //VarDumper::dump($key);
                    if($key->usuario2->status == "A"){
                      $coordinadores [] = $key;
                    }
                }

                $primaryConnection = Yii::$app->db;
                $usuario = Yii::$app->session['usuario'];
                $consultar = '0';
                $array_post = Yii::$app->request->post();
                $selected_coor = '';
                $total = 7;
                $consolidado = array();
                $sql = '';
                $parametros_array = array();
                $contador_inspecciones_realizadas = 0;
                 if(array_key_exists('consultar', $array_post)){

                    $main_sql = "SELECT COUNT(*) AS TOTAL_INSPECCIONES,  re.fecha AS FECHA, s.nombre AS NOM_SUCURSAL
                                   FROM reporte_diario rd, reporte_diario_enc re, sucursal s
                                   WHERE rd.reporte_id = re.id
                                   AND   s.id = rd.sucursal_id
                                   AND re.usuario = :coordinador
                                   AND re.fecha BETWEEN :FECHA_1 AND DATE_ADD(:FECHA_2, INTERVAL 1 DAY)
                                   AND rd.novedad_id = 28
                                   GROUP BY re.fecha
                                    ";

                     $primaryCommand = $primaryConnection->createCommand($main_sql);
                     $parametros_array = array();

                     if(array_key_exists('fecha_inicial', $array_post) && array_key_exists('fecha_final', $array_post)){

                            if($array_post['fecha_inicial'] != '' && $array_post['fecha_final'] != ''){

                                $parametros_array[':FECHA_1'] = $array_post['fecha_inicial'];
                                $parametros_array[':FECHA_2'] = $array_post['fecha_final'];
                                $parametros_array[':coordinador'] = $array_post['coordinador'];
                                $selected_coor = $array_post['coordinador'];
                                $consolidado = $primaryCommand->bindValues($parametros_array)->queryAll();

                            }else{

                                $consolidado = array();
                            }

                     }else{

                        $consolidado = array();
                     }

                      foreach ($consolidado as $key) {

                          $contador_inspecciones_realizadas = $contador_inspecciones_realizadas + $key['TOTAL_INSPECCIONES'];
                      }

                      /*detalle de sucursales*/
                     // $total_sucursales =  $primaryCommand4->bindValues($parametros_array)->queryAll();

                   $consultar =  '1';

                 }

                return $this->render('inspecciones', [
                        'model' => 'a',
                        'coord' => $selected_coor,
                        'consultar' => $consultar,
                        'total' => $total,
                        'total_realizado' => $contador_inspecciones_realizadas,
                        'consolidado' => $consolidado,
                        'sql' => $parametros_array,
                        'usuarios' => $coordinadores,
                        //'detalle_consolidado' => $detalle_consolidado,
                    ]);

            }


    /*************************************************************************************/
  /************************************************************************************/

        public function actionVisitastecnicasoperativas(){

            /*****Obtener cordinadores*/
            $coordinadores_tmp = UsuarioRol::find()->where(['rol_id' => 2])->all();
            $coordinadores = array();

            foreach ($coordinadores_tmp as $key) {
                
                //VarDumper::dump($key);
                if($key->usuario2->status == "A"){
                  $coordinadores [] = $key;
                }
            }
          $primaryConnection = Yii::$app->db;
          $usuario = Yii::$app->session['usuario'];
          $consultar = '0';
          $total_usuario = 0;
          $array_post = Yii::$app->request->post();
          $selected_coor = '';
          $consolidado = array();
          $total = 0;
          $sql = '';
          $parametros_array = array();
          $contador_visitas_realizadas = 0;
           if(array_key_exists('consultar', $array_post)){

             $usuario_meta = UsuarioMeta::find()->where(['usuario_usuario' => $array_post['coordinador']])->one();
             if($usuario_meta != null){

                $total_usuario = $usuario_meta->cantidad;
             }
             //validar si $total_usuario == 0 en dado caso se deben contar las sucursales de los clientes asignados para el usuario.
             if($total_usuario == 0){

               $clientes_usuario = UsuarioCliente::find()->where(['usuario' => $array_post['coordinador']])->all();
               $ciudades_usuario = UsuarioCiudad::find()->where(['usuario' => $array_post['coordinador']])->all();

               foreach ($ciudades_usuario as $key ) {

                   $ciudades [] = $key->ciudad_id;
               }

               $sucu_array = array();
               $sucu_array_ciudad = array();

               foreach ($clientes_usuario as $cliente ) {
                 $sucursales = Sucursal::find()->where(['nit' => $cliente->nit,'estado' => 'A', 'temporal' => 'N'])
                                               ->all();
                 foreach ($sucursales as $sucursal) {

                    $sucu_array [] = $sucursal;
                 }
               }

               foreach ($sucu_array as $key) {

                 if(in_array($key->ciudad_id, $ciudades)){

                   $sucu_array_ciudad [] = $key;

                 }

               }

               $total_usuario = count($sucu_array_ciudad);

             }
             $total = ceil($total_usuario/2);


              $main_sql = "SELECT COUNT(*) AS TOTAL_VISITAS,  re.fecha AS FECHA
                             FROM reporte_diario rd, reporte_diario_enc re
                             WHERE rd.reporte_id = re.id
                             AND re.usuario = :coordinador
                             AND re.fecha BETWEEN :FECHA_1 AND DATE_ADD(:FECHA_2, INTERVAL 1 DAY)
                             AND rd.novedad_id = 1
                             GROUP BY re.fecha
                              ";

               $primaryCommand = $primaryConnection->createCommand($main_sql);
               $parametros_array = array();

               if(array_key_exists('fecha_inicial', $array_post) && array_key_exists('fecha_final', $array_post)){

                      if($array_post['fecha_inicial'] != '' && $array_post['fecha_final'] != ''){

                          $parametros_array[':FECHA_1'] = $array_post['fecha_inicial'];
                          $parametros_array[':FECHA_2'] = $array_post['fecha_final'];
                          $parametros_array[':coordinador'] = $array_post['coordinador'];
                          $selected_coor = $array_post['coordinador'];
                          $consolidado = $primaryCommand->bindValues($parametros_array)->queryAll();

                      }else{

                          $consolidado = array();
                      }

               }else{

                  $consolidado = array();
               }

                foreach ($consolidado as $key) {

                    $contador_visitas_realizadas = $contador_visitas_realizadas + $key['TOTAL_VISITAS'];
                }

                /*detalle de sucursales*/
               // $total_sucursales =  $primaryCommand4->bindValues($parametros_array)->queryAll();

             $consultar =  '1';

           }

          return $this->render('visitastecnicasoperativas', [
                  'model' => 'a',
                  'coord' => $selected_coor,
                  'consultar' => $consultar,
                  'total' => $total,
                  'total_realizado' => $contador_visitas_realizadas,
                  'consolidado' => $consolidado,
                  'sql' => $parametros_array,
                  'usuarios' => $coordinadores,
                  //'detalle_consolidado' => $detalle_consolidado,
              ]);
            }


    /*************************************************************************************/
  /************************************************************************************/

        public function actionInstalaciones(){

            /*****Obtener cordinadores*/
                $coordinadores_tmp = UsuarioRol::find()->where(['rol_id' => 2])->all();
                $coordinadores = array();

                foreach ($coordinadores_tmp as $key) {
                    
                    //VarDumper::dump($key);
                    if($key->usuario2->status == "A"){
                      $coordinadores [] = $key;
                    }
                }
                $primaryConnection = Yii::$app->db;
                $usuario = Yii::$app->session['usuario'];
                $consultar = '0';
                $array_post = Yii::$app->request->post();
                $contador_dias_reporte = 0;
                $selected_coor = '';
                $total = 0;
                 $consolidado = array();
                 $total_sucursales = array();
                 $detalle_consolidado = array();
                 $sql = '';
                 $parametros_array = array();

                 if(array_key_exists('consultar', $array_post)){

                    $main_sql = "SELECT COUNT(*) AS TOTAL_DIA,  re.fecha AS FECHA
                                   FROM reporte_diario rd, reporte_diario_enc re
                                   WHERE rd.reporte_id = re.id
                                   AND re.usuario = :coordinador
                                   AND re.fecha BETWEEN :FECHA_1 AND DATE_ADD(:FECHA_2, INTERVAL 1 DAY)
                                   GROUP BY re.fecha
                                    ";

                    $main_sql_2 = "SELECT n.nombre AS NOVEDAD ,COUNT(*) AS CANTIDAD
                                    FROM reporte_diario rd, sucursal s, cliente c, novedad n, reporte_diario_enc rde
                                   WHERE s.id = rd.sucursal_id
                                   AND s.nit = c.nit
                                   AND rde.id = rd.reporte_id
                                   AND n.id = rd.novedad_id
                                   ".$sql.' GROUP BY n.nombre';

                    $main_sql_3 = "SELECT DISTINCT (s.nombre) AS SUCURSAL, s.id AS ID_SUCURSAL
                                    FROM reporte_diario rd, sucursal s, cliente c, novedad n, reporte_diario_enc rde
                                   WHERE s.id = rd.sucursal_id
                                   AND s.nit = c.nit
                                   AND rde.id = rd.reporte_id
                                   AND n.id = rd.novedad_id
                                   ".$sql;
                   $main_sql_4 = "SELECT rd.usuario AS NOVEDAD ,COUNT(*) AS CANTIDAD
                    FROM reporte_diario rd, reporte_diario_enc rde
                   WHERE   rde.id = rd.reporte_id

                   ".$sql.' GROUP BY rd.usuario';

                     //$primaryCommand2 = $primaryConnection->createCommand($main_sql_2);
                     $primaryCommand3 = $primaryConnection->createCommand($main_sql);
                     //$primaryCommand4 = $primaryConnection->createCommand($main_sql_3);
                     //$primaryCommand5 = $primaryConnection->createCommand($main_sql_4);
                     $parametros_array = array();
                     $dias = 0;

                     if(array_key_exists('fecha_inicial', $array_post) && array_key_exists('fecha_final', $array_post)){

                            if($array_post['fecha_inicial'] != '' && $array_post['fecha_final'] != ''){

                                $parametros_array[':FECHA_1'] = $array_post['fecha_inicial'];
                                $parametros_array[':FECHA_2'] = $array_post['fecha_final'];
                                $parametros_array[':coordinador'] = $array_post['coordinador'];
                                $selected_coor = $array_post['coordinador'];
                                $fecha_i = $array_post['fecha_inicial'];
                                $fecha_f = $array_post['fecha_final'];
                                $dias   = (strtotime($fecha_i)-strtotime($fecha_f))/86400;
                                $dias   = abs($dias);
                                $dias = floor($dias) + 1;
                                $consolidado = $primaryCommand3->bindValues($parametros_array)->queryAll();


                            }else{

                                $consolidado = array();
                            }


                     }else{

                        $consolidado = array();
                     }



                      $total = $dias;





                      foreach ($consolidado as $key) {

                          $contador_dias_reporte = $contador_dias_reporte + 1;
                      }

                      /*detalle de sucursales*/
                     // $total_sucursales =  $primaryCommand4->bindValues($parametros_array)->queryAll();

                   $consultar =  '1';

                 }

                return $this->render('instalaciones', [
                        'model' => 'a',
                        'coord' => $selected_coor,
                        'consultar' => $consultar,
                        'total' => $total,
                        'total_realizado' => $contador_dias_reporte,
                        'consolidado' => $consolidado,
                        'sql' => $parametros_array,
                        'usuarios' => $coordinadores,
                        //'detalle_consolidado' => $detalle_consolidado,
                    ]);

            }
        
    /*public function Apikontrolid($form,$start){
        $username="juandelgado@cvsc.com.co";
        $password="colviseg";
        $client = new Client(['baseUrl' => 'https://app.kontrolid.com/api/v1/data/'.$form.'?start='.$start]);
        $request = $client->createRequest()
        ->setHeaders(['content-type' => 'application/json']);
        
        $request->headers->set('Authorization', 'Basic ' . base64_encode("$username:$password"));

        $response = $request->send();

        $data=$response->getData();

        return $data;
        
    }*/

    public function Apikontrolid($form,$start){
        $username="juandelgado@cvsc.com.co";
        $password="colviseg";

        $client=curl_init();
        curl_setopt_array($client, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 1,
            //CURLOPT_VERBOSE        => 1,
            //CURLOPT_POST => 1,
            CURLOPT_URL => 'https://app.kontrolid.com/api/v1/data/'.$form.'?start='.$start,
            CURLOPT_USERPWD => ''.$username.':'.$password.'',
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_SSL_VERIFYPEER => false
            
        ));

        $response = curl_exec($client);

        curl_close($client);

        $data=json_decode($response);

        return $data;

    }

    public function actionInsertarcapacitaciones(){
        $last_key = ReporteDiario::find()->max('app_id_cap');
        $apidata=$this->Apikontrolid('s111_2641',$last_key);
        /*echo "<pre>";
        print_r($apidata);
        echo "</pre>";*/
        $contador=0;
        foreach ($apidata as $key => $value) {
            //echo $value->User."-".$value->HoraLocal."<br>";
            $usuario=Usuario::find()->where('email="'.$value->User.'" ')->one();      
            if($usuario!=null){
                $fecha_fin_array = explode(' ', $value->HoraLocal);
                $fecha=date('Y-m-d',strtotime($fecha_fin_array[0]));
                $hora = $fecha_fin_array[1];
                $id_reporte = ReporteDiarioEnc::find()->where(['usuario' => $usuario->usuario,'fecha' =>$fecha])->one(); 
                if($id_reporte!=null){
                   
                    $modelo_novedad = new ReporteDiario();
                    

                    $motivo = '<h3>Motivo</h3><h4>'.$value->Motivo.'</h4>';
                    $objetivo = '<h3>Objetivo</h3><h4>'.$value->Objetivo.'</h4>';
                    $lugar = '<h3>Lugar</h3><h4>'.$value->Lugar.'</h4>';
                    $instructor = '<h3>Instructor</h3><h4>'.$value->Instructor.'</h4>';
                    $observaciones = '<h3>Observaciones</h3><p>'.$value->Observaciones.'</p>';
                    $recomendaciones = '<h3>Recomendaciones</h3><p>'.$value->Recomendaciones.'</p>';
                    $compromisos = '<h3>Compromisos</h3><p>'.$value->Compromisos.'</p>';

                    $texto = $motivo.$objetivo.$lugar.$instructor.$observaciones.$recomendaciones.$compromisos;

                    if($value->CodSuc!=null){
                        $modelo_novedad->setAttribute('novedad_id',17);
                        $modelo_novedad->setAttribute('sucursal_id',$value->CodSuc);
                        $modelo_novedad->setAttribute('fecha_registro',$fecha);
                        $modelo_novedad->setAttribute('estado_id',5);
                        $modelo_novedad->setAttribute('reporte_id',$id_reporte->id);
                        $modelo_novedad->setAttribute('hora',$hora);
                        $modelo_novedad->setAttribute('app_id_cap',$value->prikey);
                        $modelo_novedad->setAttribute('archivo',$value->Foto1);
                        $modelo_novedad->setAttribute('observacion',$texto);
                        
                        if($modelo_novedad->save()){
                          
                          $contador++;

                        }
                    }
                }
            }
            //echo date('Y-m-d',strtotime($fecha_fin_array[0]))."<br>";
            

        }

        echo $contador.' Registros insertados';
        
    }

    public function actionInsertarvisitacliente(){
        $last_key = ReporteDiario::find()->max('app_id_visita_cliente');
        $apidata=$this->Apikontrolid('s111_4910',$last_key);
        echo "<pre>";
        print_r($apidata);
        echo "</pre>";
        $contador=0;
        foreach ($apidata as $key => $value) {
            $usuario=Usuario::find()->where('email="'.$value->User.'" ')->one();      
            if($usuario!=null){
                $fecha_fin_array = explode(' ', $value->HoraLocal);
                $fecha=date('Y-m-d',strtotime($fecha_fin_array[0]));
                $hora = $fecha_fin_array[1];
                $id_reporte = ReporteDiarioEnc::find()->where(['usuario' => $usuario->usuario,'fecha' =>$fecha])->one(); 
                if($id_reporte!=null){
                    $modelo_novedad = new ReporteDiario();
                    $contacto = '<h3>Contacto</h3><h4>'.$value->Contacto.'</h4>';
                    $comentarios = '<h3>Comentarios</h3><p>'.$value->Comentarios.'</p>';
                    $recomendaciones = '<h3>Recomendaciones</h3><p>'.$value->Recomendaciones.'</p>';
                    $texto = $contacto.$comentarios.$recomendaciones;

                    if($value->CodSuc!=null){
                        $modelo_novedad->setAttribute('novedad_id',18);
                        $modelo_novedad->setAttribute('sucursal_id',$value->CodSuc);
                        $modelo_novedad->setAttribute('fecha_registro',$fecha);
                        $modelo_novedad->setAttribute('estado_id',5);
                        $modelo_novedad->setAttribute('reporte_id',$id_reporte->id);
                        $modelo_novedad->setAttribute('hora',$hora);
                        $modelo_novedad->setAttribute('app_id_cap',0);
                        $modelo_novedad->setAttribute('app_id_visita_cliente',$value->prikey);
                        $modelo_novedad->setAttribute('archivo',$value->FirmaRecibe);
                        $modelo_novedad->setAttribute('observacion',$texto);
                        
                        if($modelo_novedad->save()){
                          
                          $contador++;

                        }
                    }

                }
            }
        }
         echo $contador.' Registros insertados';
    }

    /*************************************************************************************/


    public function actionHola(){
        echo "HOLA MUNDO";
    }
}
