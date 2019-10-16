<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Preaviso */
/* @var $form yii\widgets\ActiveForm */
//var_dump($cantidad);

$cedulas_empleados = array();

if(isset($cedulas)){

  foreach ($cedulas as $key => $value ) {
    
    $cedulas_empleados[$value['cedula']] = $value['cedula'];
  }

}


$rol = '';

if (isset(Yii::$app->session['rol'])) {
    
    $rol = Yii::$app->session['rol']; 

}



?>
<div class="container" style="margin-top:5px;padding-top:5px;">
    <div class="row">
        <div class="col-md-2">
            <ul class="nav nav-pills nav-stacked">
                
                <li ><?php echo Html::a('<i class="fa fa-home fa-fw"></i>Home',Yii::$app->request->baseUrl.'/site/start');?></li>
               <?php

                 if($rol == 'Administrador' || $rol == 'Recursos'){
               ?>
                <li ><?php echo Html::a('<i class="fa fa-file-pdf-o fa-fw"></i>Cartas',Yii::$app->request->baseUrl.'/preaviso/index');?></li>
               <li class="active"><?php echo Html::a('<i class="fa fa-cloud-upload fa-fw"></i>Adjuntos',Yii::$app->request->baseUrl.'/adjunto/create');?></li>
               <li  ><?php echo Html::a('<i class="fa fa-list fa-fw"></i>Reclamos Nómina',Yii::$app->request->baseUrl.'/reclamo/index');?></li>
               <?php
                     }
               ?>
       
                <li ><?php echo Html::a('<i class="fa fa-check fa-fw"></i>Prorrogas',Yii::$app->request->baseUrl.'/prorroga/index');?></li>
               
               <?php

                 if($_SESSION['rol'] == 'Administrador'){
               ?>
                <li ><?php echo Html::a('<i class="fa fa-users fa-fw"></i>Usuarios',Yii::$app->request->baseUrl.'/usuario/index');?></li>
                <li ><?php echo Html::a('<i class="fa fa-flag fa-fw"></i>Ciudades',Yii::$app->request->baseUrl.'/ciudad/index');?></li>
               <?php
                     }
               ?>
                <li><?php echo Html::a('<i class="fa fa-sign-out fa-fw"></i>Salir',Yii::$app->request->baseUrl.'/site/logout');?></li>
                
            </ul>
        </div>  
<div class="col-md-10 well">
<div class="preaviso-form check-form">
<?php $form = ActiveForm::begin(['class' => 'check-form']); ?>

<div class="row">
        
      <p class="col-md-3"></p>  
      <h1 class="col-md-7">Consulta de Adjuntos</h1>

      <div class="col-md-8">

          
        <?php

         
          echo Select2::widget([
          'name' => 'cedula', 
          'data' => $cedulas_empleados,
          'options' => [
          'placeholder' => 'Seleccione Cedula', 
          'multiple' => false,
          'style' => 'width:30%;marging-right:15px;',
          'class' => 'col-md-2',
          
         ],
         ]);

        ?>

        </div>

        <div class="col-md-4">

        <?= Html::submitButton('Consultar', ['class' => 'btn btn-primary ','name'=>'consultar']) ?>
    
        </div>
        
 </div>

<table class="table" style="margin-top:10px;">

  <thead>
    
    <tr>

       <th>Fecha de Subida al Sistema</th>
       <th></th>


    </tr>


  </thead>

  <tbody>
    
<?php


  
  /*Iterar posibles personas de preaviso.*/
  $index = 0;
  foreach ($adjuntos as $key => $value) {
?>
    <tr>
       <td><?=$value['fecha']?></td>
       <td><?=Html::a('<i class="fa fa-download fa-fw"></i>',Yii::$app->request->baseUrl.$value['image'],['download' => 'firma','title' => 'Descargar'])?></td>
         <?php
          $index++;
       ?>

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

