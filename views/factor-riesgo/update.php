<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FactorRiesgo */

$this->title = 'Update Factor Riesgo: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Factor Riesgos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="factor-riesgo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'sucursal_id' => $id,
    ]) ?>

</div>
