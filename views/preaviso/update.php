<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Preaviso */

$this->title = 'Update Preaviso: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Preavisos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="preaviso-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
