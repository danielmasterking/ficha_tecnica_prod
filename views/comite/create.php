<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Comite */

$this->title = 'Create Comite';
$this->params['breadcrumbs'][] = ['label' => 'Comites', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comite-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
