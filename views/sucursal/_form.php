<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Sucursal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sucursal-form">

    <?php $form = ActiveForm::begin(); ?>

    

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'direccion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nit')->textInput() ?>

    <?= $form->field($model, 'ciudad_id')->textInput() ?>

    <div class="form-group">
       <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' =>  'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
