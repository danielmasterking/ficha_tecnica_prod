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


$cliente = array();

if(isset($sucursales) && count($sucursales) > 0){
   
   $cliente = $sucursales[0]['cliente'];

}

$ciudades = array();
foreach ($ciudades_usuario as $key ) {
  
  $ciudades [] = $key->ciudad_id;
}

$sucursales_user = array();
foreach ($sucursales_usuario as $key ) {
  
  $sucursales_user [] = $key->sucursal_id;
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
   
   <div class="bottom">

     <ul class="nav nav-tabs nav-justified">
     <li role="presentation" class="active"><?php echo Html::a('Sucursales',Yii::$app->request->baseUrl.'/sucursal/index?id='.$cliente['nit']); ?></li>
     <li role="presentation"><?php echo Html::a('Visitas Técnicas',Yii::$app->request->baseUrl.'/visita/detalle?id='.$cliente['nit']); ?></li>
     <li role="presentation"><?php echo Html::a('Facturación',Yii::$app->request->baseUrl.'/cliente/facturacion?id='.$cliente['nit']); ?></li>
     <li role="presentation"><?php echo Html::a('Memoria',Yii::$app->request->baseUrl.'/memoria/index?id='.$cliente['nit']); ?></li>
     <li role="presentation" ><?php echo Html::a('Novedades',Yii::$app->request->baseUrl.'/reporte-diario/detalle?id='.$cliente['nit']); ?></li>
   </ul>
     
   </div>

   <div>

      <h3 style="text-align: center;">Información General</h3>
      <div class="row">
         <?php if(count($cliente) > 0): ?>
          <p class="col-md-2"><strong>Nombre Cliente: </strong></p>
          <p class="col-md-4"><?= $cliente['nombre']?></p>
          <p class="col-md-2"><strong>Nit: </strong></p>
          <p class="col-md-4"><?= $cliente['nit']?></p>
         <?php endif; ?>
      </div>

      <div class="row">
         <?php if(count($cliente) > 0): ?>
          <p class="col-md-2"><strong>Ciudad: </strong></p>
          <p class="col-md-4"><?= $cliente['ciudad']?></p>
          <p class="col-md-2"><strong>Dirección: </strong></p>
          <p class="col-md-4"><?= $cliente['direccion']?></p>
         <?php endif; ?>
      </div>

      <div class="row bottom">
         <?php if(count($cliente) > 0): ?>
          <p class="col-md-2"><strong>Telefono: </strong></p>
          <p class="col-md-4"><?= $cliente['telefono']?></p>
         <?php endif; ?>
      </div>
     

   </div>
   

<?php $form = ActiveForm::begin(['class' => 'check-form']); ?>
<div class="table-responsive"> 
<table class="display my-data" data-page-length='50' cellspacing="0" width="100%">

  <thead>
    
    <tr>
       <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
       
       <th>Nombre</th>
       <th>Dirección</th>
       
       <th>Ciudad</th>
       
            
       
    </tr>


  </thead>


  <tbody>
    
<?php
  
  foreach ($sucursales as $key => $value) {
?>

   <?php if(count($sucursales_user) == 0):?>

        <?php if(in_array($value['ciudad']['id'], $ciudades)):?>
        <tr>
          <td style="width: 10%;"><?php
             
             if(in_array('temporales', $permisos)){
                  
                if($value['temporal'] == 'N'){
                  echo Html::a('<i class="fa fa-square-o"></i>&nbsp;',Yii::$app->request->baseUrl.'/sucursal/temporal?id='.$value['id'], ['title' => 'Marcar Temporal','class'=>'btn btn-primary btn-sm']);                    
                }else{
                  echo Html::a('<i class="fa fa-check-square-o"></i>&nbsp;',Yii::$app->request->baseUrl.'/sucursal/rtemporal?id='.$value['id'], ['title' => 'Quitar Temporal','class'=>'btn btn-danger btn-sm']);                  
                }
                
             }

             echo Html::a('<i class="fa fa-eye"></i>&nbsp;',Yii::$app->request->baseUrl.'/sucursal/view?id='.$value['id'], ['title' => 'Información','class'=>'btn btn-info btn-sm']);

             echo Html::a('<i class="fa fa-lock"></i>&nbsp;',Yii::$app->request->baseUrl.'/estudio-seguridad/index?id='.$value['id'], ['title' => 'Estudios de Seguridad','class'=>'btn btn-success btn-sm']);

             echo Html::a('<i class="fa fa-file-pdf-o"></i>&nbsp;',Yii::$app->request->baseUrl.'/consigna/index?id='.$value['id'], ['title' => 'Consignas','class'=>'btn btn-danger btn-sm']);

             echo Html::a('<i class="fa fa-exclamation-triangle"></i>',Yii::$app->request->baseUrl.'/factor-riesgo/index?id='.$value['id'], ['title' => 'Factores de Riesgo','class'=>'btn btn-warning btn-sm']);
           ?>
           </td>      
           
           <td style="width: 30%;"><?=$value['nombre']?></td>
           <td><?=$value['direccion']?></td>       
           <td><?=$value['ciudad']['nombre']?></td>      


        </tr>

        <?php endif;?>

  <?php elseif(in_array($value['id'], $sucursales_user)):?>

               <tr>
          <td style="width: 10%;"><?php
             
             if(in_array('temporales', $permisos)){
                  
                if($value['temporal'] == 'N'){
                  echo Html::a('<i class="fa fa-square-o"></i>&nbsp;',Yii::$app->request->baseUrl.'/sucursal/temporal?id='.$value['id'], ['title' => 'Marcar Temporal']);                    
                }else{
                  echo Html::a('<i class="fa fa-check-square-o"></i>&nbsp;',Yii::$app->request->baseUrl.'/sucursal/rtemporal?id='.$value['id'], ['title' => 'Quitar Temporal']);                  
                }
                
             }

             echo Html::a('<i class="fa fa-eye"></i>&nbsp;',Yii::$app->request->baseUrl.'/sucursal/view?id='.$value['id'], ['title' => 'Información']);
             echo Html::a('<i class="fa fa-lock"></i>&nbsp;',Yii::$app->request->baseUrl.'/estudio-seguridad/index?id='.$value['id'], ['title' => 'Estudios de Seguridad']);
             echo Html::a('<i class="fa fa-file-pdf-o"></i>&nbsp;',Yii::$app->request->baseUrl.'/consigna/index?id='.$value['id'], ['title' => 'Consignas']);
             echo Html::a('<i class="fa fa-exclamation-triangle"></i>',Yii::$app->request->baseUrl.'/factor-riesgo/index?id='.$value['id'], ['title' => 'Factores de Riesgo']);
           ?>
           </td>      
           
           <td style="width: 30%;"><?=$value['nombre']?></td>
                   <td><?=$value['direccion']?></td>       
                   <td><?=$value['ciudad']['nombre']?></td>      


               </tr>

  <?php endif;?>



<?php

  }
?>
  </tbody>

</table>
</div>
<?php ActiveForm::end(); ?>

</div>
</div>



