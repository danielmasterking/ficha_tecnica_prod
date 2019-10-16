<?php
use kartik\widgets\DepDrop ;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;
use app\models\Cliente;
use yii\web\JsExpression;
use miloschuman\highcharts\Highcharts;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\Preaviso */
/* @var $form yii\widgets\ActiveForm */

$permisos = array();

if( isset(Yii::$app->session['permisos']) ){

  $permisos = Yii::$app->session['permisos'];

}




?>
<!-- <nav class="navbar navbar-default" role="navigation">
  
  <div class="navbar-header">

  </div>

  <div class="collapse navbar-collapse navbar-ex1-collapse">


    <ul class="nav navbar-nav navbar-right">


      <?php if(isset(Yii::$app->session['usuario'])):?>
        <li>
             <?php

                echo Html::a('<i class="fa fa-lock"></i> Cambiar Clave',Yii::$app->request->baseUrl.'/site/cambio');


             ?>
        </li>
        <li><a href="#"> Bienvenido, <strong><?= Yii::$app->session['usuario']?></strong></a></li>
      <?php endif;?>

    </ul>
  </div>
</nav> -->


       <!--  <div class="col-md-2">
            <ul class="nav nav-pills nav-stacked">

               <li ><?php echo Html::a('<i class="fa fa-home fa-fw"></i>Home',Yii::$app->request->baseUrl.'/site/start');?></li>
               <?php if(in_array("clientes", $permisos)):?>
               <li ><?php echo Html::a('<i class="fa fa-user fa-fw"></i>Clientes',Yii::$app->request->baseUrl.'/cliente/index');?></li>
               <?php endif;?>
               <?php if(in_array("empleados", $permisos)):?>
               <li ><?php echo Html::a('<i class="fa fa-suitcase fa-fw"></i>Empleados',Yii::$app->request->baseUrl.'/site/empleados');?></li>
               <?php endif;?>
               <?php if(in_array("reporte diario", $permisos)):?>
               <li ><?php echo Html::a('<i class="fa fa-users fa-fw"></i>Reporte Diario',Yii::$app->request->baseUrl.'/reporte-diario-enc/index');?></li>
               <?php endif;?>
                <?php if(in_array("visita tecnica", $permisos)):?>
               <li ><?php echo Html::a('<i class="fa fa-users fa-fw"></i>Visita Técnica',Yii::$app->request->baseUrl.'/visita/index');?></li>
               <?php endif;?>
               <?php if(in_array("usuarios", $permisos)):?>
               <li ><?php echo Html::a('<i class="fa fa-users fa-fw"></i>Usuarios',Yii::$app->request->baseUrl.'/usuario/index');?></li>
               <?php endif;?>
               <?php if(in_array("ciudades", $permisos)):?>
               <li ><?php echo Html::a('<i class="fa fa-flag fa-fw"></i>Ciudades',Yii::$app->request->baseUrl.'/ciudad/index');?></li>
               <?php endif;?>
               <?php if(in_array("ccosto", $permisos)):?>
               <li ><?php echo Html::a('<i class="fa fa-dot-circle-o fa-fw"></i>CCostos',Yii::$app->request->baseUrl.'/ccosto/index');?></li>
               <?php endif;?>
               <?php if(in_array("novedades", $permisos)):?>
               <li ><?php echo Html::a('<i class="fa fa-dot-circle-o fa-fw"></i>Novedades',Yii::$app->request->baseUrl.'/novedad/index');?></li>
               <?php endif;?>
               <?php if(in_array("estados", $permisos)):?>
               <li ><?php echo Html::a('<i class="fa fa-dot-circle-o fa-fw"></i>Estados',Yii::$app->request->baseUrl.'/estado/index');?></li>
               <?php endif;?>
               <?php if(in_array("roles", $permisos)):?>
               <li ><?php echo Html::a('<i class="fa fa-dot-circle-o fa-fw"></i>Roles',Yii::$app->request->baseUrl.'/rol/index');?></li>
               <?php endif;?>
               <?php if(in_array("permisos", $permisos)):?>
               <li ><?php echo Html::a('<i class="fa fa-dot-circle-o fa-fw"></i>Permisos',Yii::$app->request->baseUrl.'/permiso/index');?></li>
               <?php endif;?>
               <?php if(in_array("indicadores", $permisos)):?>
               <li class = "active"><?php echo Html::a('<i class="fa fa-dot-circle-o fa-fw"></i>Indicadores',Yii::$app->request->baseUrl.'/site/indicadores');?></li>
               <?php endif;?>
               <?php if(in_array("juntas", $permisos)):?>
               <li ><?php echo Html::a('<i class="fa fa-dot-circle-o fa-fw"></i>Juntas',Yii::$app->request->baseUrl.'/junta/index');?></li>
               <?php endif;?>
               <?php if(in_array("armamento", $permisos)):?>
               <li ><?php echo Html::a('<i class="fa fa-dot-circle-o fa-fw"></i>Armas',Yii::$app->request->baseUrl.'/arma/index');?></li>
               <?php endif;?>
               <li><?php echo Html::a('<i class="fa fa-sign-out fa-fw"></i>Salir',Yii::$app->request->baseUrl.'/site/logout');?></li>


            </ul>
        </div> -->
