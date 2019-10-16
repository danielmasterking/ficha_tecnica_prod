<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $model app\models\Festivo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="festivo-form">


    <?php $form = ActiveForm::begin(); ?>

   <div class="form-group">
   
      <?= Html::a('<i class="fa fa-arrow-left"></i>',Yii::$app->request->baseUrl.'/site/indicadores',['class'=>'btn btn-primary ']) ?>
        
   </div>


    <?php
      echo $form->field($model, 'fecha')->widget(DateControl::classname(), [
      'displayFormat' => 'php:d-M-Y',
      'type'=>DateControl::FORMAT_DATE
       ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton('Crear' , ['class' =>  'btn btn-primary']) ?>
    </div>


    <?php ActiveForm::end(); ?>

        <h3 style="text-align: center;">Festivos</h3>

    <table class="display my-data" data-page-length='50' cellspacing="0" width="100%">

       <thead>

        <tr>
        	
        	<th>Fecha</th>
        	<th></th>
        </tr>
       	

       </thead>

       <tbody>

             <?php

               foreach ($festivos as $key) {

               	?>

               	<tr>
               		<td><?=$key->fecha?></td>
               		<td><?=Html::a('<i class="fa fa-remove fa-fw"></i>',Yii::$app->request->baseUrl.'/festivo/delete?id='.$key->id,['data' => ['method' => 'post', 'confirm' => '¿Desea Eliminar?']]); ?></td>

               	</tr>


               	<?php
               	
               }

             ?>
       	
       </tbody>

    </table>


</div>
