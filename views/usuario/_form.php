<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */
/* @var $form yii\widgets\ActiveForm */
//$form->field($model, 'status')->textInput(['maxlength' => true])

$ids_roles = array();

if(isset($roles_actuales)){

    foreach ($roles_actuales as $key => $value) {
        $ids_roles [] = $value['rol_id'];
    }

}

$ids_cc = array();

if(isset($centros_actuales)){

    foreach ($centros_actuales as $key => $value) {
        $ids_cc [] = $value['ccosto_id'];
    }

}

$ids_ciudades = array();

if(isset($ciudades_actuales)){

    foreach ($ciudades_actuales as $key => $value) {
        $ids_ciudades [] = $value['ciudad_id'];
    }

}


?>

<div class="usuario-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group col-md-offset-10">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' =>  'btn btn-primary']) ?>
    </div>

    <?= $form->field($model, 'usuario')->textInput(['maxlength' => true]) ?>

    <?php
       if($model->isNewRecord){

          echo $form->field($model, 'password')->passwordInput(['maxlength' => true]); 
       }
       
    ?>

    

    <?= $form->field($model, 'nombres')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'apellidos')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tipo')->dropDownList(['E' => 'Empleado', 'C' => 'Cliente','J' => 'Junta Directiva']) ?>
    
    <?= $form->field($model, 'status')->dropDownList(['A' => 'Activo', 'I' => 'Inactivo']) ?>

    <?= $form->field($model, 'todos_clientes')->dropDownList(['N' => 'NO', 'S' => 'SI']) ?>

    <div class="roles">

          <table class="table">

              <thead>

                   <th><?= Html::checkBox(null,false, ['class' => 'check-all'])?></th>
                   <th>Roles</th> 
                  
              </thead>

              <tbody>

                 <?php foreach($roles as $key => $value):?>

                      <?php if(isset($roles_actuales) && count($roles_actuales) > 0 
                               && in_array($value['id'], $ids_roles)):?>


                            <tr>

                                <td><?= Html::checkBox('roles_array[]',true, ['value' => $value['id']])?></td>
                                <td><?=$value['nombre']?></td>
                             </tr>

                      <?php else:?>


                            <tr>

                                <td><?= Html::checkBox('roles_array[]',false, ['value' => $value['id']])?></td>
                                <td><?=$value['nombre']?></td>
                             </tr>




                       <?php endif;?>        
                   


                 <?php endforeach; ?>   

                  

              </tbody>
              

          </table>


        

    </div>

    <div class="row bottom">

          <div class="col-md-offset-9 col-sm-offset-9 col-xs-offset-9">

              <input type="checkbox" id="toggle-two" checked>
            
           </div>
      

    </div>

    <div id="ccostos" >

      <table class="table" >

        <thead>
        <th><?= Html::checkBox(null,false, ['class' => 'check-all'])?></th>
        <th>Centro</th>


        
        </thead>

           <tbody>

            <?php foreach($centros as $key => $value):?>

              <?php if(isset($centros_actuales) && count($centros_actuales) > 0 
                               && in_array($value['id'], $ids_cc)):?>


                            <tr>

                                <td><?= Html::checkBox('centros_array[]',true, ['value' => $value['id']])?></td>
                                <td><?=$value['nombre']?></td>
                             </tr>

              <?php else:?>


                            <tr>

                                <td><?= Html::checkBox('centros_array[]',false, ['value' => $value['id']])?></td>
                                <td><?=$value['nombre']?></td>
                             </tr>




                <?php endif;?>        
                   


           


            <?php endforeach;?>
             

           </tbody>
          

        </table> 
      

    </div>

    <div id="ciudades" class="hidden">

      <table class="table">

        <thead>
        <th><?= Html::checkBox(null,false, ['class' => 'check-all'])?></th>
        <th>Nombre</th>


          

        </thead>

           <tbody>

            <?php foreach($ciudades as $key => $value):?>

              
              <?php if(isset($ciudades_actuales) && count($ciudades_actuales) > 0 
                               && in_array($value['id'], $ids_ciudades)):?>


                            <tr>

                                <td><?= Html::checkBox('ciudades_array[]',true, ['value' => $value['id']])?></td>
                                <td><?=$value['nombre']?></td>
                             </tr>

              <?php else:?>


                            <tr>

                                <td><?= Html::checkBox('ciudades_array[]',false, ['value' => $value['id']])?></td>
                                <td><?=$value['nombre']?></td>
                             </tr>




                <?php endif;?>        


            <?php endforeach;?>
             

           </tbody>
          

        </table> 
   

    </div>

    



    <?php ActiveForm::end(); ?>

</div>
