<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SeguimientoVisita */

$this->title = 'Update Seguimiento Visita: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Seguimiento Visitas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="seguimiento-visita-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
