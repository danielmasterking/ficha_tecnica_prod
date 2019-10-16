<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\InformeGestion */

$this->title = 'Update Informe Gestion: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Informe Gestions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="informe-gestion-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
