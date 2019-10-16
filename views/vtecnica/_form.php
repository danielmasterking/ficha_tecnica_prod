<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Vtecnica */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vtecnica-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'visita_id')->textInput() ?>

    <?= $form->field($model, 'presentacion')->dropDownList(['B' => 'Bueno', 'R' => 'Regular', 'M' => 'Mala']) ?>

    <?= $form->field($model, 'minuta')->dropDownList(['B' => 'Bueno', 'R' => 'Regular', 'M' => 'Mala']) ?>

    <?= $form->field($model, 'armamento')->dropDownList(['B' => 'Bueno', 'R' => 'Regular', 'M' => 'Mala']) ?>

    <?= $form->field($model, 'equipos_seguridad')->dropDownList(['B' => 'Bueno', 'R' => 'Regular', 'M' => 'Mala']) ?>

    <?= $form->field($model, 'equipos_comunicacion')->dropDownList(['B' => 'Bueno', 'R' => 'Regular', 'M' => 'Mala']) ?>

    <?= $form->field($model, 'iluminacion')->dropDownList(['B' => 'Bueno', 'R' => 'Regular', 'M' => 'Mala']) ?>

    <?= $form->field($model, 'acceso')->dropDownList(['B' => 'Bueno', 'R' => 'Regular', 'M' => 'Mala']) ?>

    <?= $form->field($model, 'perimetro')->dropDownList(['B' => 'Bueno', 'R' => 'Regular', 'M' => 'Mala']) ?>

    <?= $form->field($model, 'cerraduras')->dropDownList(['B' => 'Bueno', 'R' => 'Regular', 'M' => 'Mala']) ?>

    <?= $form->field($model, 'consigna_general')->dropDownList(['B' => 'Bueno', 'R' => 'Regular', 'M' => 'Mala']) ?>

    <?= $form->field($model, 'consigna_particular')->dropDownList(['B' => 'Bueno', 'R' => 'Regular', 'M' => 'Mala']) ?>

    <?= $form->field($model, 'instrucciones')->dropDownList(['B' => 'Bueno', 'R' => 'Regular', 'M' => 'Mala']) ?>

    <?= $form->field($model, 'alarmas')->dropDownList(['B' => 'Bueno', 'R' => 'Regular', 'M' => 'Mala']) ?>

    <?= $form->field($model, 'cctv')->dropDownList(['B' => 'Bueno', 'R' => 'Regular', 'M' => 'Mala']) ?>

    <?= $form->field($model, 'otros')->dropDownList(['B' => 'Bueno', 'R' => 'Regular', 'M' => 'Mala']) ?>

    <?= $form->field($model, 'seguridad_industrial')->dropDownList(['B' => 'Bueno', 'R' => 'Regular', 'M' => 'Mala']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' =>  'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
