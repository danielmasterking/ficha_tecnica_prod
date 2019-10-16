<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ReporteDiarioSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reporte-diario-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'reporte_id') ?>

    <?= $form->field($model, 'sucursal_id') ?>

    <?= $form->field($model, 'fecha_registro') ?>

    <?= $form->field($model, 'novedad_id') ?>

    <?php // echo $form->field($model, 'hora') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
