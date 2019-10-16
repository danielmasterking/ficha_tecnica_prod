<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;
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
               <li class="active"><?php echo Html::a('<i class="fa fa-users fa-fw"></i>Reporte Diario',Yii::$app->request->baseUrl.'/reporte-diario-enc/index');?></li>
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
<div class="preaviso-form check-form">

<div class="form-group">

    <?= Html::a('<i class="fa fa-list"></i> Consolidado de novedades',Yii::$app->request->baseUrl.'/reporte-diario/consolidar',['class'=>'btn btn-primary']) ?>
        
</div>


<?php $form = ActiveForm::begin(['class' => 'check-form']); ?>



   <div class="col-md-12">

      <div class="col-md-4">

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

      <div class="col-md-4">

           <?php


             echo DateControl::widget([
            'name'=>'fecha_final', 
            'type'=>DateControl::FORMAT_DATE,
            'autoWidget' => true,
            
            'displayFormat' => 'php:Y-m-d',
            'saveFormat' => 'php:Y-m-d'

        ]);



           ?>      

      </div>

      <div class="col-md-4">

        <input type="submit" name="consultar" class="btn btn-primary" value="Consultar" />

      </div>        
        

      </div>




     

   
     
   </div>

<p>&nbsp;</p>

<h1 style="text-align: center;">Reporte Diario</h1>

<p>&nbsp;</p>
<div class="table-responsive"> 
<table class="table my-data" data-page-length='50'>

  <thead>
    
    <tr>

       <th>Fecha</th>
       <th>Usuario</th>
       <th>Novedades</th>
       <th>Estado</th>
       <th></th>
       
       
    </tr>


  </thead>

  <tbody>
    
<?php
  
  foreach ($reportes as  $value) {
?>
    <tr>
       
       <td><?=$value->fecha?></td>
       <td><?=$value->usuario?></td>
       <td><?=$value->count?></td>
       <td><?=$value->estado->nombre?></td>
       
       <td><?php
            
            /*Volver timestamp fecha de reporte diario*/
            $reporte_time = strtotime($value->fecha);
            //echo $reporte_time.'-'.$lower_time;

           /*validar que la fecha del reporte se encuentre en el rango de las 72  horas para permanecer vigente*/
  
              echo Html::a('<i class="fa fa-eye fa-fw"></i>',Yii::$app->request->baseUrl.'/reporte-diario/index?id='.$value->id);
              
              if($reporte_time >= $lower_time){
                 echo Html::a('<i class="fa fa-pencil fa-fw"></i>',Yii::$app->request->baseUrl.'/reporte-diario/create?id='.$value->id);
              }
                 
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


