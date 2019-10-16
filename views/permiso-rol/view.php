<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PermisoRol */

$this->title = $model->rol_id;
$this->params['breadcrumbs'][] = ['label' => 'Permiso Rols', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="permiso-rol-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'rol_id' => $model->rol_id, 'permiso_id' => $model->permiso_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'rol_id' => $model->rol_id, 'permiso_id' => $model->permiso_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'rol_id',
            'permiso_id',
        ],
    ]) ?>

</div>
