<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $model app\models\Reclamo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reclamo-form">

    <?php $form = ActiveForm::begin(); ?>

     <?php
      echo $form->field($model, 'fecha_reclamo')->widget(DateControl::classname(), [
      'displayFormat' => 'php:d-M-Y',
      'type'=>DateControl::FORMAT_DATE
       ]);
    ?>

    
    <?= $form->field($model, 'nombre')->textInput(['maxlength' => 80]) ?>
    <?= $form->field($model, 'puesto')->textInput(['maxlength' => 80]) ?>
    <?php if(isset($actualizar)):?>
    <?= $form->field($model, 'accion_correctiva')->textInput(['maxlength' => 500]) ?>
    <?php endif;?>
    <?php if(isset($actualizar)):?>
     <?php
      echo $form->field($model, 'fecha_solucion')->widget(DateControl::classname(), [
      'displayFormat' => 'php:d-M-Y',
      'type'=>DateControl::FORMAT_DATE
       ]);

    ?>
    <?php endif;?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' =>  'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
