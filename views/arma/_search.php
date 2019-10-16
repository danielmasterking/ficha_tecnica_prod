<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ArmaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="arma-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'serie') ?>

    <?= $form->field($model, 'vencimiento') ?>

    <?= $form->field($model, 'calibre_id') ?>

    <?= $form->field($model, 'tipo_arma_id') ?>

    <?php // echo $form->field($model, 'permiso_arma_id') ?>

    <?php // echo $form->field($model, 'archivo') ?>

    <?php // echo $form->field($model, 'salvoconducto') ?>

    <?php // echo $form->field($model, 'estado') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
