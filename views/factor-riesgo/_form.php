<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;
use kartik\widgets\FileInput;


/* @var $this yii\web\View */
/* @var $model app\models\FactorRiesgo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="factor-riesgo-form">

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

       echo Html::activeHiddenInput($model,'sucursal_id',['value' => $sucursal_id]);

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
