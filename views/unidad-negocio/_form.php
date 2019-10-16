<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\UnidadNegocio */
/* @var $form yii\widgets\ActiveForm */

$data = array();
foreach ($clientes as  $value) {
  
  $data[$value->nit] = $value->nombre;
}

?>

<div class="unidad-negocio-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
    
    <?php
       
       echo $form->field($model, 'cliente')->widget(Select2::classname(), [
				    'data' => $data,
				    'options' => ['placeholder' => 'Seleccione cliente'],
				    'pluginOptions' => [
				        'allowClear' => true
				    ],
				]);

    ?> 


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' =>  'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
