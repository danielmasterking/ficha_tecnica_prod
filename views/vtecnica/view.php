<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Vtecnica */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Vtecnicas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vtecnica-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'id',
            'visita_id',
            'presentacion',
            'minuta',
            'armamento',
            'equipos_seguridad',
            'equipos_comunicacion',
            'iluminacion',
            'acceso',
            'perimetro',
            'cerraduras',
            'consigna_general',
            'consigna_particular',
            'instrucciones',
            'alarmas',
            'cctv',
            'otros',
            'seguridad_industrial',
        ],
    ]) ?>

</div>
