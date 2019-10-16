<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\Preaviso */
/* @var $form yii\widgets\ActiveForm */
//var_dump($cantidad);
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
               <?php
                     }
               ?>
       
                <li ><?php echo Html::a('<i class="fa fa-check fa-fw"></i>Prorrogas',Yii::$app->request->baseUrl.'/prorroga/index');?></li>
               
               <?php

                 if($_SESSION['rol'] == 'Administrador'){
               ?>
                <li ><?php echo Html::a('<i class="fa fa-users fa-fw"></i>Usuarios',Yii::$app->request->baseUrl.'/usuario/index');?></li>
               <?php
                     }
               ?>
                <li><?php echo Html::a('<i class="fa fa-sign-out fa-fw"></i>Salir',Yii::$app->request->baseUrl.'/site/logout');?></li>
                
            </ul>
        </div>  
<div class="col-md-10 well">
<div class="preaviso-form check-form">
<?php $form = ActiveForm::begin(['class' => 'check-form']); ?>

<div class="form-group">
        
        
        <?= Html::textInput('dias','',['class' => 'top-textbox','placeholder'=> '# de días']) ?>
        <?= Html::submitButton('Consultar', ['class' => 'btn btn-primary','name'=>'consultar']) ?>
        <?= Html::submitButton('Generar Cartas', ['class' => 'btn btn-primary','name' =>'generar']) ?>
        
        <span style="float: right;" title="No se ha generado Carta" class="glyphicon glyphicon-remove" aria-hidden="true"></span>
        <span style="float: right;" title="Carta generada en los últimos 30 días" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
 </div>

<table class="table">

  <thead>
  	
  	<tr>

  	   <th><?= Html::checkBox(null,false, ['class' => 'check-all'])?></th>
  	   <th>Cédula</th>
       <th>Nombre</th>
  	   <th>Ubicación</th>
       <th>Fecha finalización</th>
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

