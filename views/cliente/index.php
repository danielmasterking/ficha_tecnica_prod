<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Preaviso */
/* @var $form yii\widgets\ActiveForm */

$permisos = array();
$this->title="Clientes";

if( isset(Yii::$app->session['permisos']) ){

  $permisos = Yii::$app->session['permisos'];

}


?>




    
        <!-- <div class="col-md-2">
            <ul class="nav nav-pills nav-stacked">
                
              <li ><?php echo Html::a('<i class="fa fa-home fa-fw"></i>Home',Yii::$app->request->baseUrl.'/site/start');?></li>
               <?php if(in_array("clientes", $permisos)):?>
               <li class="active"><?php echo Html::a('<i class="fa fa-user fa-fw"></i>Clientes',Yii::$app->request->baseUrl.'/cliente/index');?></li>
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
        </div>   -->
<div class="col-md-12 ">
<div class="preaviso-form check-form">

  <?php

     if(Yii::$app->session['usuario'] == 'admin'){
       
       echo Html::a('<i class="fa fa-sign-out fa-fw"></i>Unidad de Negocio',Yii::$app->request->baseUrl.'/unidad-negocio/index', ['class' => 'btn btn-primary']);
     }

  ?>

<?php if(Yii::$app->session->getFlash('error') !== null):?>

  <div class="alert alert-danger">
     <?= Yii::$app->session->getFlash('error'); ?>  
  </div>
  

<?php endif;?>  


   <h2 style="text-align: center;">Clientes</h2>
<?php $form = ActiveForm::begin(['class' => 'check-form']); ?>
<div class="table-responsive">
<table class="table display my-data" data-page-length='50'>

  <thead>
    
    <tr>

       <!--<th>Nit</th>-->
       <th></th>
       <th>Nombre</th>
       <th>Dirección</th>
       <th>Teléfono</th>
       <th>Ciudad</th>
       <th>Inició</th>
       <th></th>     
       
    </tr>


  </thead>


  <tbody>
    
<?php
  
  foreach ($clientes as $key ) {
?>
    <tr>
       <td><?php echo Html::a('<i class="fa fa-file fa-fw"></i>',Yii::$app->request->baseUrl.'/informe-gestion/index?id='.$key->nit,['title' => 'Informes de Gestión','class'=>'btn btn-primary btn-xs']);?></td>
       <td>

          <?php 
              
              echo Html::a($key->nombre,Yii::$app->request->baseUrl.'/sucursal/index?id='.$key->nit);

          ?>

       </td>
       
       <td><?=$key->direccion?></td>
       <td><?=$key->telefono?></td>
       <td><?=$key->ciudad?></td>
       <td><?=$key->fecha_inicio?></td>
       <td><?php

               if($key->estado == "A"){

                   echo '<span class="glyphicon glyphicon-ok" aria-hidden="true" title="Activo"></span>';

               }else{

                   echo '<span class="glyphicon glyphicon-remove" aria-hidden="true" title="No Activo"></span>';


               } 

               

        ?>

        </td>
       
       
              

    </tr>

<?php

  }
?>
  </tbody>

</table>
</div>
<?php ActiveForm::end(); ?>

</div>
</div>


