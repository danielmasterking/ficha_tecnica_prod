<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Memoria */

$this->title = 'Update Memoria: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Memorias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="memoria-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'sucursales' => $sucursales,
        'nit' => $nit,
    ]) ?>

</div>
