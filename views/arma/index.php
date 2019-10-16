<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Arma;

/* @var $this yii\web\View */
/* @var $model app\models\Preaviso */
/* @var $form yii\widgets\ActiveForm */

$permisos = array();
$this->title="Armas";

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
</nav>
 -->

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
               <li class="active"><?php echo Html::a('<i class="fa fa-dot-circle-o fa-fw"></i>Armas',Yii::$app->request->baseUrl.'/arma/index');?></li>
               <?php endif;?>
               <li><?php echo Html::a('<i class="fa fa-sign-out fa-fw"></i>Salir',Yii::$app->request->baseUrl.'/site/salir');?></li>                
  
            </ul>
        </div>   -->
<div class="col-md-12">
<div class="preaviso-form check-form">

<!-- Validar permiso de administración de armas para poder moodificar datos básicos -->
  <?php if(in_array("adm-armas", $permisos)):?>
    <div class="bottom">

     <ul class="nav nav-tabs nav-justified">
     <li role="presentation" ><?php echo Html::a('Tipos',Yii::$app->request->baseUrl.'/tipo-arma/index'); ?></li>
     <li role="presentation"><?php echo Html::a('calibre',Yii::$app->request->baseUrl.'/calibre/index'); ?></li>
     <li role="presentation"><?php echo Html::a('Permiso Arma',Yii::$app->request->baseUrl.'/permiso-arma/index'); ?></li>
     <li role="presentation" class="active"><?php echo Html::a('Armas',Yii::$app->request->baseUrl.'/arma/index'); ?></li>
     <li role="presentation" ><?php echo Html::a('Mover Armas',Yii::$app->request->baseUrl.'/arma/trasladar'); ?></li>
   </ul>
     
   </div>
  <?php endif;?>

<!-- fin de validación de permisos de administración de armas -->

<div class="form-group">

<?= Html::a('<i class="fa fa-plus"></i>',Yii::$app->request->baseUrl.'/arma/create',['class'=>'btn btn-primary']) ?>
    
</div>
<?php $form = ActiveForm::begin(['class' => 'check-form']); ?>

<h3 style="text-align: center;">Armas</h3>

<div class="table-responsive"> 
<table class="table display my-data2" data-page-length='50'>
  <thead>    
    <tr>  
       <th style="text-align: center;">Fecha Vencimiento</th>     
       <th style="text-align: center;">Serie</th>
       <th style="text-align: center;">Tipo</th>
       <th style="text-align: center;">Calibre</th>
       <th style="text-align: center;">Permiso</th>
       <th style="text-align: center;">#Salvoconducto</th> 
       <th style="text-align: center;">#Municiones</th> 
       <th style="text-align: center;">Ciudad</th>  
       <th style="text-align: center;">Ubicacion</th>       
       <th style="text-align: center;">Documento</th>
       <th ></th>

           
       
    </tr>


  </thead>

  <tbody>
    
<?php
  
  foreach ($armas as  $value) {
    date_default_timezone_set ( 'America/Bogota');
    $fecha_actual = date('Y-m-d',time());
    $time_actual = time();
    $tres_meses = strtotime('+3 month' , strtotime ( $fecha_actual ) );
    $dos_meses = strtotime('+2 month' , strtotime ( $fecha_actual ) );
    $un_mes = strtotime('+1 month' , strtotime ( $fecha_actual ) );
    
    $time_vencimiento = strtotime($value->vencimiento);
    $clase = '';
    if( ($time_vencimiento <= $time_actual ) ){
      
      $clase = '#f2dede';
           
    }elseif(($time_actual <= $time_vencimiento) && ($time_vencimiento <= $un_mes)){
         
         $clase = '#fcf8e3';

    }elseif(($time_actual <= $time_vencimiento) && ($time_vencimiento <= $dos_meses)){
        
        $clase = '#d9edf7';

    }elseif(($time_actual <= $time_vencimiento) && ($time_vencimiento <= $dos_meses)){
    
         $clase = '#dff0d8';
    }

?>
    <tr style="background-color: <?= $clase?>;">
       
       <td style="text-align: center;"><?= $value->vencimiento?></td>
       <td style="text-align: center;"><?php echo Html::a($value->serie,Yii::$app->request->baseUrl.'/arma/view?id='.$value->id);?></td>
       <td style="text-align: center;"><?= $value->tipo->nombre?></td>
       <td style="text-align: center;"><?= $value->calibre->nombre?></td>
       <td style="text-align: center;"><?= $value->permiso->nombre?></td>
       <td style="text-align: center;"><?= $value->salvoconducto?></td>
       <td style="text-align: center;"><?= $value->municion?></td>
       <td style="text-align: center;">
        <?php 
          $ciudad=Arma::CiudadArma($value->id); 

          echo $ciudad['nombre'];
        ?>
        
       </td>
       <td style="text-align: center;">
        <?php 
          echo $ciudad['Sucursal'];
        ?>
        
       </td>
       <td style="text-align: center;"><?=Html::a('<i class="fa fa-eye fa-fw"></i>',Yii::$app->request->baseUrl.'/arma/viewpdf?id=http://181.49.3.226:1580'.Yii::$app->request->baseUrl.$value->archivo,['title' => 'Ver','class'=>'btn btn-info btn-sm'])?></td>       
       <td style="text-align: center;"><?php
                echo Html::a('<i class="fa fa-pencil fa-fw"></i>',Yii::$app->request->baseUrl.'/arma/update?id='.$value->id,['class'=>'btn btn-primary btn-sm']);
                echo Html::a('<i class="fa fa-remove"></i>',Yii::$app->request->baseUrl.'/arma/delete?id='.$value->id,['class'=>'btn btn-danger btn-sm']);

            ?></td>
              

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


