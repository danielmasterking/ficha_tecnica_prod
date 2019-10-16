<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */
/* @var $form yii\widgets\ActiveForm */
  $ids = array();

if(isset($ciudades_actuales)){

    foreach ($ciudades_actuales as $key => $value) {
      
      $ids [] = $value['ciudad_id'];
  }


}


  

?>

<div class="usuario-form">

    <?php $form = ActiveForm::begin(); ?>

    

    <?= $form->field($model, 'usuario')->textInput(['maxlength' => 25,'readonly'=>'readonly']) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => 80]) ?>

    <?= $form->field($model, 'apellidos')->textInput(['maxlength' => 80]) ?>

    <?= $form->field($model, 'nombres')->textInput(['maxlength' => 80]) ?>

    <?php echo $form->field($model, 'rol_id')->widget(Select2::classname(),[
         'data'=>ArrayHelper::map($roles,'id','nombre'),
         'options' => ['multiple' => false, 'placeholder' => '------Rol-----']

    ]); ?>

    <div class="form-group preaviso-form">

        <table class="table">

        <thead>
        
           <th><?= Html::checkBox(null,false, ['class' => 'check-all'])?></th>
           <th>Ubicaciones permitidas</th>
       

        </thead>
         
         <tbody>


        <?php

           foreach ($ciudades as $key => $value) {

            if(isset($ciudades_actuales) && count($ciudades_actuales) > 0 && in_array($value['id'], $ids)){

        ?>

           <tr>

               <td><?= Html::checkBox('ubicaciones[]',true, ['value' => $value['id']])?></td>
               <td><?=$value['ciudad']?></td>
             </tr>


         <?php



            }else{      

        ?> 
             
             <tr>

               <td><?= Html::checkBox('ubicaciones[]',false, ['value' => $value['id']])?></td>
               <td><?=$value['ciudad']?></td>
             </tr>
        <?php
          
             }
           }

        ?>
             


         </tbody>


            


        </table>


        


    </div>
   

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' =>  'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
