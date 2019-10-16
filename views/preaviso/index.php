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

$ciudad = array();

$cedula = '';

if(isset(Yii::$app->session['ced'])){

  
  $cedula = Yii::$app->session['ced'];


}



if(isset($ciudades_actuales)){

  foreach ($ciudades_actuales as $key ) {
    
    $ciudad[$key->ciudad->ciudad] = $key->ciudad->ciudad;
  }

}

$empleado_array = array();

foreach ($empleados as $key => $value) {
  
  $empleado_array[$value['terv_codigo']] = $value['terc_nombre'];
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
                <li class="active"><?php echo Html::a('<i class="fa fa-file-pdf-o fa-fw"></i>Cartas',Yii::$app->request->baseUrl.'/preaviso/index');?></li>
               <li ><?php echo Html::a('<i class="fa fa-cloud-upload fa-fw"></i>Adjuntos',Yii::$app->request->baseUrl.'/adjunto/create');?></li>
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
        
      <div class="col-md-9">
          
       <?= Html::textInput('dias','',['class' => 'top-textbox col-md-2','placeholder'=> '# de días','style' => 'marging-right:2%;']) ?>
        
        <p class="col-md-1" style="width: 1.33333333%;"></p>
        
        <?= Html::textInput('cedula',null,['class' => 'top-textbox col-md-2','placeholder'=> 'Cédula','style' => 'marging-right:2%;']) ?>
        
        <p class="col-md-1" style="width: 1.33333333%;"></p>

        <?php 
          echo Select2::widget([
          'name' => 'ciudad', 
          'data' => $ciudad,
          'options' => [
          'multiple' => false,
          'style' => 'width:20%;marging-right:15px;',
          'class' => 'col-md-2',
          
         ],
         ]);

        ?>

         <p class="col-md-1" style="width: 1.33333333%;"></p>

         <?php 
          echo Select2::widget([
          'name' => 'empleado', 
          'data' => $empleado_array,
          'options' => [
          'multiple' => false,
          'style' => 'width:25%;marging-right:5px;',
          'class' => 'col-md-2',
          'placeholder' => 'seleccione empleado',
          
         ],
         ]);

        ?>

        </div>

        <div class="col-md-3">

        <?= Html::submitButton('Consultar', ['class' => 'btn btn-primary col-md-5 ','name'=>'consultar']) ?>
         <p class="col-md-1" style="width: 1.33333333%;"></p>
        <?= Html::submitButton('Generar', ['class' => 'btn btn-primary col-md-5','name' =>'generar']) ?>

          

        </div>
        
        <span style="float: right;" title="No se ha generado Carta" class="glyphicon glyphicon-remove" aria-hidden="true"></span>
        <span style="float: right;" title="Carta generada en los últimos 30 días" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
 </div>

<table class="table" style="margin-top:10px;">

  <thead>
  	
  	<tr>

  	   <th><?= Html::checkBox(null,false, ['class' => 'check-all'])?></th>
  	   <th>Cédula</th>
       <th>Nombre</th>
  	   <th>Ubicación</th>
       <th>Fecha finalización</th>
       <th></th>
       <th></th>


  	</tr>


  </thead>

  <tbody>
	
<?php
  
  /*Iterar posibles personas de preaviso.*/
  $index = 0;
  foreach ($preavisos as $key => $value) {
?>
    <tr>
       <td><?= Html::checkBox('nits[]',false, ['value' => $value['terv_codigo']])?></td>
       <td><?=$value['terc_nit']?></td>
       <td><?=$value['terc_nombre']?></td>
       <td><?=$value['ubic_nombre']?></td>
       <td><?=$value['terf_contrato']?></td>
       <td><?=Html::a('<span title="Consultar Adjuntos" class="glyphicon glyphicon-file" aria-hidden="true"></span>',Yii::$app->request->baseUrl.'/adjunto/view?id='.$value['terc_nit'],['title' => 'Descargar'])?></td>
       
       <td><?php 

            $val = $cantidad[$index] > 0 ? '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>' :
                                           '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
             
             echo $val;
           ?>
       </td>
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

