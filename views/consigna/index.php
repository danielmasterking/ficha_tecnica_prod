<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Preaviso */
/* @var $form yii\widgets\ActiveForm */
//var_dump($sucursales);

$permisos = array();

if( isset(Yii::$app->session['permisos']) ){

  $permisos = Yii::$app->session['permisos'];

}


$sucursal = array();

if(isset($estudios) && count($estudios) > 0){
   
   $sucursal = $estudios[0]['sucursal'];

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
               <li><?php echo Html::a('<i class="fa fa-sign-out fa-fw"></i>Salir',Yii::$app->request->baseUrl.'/site/logout');?></li>                
  
            </ul>
        </div>   -->
<div class="col-md-12">
<div class="preaviso-form check-form">



<div class="form-group">
<?= Html::a('<i class="fa fa-arrow-left"></i>',Yii::$app->request->baseUrl.'/sucursal/index?id='.$nit,['class'=>'btn btn-primary']) ?>
<p class="col-md-1"></p>
<?= Html::a('<i class="fa fa-lock"></i>',Yii::$app->request->baseUrl.'/estudio-seguridad/index?id='.$id,['title' => 'Estudio de Seguridad','class'=>'btn btn-primary']) ?>
<?= Html::a('<i class="fa fa-exclamation-triangle"></i>',Yii::$app->request->baseUrl.'/factor-riesgo/index?id='.$id,['title' => 'factores de factor-riesgo','class'=>'btn btn-primary']) ?>
<?= Html::a('<i class="fa fa-eye"></i>',Yii::$app->request->baseUrl.'/sucursal/view?id='.$id,['title' => 'Información','class'=>'btn btn-primary']) ?>

<?= Html::a('<i class="fa fa-plus"></i>',Yii::$app->request->baseUrl.'/consigna/create?id='.$id,['class'=>'btn btn-primary pull-right']) ?>
    
</div>

<div class="row bottom">

    <h3 class="col-md-offset-4">Consignas</h3>
    
</div>

<div class="row">

      <?php if(count($sucursal) > 0): ?>
          <p class="col-md-2"><strong>Nombre Cliente: </strong></p>
          <p class="col-md-4"></p>
          <p class="col-md-2"><strong>Sucursal: </strong></p>
          <p class="col-md-4"><?= $sucursal['nombre']?></p>
         <?php endif; ?>


</div>

   
<?php $form = ActiveForm::begin(['class' => 'check-form']); ?>
<table class="display my-data" data-page-length='50' cellspacing="0" width="100%">

  <thead>
    
    <tr>
       <th></th>
       
       <th>Fecha</th>
       <th>Consigna</th>
       
       <th>Descripción</th>
              
    </tr>


  </thead>


  <tbody>
    
<?php
  
  foreach ($consignas as $key => $value) {
?>
    <tr>
       <td><?=Html::a('<i class="fa fa-remove fa-fw"></i>',Yii::$app->request->baseUrl.'/consigna/empanada?id='.$value['id'],['data-method' => 'post'])?></td></td> 
       <td><?=$value['fecha']?></td>
       <td><?=Html::a('<i class="fa fa-download fa-fw"></i>',Yii::$app->request->baseUrl.'/estudio-seguridad/viewpdf?id=http://181.49.3.226:1580'.Yii::$app->request->baseUrl.$value['archivo'].'&sucursal='.$nit,['title' => 'Descargar'])?></td>       
       <td><?=$value['descripcion']?></td>      
       
    </tr>

<?php

  }
?>
  </tbody>

</table>

<?php ActiveForm::end(); ?>

</div>
</div>


