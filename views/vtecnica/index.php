<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VtecnicaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vtecnicas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vtecnica-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Vtecnica', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'visita_id',
            'presentacion',
            'minuta',
            'armamento',
            // 'equipos_seguridad',
            // 'equipos_comunicacion',
            // 'iluminacion',
            // 'acceso',
            // 'perimetro',
            // 'cerraduras',
            // 'consigna_general',
            // 'consigna_particular',
            // 'instrucciones',
            // 'alarmas',
            // 'cctv',
            // 'otros',
            // 'seguridad_industrial',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
