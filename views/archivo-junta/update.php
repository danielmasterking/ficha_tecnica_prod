<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ArchivoJunta */

$this->title = 'Update Archivo Junta: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Archivo Juntas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="archivo-junta-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
