
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\Preaviso */
/* @var $form yii\widgets\ActiveForm */
//var_dump($sucursales);


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
        </div> -->  
<div class="col-md-12">
<div class="preaviso-form check-form">

<div class="form-group">
<?= Html::a('<i class="fa fa-arrow-left"></i>',Yii::$app->request->baseUrl.'/cliente/index',['class'=>'btn btn-primary']) ?>

<?= Html::a('<i class="fa fa-plus"></i>',Yii::$app->request->baseUrl.'/informe-gestion/create?id='.$_GET['id'],['class'=>'btn btn-primary pull-right']) ?>
     
</div>

<div class="row bottom">

    <h3 style="text-align: center;">Informes de Gestión</h3>    
</div>
   
<?php $form = ActiveForm::begin(['class' => 'check-form']); ?>
<table class="display my-data" data-page-length='50' cellspacing="0" width="100%">

  <thead>
    
    <tr>
       <th></th>
       <th>Fecha Informe</th>
       <th>Fecha Registro</th>             
       <th>Titulo</th>      
       <th>Descripción</th>

       <th>Cliente</th>       
       <th></th>
                     
    </tr>

  </thead>

  <tbody>
    
<?php
  
  foreach ($informes as $value) {
?>
    <tr>
       
      <td><?=Html::a('<i class="fa fa-remove fa-fw"></i>',Yii::$app->request->baseUrl.'/informe-gestion/empanada?id='.$value->id)?></td> 
      <td><?=$value->fecha?></td>       
      <td><?=$value->fecha_registro?></td>       
      <td><?=$value->titulo?></td>
      <td><?=$value->descripcion?></td> 
      <td><?=$value->cliente2->nombre?></td>              
       
      <td>

        <?php 
            
             if($value->archivo != null && $value->archivo != ''){


                $file = Yii::$app->request->baseUrl.$value->archivo;

                      echo ' 
                             <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modal-'.$value->id.'">
                             Mostrar
                             </button>';

                         // echo '<img alt="Evidencia" class="img-responsive img-thumbnail" src="'.Yii::$app->request->baseUrl.$value->archivo.'"/>';
                         Modal::begin([

                          'header' => '<h4>Informe de Gestión </h4>',
                          'id' => 'modal-'.$value->id,
                          'size' => 'modal-lg',

                          ]);

                          

                            echo '<div id="scroller">
                            <iframe src="http://docs.google.com/gview?url=http://181.49.3.226:1580'.$file.'&embedded=true" width="100%" height="600px" scrolling="auto"> </iframe>
                            </div>';

                         Modal::end();


             }



        ?>


      </td>            
    </tr>
<?php
  }
?>
  </tbody>
</table>
<?php ActiveForm::end(); ?>

</div>
</div>


