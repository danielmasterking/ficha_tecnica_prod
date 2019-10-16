<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PermisoRol */

$this->title = 'Update Permiso Rol: ' . ' ' . $model->rol_id;
$this->params['breadcrumbs'][] = ['label' => 'Permiso Rols', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->rol_id, 'url' => ['view', 'rol_id' => $model->rol_id, 'permiso_id' => $model->permiso_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="permiso-rol-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
