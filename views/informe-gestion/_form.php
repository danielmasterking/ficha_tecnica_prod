<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\InformeGestion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="informe-gestion-form">

    <?php $form = ActiveForm::begin([

        'options'=>['enctype'=>'multipart/form-data']

    ]); ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

    <?php
      echo $form->field($model, 'fecha')->widget(DateControl::classname(), [
      'displayFormat' => 'php:d-M-Y',
      'type'=>DateControl::FORMAT_DATE
       ]);
    ?>

     <?php
     // Usage with ActiveForm and model
     echo $form->field($model, 'image2')->widget(FileInput::classname(), [
    //'options' => ['accept' => 'image/*'],
    'pluginOptions'=>['allowedFileExtensions'=>['pdf']]
     ]);

     ?>

    <?= $form->field($model, 'descripcion')->textArea(['rows' => '6']) ?>

    <?= $form->field($model, 'fecha_registro')->hiddenInput(['value' => $fecha_registro])->label(false) ?>

    <?= $form->field($model, 'cliente')->hiddenInput(['value' => $id])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
