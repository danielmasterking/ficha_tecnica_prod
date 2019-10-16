<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ReporteDiario */

$this->title = 'Update Reporte Diario: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Reporte Diarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="reporte-diario-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
