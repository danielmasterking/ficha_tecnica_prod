<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VtecnicaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vtecnica-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'visita_id') ?>

    <?= $form->field($model, 'presentacion') ?>

    <?= $form->field($model, 'minuta') ?>

    <?= $form->field($model, 'armamento') ?>

    <?php // echo $form->field($model, 'equipos_seguridad') ?>

    <?php // echo $form->field($model, 'equipos_comunicacion') ?>

    <?php // echo $form->field($model, 'iluminacion') ?>

    <?php // echo $form->field($model, 'acceso') ?>

    <?php // echo $form->field($model, 'perimetro') ?>

    <?php // echo $form->field($model, 'cerraduras') ?>

    <?php // echo $form->field($model, 'consigna_general') ?>

    <?php // echo $form->field($model, 'consigna_particular') ?>

    <?php // echo $form->field($model, 'instrucciones') ?>

    <?php // echo $form->field($model, 'alarmas') ?>

    <?php // echo $form->field($model, 'cctv') ?>

    <?php // echo $form->field($model, 'otros') ?>

    <?php // echo $form->field($model, 'seguridad_industrial') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
