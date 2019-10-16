<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Growl;



$permisos = array();


if( isset(Yii::$app->session['permisos']) ){

  $permisos = Yii::$app->session['permisos'];

}

/* @var $this yii\web\View */
/* @var $model app\models\Preaviso */
/* @var $form yii\widgets\ActiveForm */

?>
<!-- AQUI ESTAVA EL NAV -->
<div class="container" style="margin-top:5px;padding-top:5px;">
<div class="row">
<!-- <div class="col-md-2">
            <ul class="nav nav-pills nav-stacked">

               <li class="active"><?php echo Html::a('<i class="fa fa-home fa-fw"></i>Home',Yii::$app->request->baseUrl.'/site/start');?></li>
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
               <li ><?php echo Html::a('<i class="fa fa-dot-circle-o fa-fw"></i>Indicadores',Yii::$app->request->baseUrl.'/site/indicadores');?></li>
               <?php endif;?>      
               <?php if(in_array("juntas", $permisos)):?>
               <li ><?php echo Html::a('<i class="fa fa-dot-circle-o fa-fw"></i>Juntas',Yii::$app->request->baseUrl.'/junta/index');?></li>
               <?php endif;?>
               <?php if(in_array("armamento", $permisos)):?>
               <li ><?php echo Html::a('<i class="fa fa-dot-circle-o fa-fw"></i>Armas',Yii::$app->request->baseUrl.'/arma/index');?></li>
               <?php endif;?>         
               <li><?php echo Html::a('<i class="fa fa-sign-out fa-fw"></i>Salir',Yii::$app->request->baseUrl.'/site/salir');?></li>                
  
                     
            </ul>
        </div> -->  
<div class="col-md-12">

    <div class="row">
         
      <?php if(in_array("clientes", $permisos)):?>

        <div class="col-md-4">

           <div class="card">

                <div class="card-image">
                  

                    <a href="<?php echo Yii::$app->request->baseUrl.'/cliente/index';?>"><img class="img-responsive" src="<?php echo Yii::$app->request->baseUrl.'/img/clientes.png';?>"></a>
                    


                </div>

                <div class="card-content">   
                  
                  <p>Clientes</p>

                </div>
             

           </div>

          
        </div>

      <?php endif;?>
       
      <?php if(in_array("reporte diario", $permisos)):?>
        
        <div class="col-md-4">

           <div class="card">

                <div class="card-image">
                  

                    <a  href="<?php echo Yii::$app->request->baseUrl.'/reporte-diario-enc/index';?>"><img  class="img-responsive" src="<?php echo Yii::$app->request->baseUrl.'/img/reporte.png';?>"></a>
                    


                </div>

                <div class="card-content">   
                  
                  <p>Reportes Diarios</p>

                </div>
             

           </div>

          
        </div>

      <?php endif;?>

        <?php if(in_array("visita tecnica", $permisos)):?>

         <div class="col-md-4">

           <div class="card">

                <div class="card-image">
                  

                    <a  href="<?php echo Yii::$app->request->baseUrl.'/visita/index';?>"><img  class="img-responsive" src="<?php echo Yii::$app->request->baseUrl.'/img/visita.png';?>"></a>
                    


                </div>

                <div class="card-content">   
                  
                  <p>Visitas</p>

                </div>
             

           </div>

          
        </div>

      <?php endif;?>

    </div>

    <div class="row">

       <?php if(in_array("empleados", $permisos)):?>

        <div class="col-md-4">

           <div class="card">

                <div class="card-image">
                  

                    <a  href="<?php echo Yii::$app->request->baseUrl.'/site/empleados';?>"><img  class="img-responsive" src="<?php echo Yii::$app->request->baseUrl.'/img/empleados.png';?>"></a>
                    

                </div>

                <div class="card-content">   
                  
                  <p>Empleados</p>

                </div>
             

           </div>

          
        </div>

      <?php endif;?>

      

    </div>


    <?php
          
       
      foreach($contactos as $key){

         echo Growl::widget([
            'type' => Growl::TYPE_INFO,
            'title' => 'Aviso de Cumpleaños!',
            'icon' => 'glyphicon glyphicon-info-sign',
            'body' => $key->nombres.' '.$key->apellidos.' contacto de la sucursal '.$key->sucursal->nombre.' cumple el día '.$key->cumpleano,
            'showSeparator' => true,
            'delay' => false,
            'pluginOptions' => [
                'showProgressbar' => false,
                'placement' => [
                    'from' => 'top',
                    'align' => 'right',
                ],
                'timer' => 12000,
            ]
        ]);

      }

      
      echo Growl::widget([
            'type' => Growl::TYPE_INFO,
            'title' => 'Cursos a vencer',
            'icon' => 'glyphicon glyphicon-info-sign',
            'body' => 'Hay un total de '.$num_cursos.' cursos por vencerse',
            'showSeparator' => true,
            'delay' => false,
            'pluginOptions' => [
                'showProgressbar' => false,
                'placement' => [
                    'from' => 'top',
                    'align' => 'right',
                ],
                'timer' => 12000,
            ]
        ]);
          

    ?>

    
   
</div>
</div>
</div>
