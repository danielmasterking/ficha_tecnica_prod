<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Visita */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Visitas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="visita-view">

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
            'fecha',
            'sucursal_id',
            'novedad_id',
            'comentarios',
            'recomendaciones',
            'compromiso_colviseg',
            'compromiso_cliente',
            'usuario',
            'contacto',
            'cargo',
            'vigilante',
            'email_cliente:email',
            'telefono',
            'reporta',
            'email_reportante:email',
            'estado_id',
        ],
    ]) ?>

</div>
