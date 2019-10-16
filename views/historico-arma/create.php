<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\HistoricoArma */

$this->title = 'Create Historico Arma';
$this->params['breadcrumbs'][] = ['label' => 'Historico Armas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="historico-arma-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
