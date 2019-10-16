<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\ObservacionVtecnica */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="observacion-vtecnica-form">

    <?php $form = ActiveForm::begin([
        
         'options'=>['enctype'=>'multipart/form-data'] // important
        
    ]); ?>

    <?php

       echo Html::activeHiddenInput($model,'vtecnica_id',['value' => $vtecnica_id]);

    ?>

    <?php
     // Usage with ActiveForm and model
     echo $form->field($model, 'image2')->widget(FileInput::classname(), [
    //'options' => ['accept' => 'image/*'],
    'pluginOptions'=>['allowedFileExtensions'=>['jpg','png']]
     ]);

     ?>

    <?= $form->field($model, 'descripcion')->textArea(['rows' => '6'])  ?>

    <?= $form->field($model, 'elemento')->dropDownList(['ILUMINACION' => 'ILUMINACION', 'CONTROL ACCESO' => 'CONTROL ACCESO','PERIMETRAL' => 'PERIMETRAL','CERRADURA' => 'CERRADURA']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Agregar' : 'Actualizar', ['class' =>  'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
