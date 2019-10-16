<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\HistoricoArma */

$this->title = 'Update Historico Arma: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Historico Armas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="historico-arma-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
