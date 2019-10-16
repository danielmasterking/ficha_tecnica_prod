<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Preaviso */
/* @var $form yii\widgets\ActiveForm */
//var_dump($sucursales);

$nombre_cliente = '';

$permisos = array();

if( isset(Yii::$app->session['permisos']) ){

  $permisos = Yii::$app->session['permisos'];

}





$memorias = array();

$tamano_sucursales_usuario = count($sucursales_usuario);
$tamano_ciudades_usuario = count($ciudades_usuario);

foreach ($sucursales as $key) {
  
  
  $tempo = $key->memorias;

  foreach ($tempo as $key2 ) {

    
      
      $memorias [] = $key2;
    
  }

}

if(count($memorias) > 0){

  $nombre_cliente = $memorias[0]->sucursal->cliente->nombre;


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
        </div>  --> 
<div class="col-md-12">
<div class="preaviso-form check-form">

  <div class="bottom">

     <ul class="nav nav-tabs nav-justified">
     <li role="presentation" ><?php echo Html::a('Sucursales',Yii::$app->request->baseUrl.'/sucursal/index?id='.$nit); ?></li>
     <li role="presentation" ><?php echo Html::a('Visitas Técnicas',Yii::$app->request->baseUrl.'/visita/detalle?id='.$nit); ?></li>
     <li role="presentation" ><?php echo Html::a('Facturación',Yii::$app->request->baseUrl.'/cliente/facturacion?id='.$nit); ?></li>
     <li role="presentation" class="active"><?php echo Html::a('Memoria',Yii::$app->request->baseUrl.'/memoria/index?id='.$nit); ?></li>
     <li role="presentation" ><?php echo Html::a('Novedades',Yii::$app->request->baseUrl.'/reporte-diario/detalle?id='.$nit); ?></li>
   </ul>
     
   </div>


<div class="form-group">

<?= Html::a('<i class="fa fa-plus"></i>',Yii::$app->request->baseUrl.'/memoria/create?id='.$nit,['class'=>'btn btn-primary']) ?>
    
</div>

<div class="row bottom">

    <h3 class="col-md-offset-4">Memorias <?= $nombre_cliente ?> </h3>
    

</div>


   
<?php $form = ActiveForm::begin(['class' => 'check-form']); ?>
<div class="table-responsive"> 
<table class="display my-data" data-page-length='50' cellspacing="0" width="100%">

  <thead>
    
    <tr>
       <th>Archivo</th>
       
       <th>Fecha</th>
       <th>Sucursal</th>
       
       <th>Descripción</th>
       <th></th>
       
       
    </tr>


  </thead>


  <tbody>
    
<?php
  
  foreach ($memorias as $key) {
?>
    <tr>
       <td><?=$key->archivo?></td>
       <td><?=$key->fecha?></td>
       <td><?=$key->sucursal->nombre?></td>
           
       <td><?=$key->descripcion?></td>      

       <td>
           <td><?=Html::a('<i class="fa fa-download fa-fw"></i>',Yii::$app->request->baseUrl.'/estudio-seguridad/viewpdf?id=http://181.49.3.226:1580'.Yii::$app->request->baseUrl.$key->archivo.'&sucursal='.$nit,['title' => 'Descargar'])?></td>
           <td><?=Html::a('<i class="fa fa-remove fa-fw"></i>',Yii::$app->request->baseUrl.'/memoria/delete?id='.$key->id,['data-method' => 'post'])?></td></td> 
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


