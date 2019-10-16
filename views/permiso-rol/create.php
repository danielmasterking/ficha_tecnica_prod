<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PermisoRol */

$this->title = 'Create Permiso Rol';
$this->params['breadcrumbs'][] = ['label' => 'Permiso Rols', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="permiso-rol-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
