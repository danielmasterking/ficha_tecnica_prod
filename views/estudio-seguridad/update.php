<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EstudioSeguridad */

$this->title = 'Update Estudio Seguridad: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Estudio Seguridads', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="estudio-seguridad-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
