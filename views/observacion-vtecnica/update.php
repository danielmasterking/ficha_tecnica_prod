<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ObservacionVtecnica */

$this->title = 'Update Observacion Vtecnica: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Observacion Vtecnicas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="observacion-vtecnica-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
