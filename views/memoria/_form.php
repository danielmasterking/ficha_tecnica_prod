<?php
use kartik\widgets\DepDrop ;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;
use kartik\widgets\FileInput;
use app\models\Cliente;
use yii\web\JsExpression;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\Memoria */
/* @var $form yii\widgets\ActiveForm */

$data = array();
$tamano_sucursales_usuario = count($sucursales_usuario);
$tamano_ciudades_usuario = count($ciudades_usuario);
       
        //\yii\helpers\VarDumper::dump($tamano_sucursales_usuario);
       
      

foreach ($sucursales as $key ) {

    if($tamano_sucursales_usuario == 0){
        
       // \yii\helpers\VarDumper::dump($ciudades_usuario); 
        if(in_array($key->ciudad_id, $ciudades_usuario)){
             
             $data[$key->id] = $key->nombre;

        }

        

    }else{

        if(in_array($key->id, $sucursales_usuario)){

          $data[$key->id] = $key->nombre;

        }

    }    
    
}


?>

<div class="memoria-form">

    <?php $form = ActiveForm::begin([

        'options'=>['enctype'=>'multipart/form-data'] // important


    ]); ?>

    <?php
     
      echo $form->field($model, 'fecha')->widget(DateControl::classname(), [
      'displayFormat' => 'php:d-M-Y',
      'type'=>DateControl::FORMAT_DATE
       ]);
    ?>


   

        <?php

                // Child # 1
          echo $form->field($model, 'sucursal_id')->widget(Select2::classname(), [

            'data' => $data,
            
          ]);


    ?>

    

     <?php
     // Usage with ActiveForm and model
     echo $form->field($model, 'image2')->widget(FileInput::classname(), [
    //'options' => ['accept' => 'image/*'],
    'pluginOptions'=>['allowedFileExtensions'=>['pdf']]
     ]);

     ?>

    <?= $form->field($model, 'descripcion')->textArea(['rows' => '6'])  ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' =>  'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
