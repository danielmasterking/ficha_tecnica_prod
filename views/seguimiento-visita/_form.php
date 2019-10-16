<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;


/* @var $this yii\web\View */
/* @var $model app\models\SeguimientoVisita */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="seguimiento-visita-form">

    <?php $form = ActiveForm::begin(); ?>

    

   

     <?php
      echo $form->field($model, 'fecha')->widget(DateControl::classname(), [
      'displayFormat' => 'php:d-M-Y',
      'type'=>DateControl::FORMAT_DATE
       ]);
    ?>


    <?= $form->field($model, 'observacion')->textArea(['rows' => 4]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' =>  'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>