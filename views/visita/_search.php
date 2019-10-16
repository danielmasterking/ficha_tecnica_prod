<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VisitaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="visita-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'fecha') ?>

    <?= $form->field($model, 'sucursal_id') ?>

    <?= $form->field($model, 'novedad_id') ?>

    <?= $form->field($model, 'comentarios') ?>

    <?php // echo $form->field($model, 'recomendaciones') ?>

    <?php // echo $form->field($model, 'compromiso_colviseg') ?>

    <?php // echo $form->field($model, 'compromiso_cliente') ?>

    <?php // echo $form->field($model, 'usuario') ?>

    <?php // echo $form->field($model, 'contacto') ?>

    <?php // echo $form->field($model, 'cargo') ?>

    <?php // echo $form->field($model, 'vigilante') ?>

    <?php // echo $form->field($model, 'email_cliente') ?>

    <?php // echo $form->field($model, 'telefono') ?>

    <?php // echo $form->field($model, 'reporta') ?>

    <?php // echo $form->field($model, 'email_reportante') ?>

    <?php // echo $form->field($model, 'estado_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
