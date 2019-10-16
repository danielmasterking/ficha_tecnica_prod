<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Preaviso */
/* @var $form yii\widgets\ActiveForm */

$permisos = array();
$this->title="Visita";
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


        <!-- <div class="col-md-2">
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
               <li class="active"><?php echo Html::a('<i class="fa fa-users fa-fw"></i>Visita Técnica',Yii::$app->request->baseUrl.'/visita/index');?></li>
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
<div class="ccosto-create">
    <div class="form-group">

    <?= Html::a('<i class="fa fa-plus"></i>',Yii::$app->request->baseUrl.'/visita/create',['class'=>'btn btn-primary']) ?>
    <?= Html::a('<i class="fa fa-eye"> Mis visitas realizadas</i>',Yii::$app->request->baseUrl.'/visita/visitas',['class'=>'btn btn-primary pull-right']) ?>
        
    </div>
   
   <?php if(isset($status) && $status == '200'):?>
    <p class="alert alert-success">
       Visita Creada y asignada de forma satisfactoria. 
    </p>
  <?php endif;?>
<div class="table-responsive"> 
    <table class="table display my-data" data-page-length='50' cellspacing="0" width="100%">

        <thead>

           <tr>

             <th>Número</th>
             <th>Fecha</th>
             <th>Cliente</th>
             <th>Sucursal</th>
             <th>Asignada a </th>
             <th>Estado</th>
             <th>Detalle</th>
             

           </tr>
          

        </thead>

        <tbody>

             <?php foreach($visitas as $key):?>

                 <tr>

                    <td><?= $key->id ?></td>
                    <td><?= $key->fecha ?></td>
                    <td><?= $key->sucursal->cliente->nombre ?></td>
                    <td><?= $key->sucursal->nombre ?></td>
                    <td><?= $key->usuario ?></td>
                    <td><?= $key->estado->nombre ?></td>
                    <td><?= Html::a('<i class="fa fa-eye fa-fw"></i>',Yii::$app->request->baseUrl.'/visita/update?id='.$key->id.'&flag=s') ?>
                        <?php
                           if(strpos($key->novedad->nombre,'Técnica') !== false){
                             
                            echo  Html::a('<i class="fa fa-plus fa-fw"></i>',Yii::$app->request->baseUrl.'/observacion-vtecnica/index?id='.$key->id);
                             
                           }
                        ?>
                    
                    </td>
                   

                 </tr>

             <?php endforeach;?>
          

        </tbody>
      

    </table>
</div>
</div>

</div>

