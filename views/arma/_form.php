<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;
use kartik\widgets\FileInput;
use kartik\widgets\Select2;

$data_tipo = array();

foreach ($tipos as $value) {

    $data_tipo[$value->id] = $value->nombre;
}

$data_permiso = array();

foreach ($permisosArmas as $value) {

    $data_permiso[$value->id] = $value->nombre;
}

$data_calibre = array();

foreach ($calibres as $value) {

    $data_calibre[$value->id] = $value->nombre;
}

/* @var $this yii\web\View */
/* @var $model app\models\Arma */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="arma-form">

    <?php $form = ActiveForm::begin([

        'options'=>['enctype'=>'multipart/form-data'] // important


    ]); ?>

    <div class="row">
      <div class="col-md-6">
        <?= $form->field($model, 'serie')->textInput(['maxlength' => true]) ?>
      </div>
      <div class="col-md-6">
        <?=

         $form->field($model, 'tipo_arma_id')->widget(Select2::classname(), [
         'data' => $data_tipo,

        ])


        ?>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
         <?=

           $form->field($model, 'calibre_id')->widget(Select2::classname(), [
           'data' => $data_calibre,

          ])


        ?>
      </div>
      <div class="col-md-6">
          
        <?=

           $form->field($model, 'permiso_arma_id')->widget(Select2::classname(), [
           'data' => $data_permiso,

          ])


        ?>
      </div>
    </div>

    
    <div class="row">
      <div class="col-md-6">
        <?php
        echo $form->field($model, 'vencimiento')->widget(DateControl::classname(), [
        'displayFormat' => 'php:d-M-Y',
        'type'=>DateControl::FORMAT_DATE
         ]);
        ?>
      </div>
      <div class="col-md-6">
        <?php
       // Usage with ActiveForm and model
       echo $form->field($model, 'image2')->widget(FileInput::classname(), [
      //'options' => ['accept' => 'image/*'],
      'pluginOptions'=>['allowedFileExtensions'=>['pdf']]
       ]);

       ?>
      </div>
    </div>
   
    <div class="row">
      <div class="col-md-4">
        <?= $form->field($model, 'salvoconducto')->textInput(['maxlength' => true]) ?>    
      </div>
      <div class="col-md-4">
        <?= $form->field($model, 'estado')->dropDownList(['A' => 'Activa', 'C' => 'Inactiva']) ?>    
      </div>

      <div class="col-md-4">
        <?= $form->field($model, 'municion')->textInput() ?>    
      </div>
    </div>


    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
