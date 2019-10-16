<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Preaviso */
/* @var $form yii\widgets\ActiveForm */
//var_dump($cantidad);


if(isset($sql)){

 //  var_dump($sql);
}



$rol = '';

if (isset(Yii::$app->session['rol'])) {
    
    $rol = Yii::$app->session['rol']; 

}



?>
<div class="container" style="margin-top:50px;">
    <div class="row">
        <div class="col-md-2">
            <ul class="nav nav-pills nav-stacked">
                
                <li ><?php echo Html::a('<i class="fa fa-home fa-fw"></i>Home',Yii::$app->request->baseUrl.'/site/start');?></li>
               <?php

                 if($rol == 'Administrador' || $rol == 'Recursos'){
               ?>
                <li ><?php echo Html::a('<i class="fa fa-file-pdf-o fa-fw"></i>Cartas',Yii::$app->request->baseUrl.'/preaviso/index');?></li>
               <li ><?php echo Html::a('<i class="fa fa-cloud-upload fa-fw"></i>Adjuntos',Yii::$app->request->baseUrl.'/adjunto/create');?></li>
               <li class="active" ><?php echo Html::a('<i class="fa fa-list fa-fw"></i>Reclamos Nómina',Yii::$app->request->baseUrl.'/reclamo/index');?></li>
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
<div class="form-group">

<?= Html::a('<i class="fa fa-plus"></i>',Yii::$app->request->baseUrl.'/reclamo/create',['class'=>'btn btn-primary']) ?>
    
</div>
<?php $form = ActiveForm::begin(['class' => 'check-form']); ?>

<h2 style="text-align: center;">Reclamos</h2>

<table class="table" style="margin-top:10px;">

  <thead>
  	
  	<tr>

  	   
  	   <th>Nro</th>

       <th>Fecha Reclamo</th>
  	   <th>Nombre</th>
       <th>Puesto</th>
       <th>Acción</th>
       <th>Fecha finalización</th>
       <th></th>
       


  	</tr>


  </thead>

  <tbody>
	
<?php
  
  /*Iterar posibles personas de preaviso.*/
  $index = 0;
  foreach ($reclamos as $key) {
?>
    <tr>
       <td><?= $key->id?></td>
       <td><?=$key->fecha_reclamo?></td>
       <td><?=$key->nombre?></td>
       <td><?=$key->puesto?></td>
       
       <td><?=$key->accion_correctiva?></td>
       
       <td><?= $key->fecha_solucion ?> </td>
    	 <td><?php echo Html::a('<i class="fa fa-pencil fa-fw"></i>',Yii::$app->request->baseUrl.'/reclamo/update?id='.$key->id);?></td>
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