<div class="col-md-12">
<div class="ccosto-create">

<?php $form = ActiveForm::begin(); ?>

<?php

  //var_dump($sql);
?>

<div class="form-group">

    <?= Html::a('<i class="fa fa-arrow-left"></i>',Yii::$app->request->baseUrl.'/site/indicadores',['class'=>'btn btn-primary']) ?>

</div>

<h3 style="text-align: center;">Visitas Técnicas Realizadas Por Coordinadores</h3>

<div class="row">

   <div class="col-md-3">


   <?php


     echo DateControl::widget([
    'name'=>'fecha_inicial',
    'type'=>DateControl::FORMAT_DATE,
    'autoWidget' => true,

    'displayFormat' => 'php:Y-m-d',
    'saveFormat' => 'php:Y-m-d'

   ]);



   ?>


   </div>

   <div class="col-md-3">

      <?php

     echo DateControl::widget([
                                'name'=>'fecha_final',
                                'type'=>DateControl::FORMAT_DATE,
                                'autoWidget'=>true,
                                'displayFormat' => 'php:Y-m-d',
                                'saveFormat' => 'php:Y-m-d'
                                 ]);

      ?>

   </div>

   <div class="col-md-3">

     <?php

        $data_usuarios = array();

          foreach ($usuarios as $key ) {

              $data_usuarios[$key->usuario] = $key->usuario;//$key->usuario->nombres.' '.$key->usuario->apellidos;
         }

          echo Select2::widget([
              'name' => 'coordinador',
              'data' => $data_usuarios,
              'options' => [
                  'id' => 'coordinador',
                  //'placeholder' => 'Seleccione usuario'

              ],


             ]);

    ?>
   </div>

   <div class="col-md-3">


     <input type="submit" name="consultar" class="btn btn-primary" value="Consultar" />



   </div>


</div>


<p>&nbsp;</p>


    <?php

    if($total > 0){


      $data = array();
      $labels = array();
      $label_cant = array();
      $val = ($total_realizado/$total) * 100;
      if($val > 100){

        $val = 100;
      }

      $can = $total_realizado * 1;
      $tmp = array('Visitas Realizadas %',$val);
      $data [] = $tmp;
      $sin_realizar = $total - $total_realizado;
      if($sin_realizar < 0){

        $sin_realizar = 0;

      }
      $val = ($sin_realizar/$total) * 100;

      echo "<p>";
      echo "<strong>Meta de Visitas: </strong>".$total;
      echo "</p>";
      echo "<p>";
      echo "<strong>Total de Visitas realizadas por Coordinador ".$coord.": </strong>".$total_realizado;
      echo "</p>";

      $tmp = array('VISITAS SIN REALIZAR %',$val);
      $data [] = $tmp;

      $string = '[';
      foreach ($consolidado as $key) {

        $can = $key['TOTAL_VISITAS'] * 1;

        $labels [] = $key['FECHA'];
        $label_cant [] = array($key['FECHA'],$can);

        $string .= $key['TOTAL_VISITAS'].',';

      }

      $string = substr($string, 0,strlen($string) - 1);
      $string .= ']' ;

       echo Highcharts::widget([
                    'scripts' => [
                    'modules/exporting',
                    'themes/grid-light',
                ],
                'options' => [
                    'title' => ['text' => 'Indicador de Visitas Técnicas Operativas Por Coordinador'],
                    'plotOptions' => [
                        'pie' => [
                            'cursor' => 'pointer',
                        ],

                    ],
                    'series' => [
                        [ // new opening bracket
                            'type' => 'pie',
                            'name' => '% de Cumplimiento',
                            'data' => $data,
                        ] // new closing bracket
                    ],
                ],
            ]);


              ?>

      <div class="row">

            <?php


echo Highcharts::widget([
    'scripts' => [
        'modules/exporting',
        'themes/grid-light',
    ],
    'options' => [

        'chart' => [
          'type' => 'bar',
        ],
        'title' => [
            'text' => 'Visitas Técnicas',
        ],
        'legend' => [
           'layout' => 'horizontal',
        ],
        'xAxis' => [
            'categories' => $labels,
        ],

        'series' => [
            [
                'type' => 'column',
                'name' => 'Cantidad de visitas técnicas por día',
                'data' => $label_cant,
            ],


        ],
    ]
]);


            ?>


         </div>

            <?php

    }else{

      ?>

      <div class="alert alert-warning">

        Sin datos para mostrar

      </div>


      <?php
    }

    ?>


  <?php ActiveForm::end(); ?>

  <?php

 //   var_dump($detalle_consolidado);

  ?>



</div>

</div>

