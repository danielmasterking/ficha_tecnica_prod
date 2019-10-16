<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Novedad */
/* @var $form yii\widgets\ActiveForm 
 <?= $form->field($model, 'tecnica')->textInput(['maxlength' => true]) ?>
*/
?>

<div class="novedad-form">

    <?php $form = ActiveForm::begin(); ?>

    

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tipo')->dropDownList(['R' => 'Reporte Diario', 'V' => 'Visitas','A' => 'Armas']) ?>

    <?= $form->field($model, 'estado')->dropDownList(['A' => 'ACTIVA', 'I' => 'INACTIVA']) ?>
    
    <?= $form->field($model, 'tecnica')->dropDownList(['N' => 'NO', 'S' => 'SI']) ?>


    

    <div class="form-group">
       <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' =>  'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
