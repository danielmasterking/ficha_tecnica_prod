<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;

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
               <li><?php echo Html::a('<i class="fa fa-sign-out fa-fw"></i>Salir',Yii::$app->request->baseUrl.'/site/logout');?></li>                
               
  
            </ul>
        </div>  --> 
<div class="col-md-12 ">

<?php $form = ActiveForm::begin(['class' => 'check-form']); ?>
<div class="form-group">

<?= Html::a('<i class="fa fa-arrow-left"></i>',Yii::$app->request->baseUrl.'/reporte-diario-enc/index',['class'=>'btn btn-primary']) ?>
<?php if(in_array("publicar", $permisos)):?>
<input type="submit" name="publicar" class="btn btn-primary pull-right" value="Publicar" />
<p class="pull-right">&nbsp;</p>
<input type="submit" name="no-publicar" class="btn btn-primary pull-right" value="No Publicar" />

<?php endif;?>

    
</div>



    <h2 style="text-align: center;">Detalle Reporte <?php if(count($reportes) > 0){ echo $reportes[0]->reporte->fecha; }?></h2>
   
    <table  class="table display my-data" data-page-length='10' cellspacing="0" width="100%">

       <thead>

       <tr>
           
           <th><?= Html::checkBox(null,false, ['class' => 'check-all'])?></th>
           <th>Hora</th>
           <th>Cliente</th>
           <th>Sucursal</th>
           <th>novedad</th>
           <th>Observación</th>
           <th>Estado</th>
           <th>Evidencia</th>
           
       </tr>
           

       </thead>
        
        <tbody>

          <?php foreach($reportes as $key => $value):?>
             
             <tr>
             <th><?= Html::checkbox('seleccionadas[]',false,['value' => $value->id])?></th>
             <td><?= $value->hora?></td>
             <td><?= $value->sucursal->cliente->nombre?></td>
             <td><?= $value->sucursal->nombre?></td>
             <td><?= $value->novedad->nombre?></td>
             <td><?= $value->observacion?></td>
             <td><?= $value->estado->nombre?>
                
             </td>
             <td>


              <?php
                 /**********************Rendering Image *******************************/
                  if($value->archivo != null && $value->archivo != ''){

                    /*********************** Validar si es pdf o imagen ********************************/
                    if(strpos($value->archivo, 'pdf') === false){

                        echo ' 
                             <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modal-'.$value->id.'">
                             Mostrar
                             </button>';

                         // echo '<img alt="Evidencia" class="img-responsive img-thumbnail" src="'.Yii::$app->request->baseUrl.$value->archivo.'"/>';
                         Modal::begin([

                          'header' => '<h4>Evidencia</h4>',
                          'id' => 'modal-'.$value->id,
                          'size' => 'modal-lg',

                          ]);


                          //validar si es de app Kontrolid

                          if(strpos($value->archivo, 'kontrolid') === false){

                         echo '<div><img alt="Evidencia" class="img-responsive img-thumbnail" src="'.Yii::$app->request->baseUrl.$value->archivo.'"/></div>';                            


                          }else{


                         echo '<div><img alt="Evidencia" class="img-responsive img-thumbnail" src="'.$value->archivo.'"/></div>';                            
                          }



                         Modal::end();

                    }else{

                       $file = Yii::$app->request->baseUrl.$value->archivo;

                      echo ' 
                             <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modal-'.$value->id.'">
                             Mostrar
                             </button>';

                         // echo '<img alt="Evidencia" class="img-responsive img-thumbnail" src="'.Yii::$app->request->baseUrl.$value->archivo.'"/>';
                         Modal::begin([

                          'header' => '<h4>Evidencia</h4>',
                          'id' => 'modal-'.$value->id,
                          'size' => 'modal-lg',

                          ]);



                            echo '<div id="scroller">
                            <iframe src="http://docs.google.com/gview?url=http://181.49.3.226:1580'.$file.'&embedded=true" width="100%" height="600px" scrolling="auto"> </iframe>
                            </div>';

                         Modal::end();

                     




                    }
                   

                  }
                 /**********************************************************************/

              ?>
               

             </td>
            
             </tr>

          <?php endforeach; ?>

        </tbody>


    </table>

    

    <?php ActiveForm::end(); ?>
   



</div>


