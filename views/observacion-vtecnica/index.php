<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Preaviso */
/* @var $form yii\widgets\ActiveForm */
//var_dump($sucursales);

$permisos = array();
$id = '';

if($v_tecnica_model != null){
  
  $id = $v_tecnica_model->id;
  
}

if( isset(Yii::$app->session['permisos']) ){

  $permisos = Yii::$app->session['permisos'];

}


$sucursal = array();

if(isset($estudios) && count($estudios) > 0){
   
   $sucursal = $estudios[0]['sucursal'];

}

?>
<nav class="navbar navbar-default" role="navigation">
  <!-- El logotipo y el icono que despliega el menú se agrupan
       para mostrarlos mejor en los dispositivos móviles -->
  <div class="navbar-header">

  </div>
 
  <!-- Agrupar los enlaces de navegación, los formularios y cualquier
       otro elemento que se pueda ocultar al minimizar la barra -->
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
</nav>

<div class="container" style="margin-top:5px;padding-top:5px;">
    <div class="row">
        <div class="col-md-2">
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
        </div>  
<div class="col-md-10 well">
<div class="preaviso-form check-form">
<?= Html::a('<i class="fa fa-arrow-left"></i>',Yii::$app->request->baseUrl.'/visita/index',['class'=>'btn btn-primary']) ?>
<?= Html::a('<i class="fa fa-plus"></i>',Yii::$app->request->baseUrl.'/observacion-vtecnica/create?id='.$id,['class'=>'btn btn-primary pull-right']) ?>
<div class="row bottom">

    <h3 class="col-md-offset-4">Evidencias</h3>
    
</div>
   
<?php $form = ActiveForm::begin(['class' => 'check-form']); ?>
<table class="display my-data" data-page-length='50' cellspacing="0" width="100%">

  <thead>
    
    <tr>
       <th></th>
       
       <th>Elemento</th>
       <th>Soporte</th>
       <th>Descripción</th>
       
       
       
    </tr>


  </thead>


  <tbody>
    
<?php
  
  foreach ($observaciones as $key ) {
    
    $ruta = $key->archivo == null ? ' ' : $key->archivo;
    $ruta = Yii::$app->request->baseUrl.$ruta; 
?>
    <tr>
       <td><?=Html::a('<i class="fa fa-remove fa-fw"></i>',Yii::$app->request->baseUrl.'/observacion-vtecnica/empanada2?id='.$key->id)?></td></td> 
       <td><?= $key->elemento?></td>
       <td><img alt="imagen" class="img-responsive img-thumbnail" src="<?= $ruta ?>" /></td>
              
       <td><?=$key->descripcion?></td>      
       
    </tr>

<?php

  }
?>
  </tbody>

</table>

<?php ActiveForm::end(); ?>

</div>
</div>
</div>
</div>

